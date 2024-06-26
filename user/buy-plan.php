<?php
session_start();

// Ensure there's a logged-in user
if (!isset($_SESSION['email'])) {
    header('location:../login.php');
    exit();
}

include('dbcon.php');

$logged_in_email = $_SESSION['email'];

// Fetch the user's total deposit
$sql_get_total_deposit = "SELECT SUM(tdeposit) AS total_deposit FROM transactions WHERE email = ?";
$stmt = $conn->prepare($sql_get_total_deposit);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();

$total_deposit = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_deposit = (float) $row['total_deposit'];
}

$stmt->close();

// Fetch the referrer
$sql_get_referral_code = "SELECT referred_by FROM users WHERE email = ?";
$stmt_referral_code = $conn->prepare($sql_get_referral_code);
$stmt_referral_code->bind_param("s", $logged_in_email);
$stmt_referral_code->execute();
$result_referral_code = $stmt_referral_code->get_result();

$referred_by = null;
$referrer_amount = 0;

if ($result_referral_code->num_rows > 0) {
    $row_referral_code = $result_referral_code->fetch_assoc();
    $referred_by = $row_referral_code['referred_by'];
}

$stmt_referral_code->close();

if ($referred_by) {
    // Fetch the referrer's email based on the referral code
    $sql_get_referrer_email = "SELECT email FROM users WHERE referral_code = ?";
    $stmt_referrer_email = $conn->prepare($sql_get_referrer_email);
    $stmt_referrer_email->bind_param("s", $referred_by);
    $stmt_referrer_email->execute();
    $result_referrer_email = $stmt_referrer_email->get_result();

    if ($result_referrer_email->num_rows > 0) {
        $row_referrer_email = $result_referrer_email->fetch_assoc();
        $referrer_email = $row_referrer_email['email'];

        // Fetch the latest referrer amount from refer_plan table
        $sql_get_latest_referrer_amount = "SELECT amount FROM refer_plan WHERE user_email = ? ORDER BY created_at DESC LIMIT 1";
        $stmt_latest_referrer_amount = $conn->prepare($sql_get_latest_referrer_amount);
        $stmt_latest_referrer_amount->bind_param("s", $referrer_email);
        $stmt_latest_referrer_amount->execute();
        $result_latest_referrer_amount = $stmt_latest_referrer_amount->get_result();

        if ($result_latest_referrer_amount->num_rows > 0) {
            $row_latest_referrer_amount = $result_latest_referrer_amount->fetch_assoc();
            $referrer_amount = (float) $row_latest_referrer_amount['amount'];
        }

        $stmt_latest_referrer_amount->close();
    }

    $stmt_referrer_email->close();
}

// Fetch the latest investment amount for the user
$sql_get_latest_investment_amount = "SELECT amount FROM investments WHERE email = ? ORDER BY created_at DESC LIMIT 1";
$stmt_latest_investment_amount = $conn->prepare($sql_get_latest_investment_amount);
$stmt_latest_investment_amount->bind_param("s", $logged_in_email);
$stmt_latest_investment_amount->execute();
$result_latest_investment_amount = $stmt_latest_investment_amount->get_result();

$latest_investment_amount = 0;

if ($result_latest_investment_amount->num_rows > 0) {
    $row_latest_investment_amount = $result_latest_investment_amount->fetch_assoc();
    $latest_investment_amount = (float) $row_latest_investment_amount['amount'];
}

$stmt_latest_investment_amount->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = isset($_POST['plan']) ? $_POST['plan'] : '';
    $investment_amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;

    $profit_rates = [
        "7 Days" => 0.15,
        "15 Days" => 0.25,
        "1 Month" => 0.50,
        "2 Months" => 1.00,
    ];

    $plan_durations = [
        "7 Days" => 7,
        "15 Days" => 15,
        "1 Month" => 30,
        "2 Months" => 60,
    ];

    if ($plan && $investment_amount > 0 && $investment_amount <= $total_deposit && isset($profit_rates[$plan])) {
        $profit_rate = $profit_rates[$plan];
        $profit = $investment_amount * $profit_rate;
        $duration = $plan_durations[$plan];

        // Check if the user has any previous entries in investments or refer_plan tables
        $sql_check_existing_entries = "
            SELECT 
                (SELECT COUNT(*) FROM investments WHERE email = ?) AS investment_count,
                (SELECT COUNT(*) FROM refer_plan WHERE user_email = ?) AS refer_plan_count
        ";
        $stmt_check_existing_entries = $conn->prepare($sql_check_existing_entries);
        $stmt_check_existing_entries->bind_param("ss", $logged_in_email, $logged_in_email);
        $stmt_check_existing_entries->execute();
        $result_check_existing_entries = $stmt_check_existing_entries->get_result();

        $has_existing_entries = false;
        if ($result_check_existing_entries->num_rows > 0) {
            $row_existing_entries = $result_check_existing_entries->fetch_assoc();
            $has_existing_entries = ($row_existing_entries['investment_count'] > 0 || $row_existing_entries['refer_plan_count'] > 0);
        }

        $stmt_check_existing_entries->close();

        $is_first_investment = !$has_existing_entries;

        // Adjust referral earning based on the latest investment amount and referrer amount
        if ($referrer_amount == 0 || $investment_amount < $referrer_amount || $latest_investment_amount < $referrer_amount) {
            $referral_earning = 1.5;
        } else {
            $referral_earning = $referrer_amount * 0.30;
        }

        // Insert the investment into the database
        $sql_invest = "INSERT INTO investments (email, plan, amount, tamount, profit, created_at, duration, status) VALUES (?, ?, ?, ?, ?, NOW(), ?, 'active')";
        $stmt_invest = $conn->prepare($sql_invest);
        $stmt_invest->bind_param("ssddsd", $logged_in_email, $plan, $investment_amount, $investment_amount, $profit, $duration);

        if ($stmt_invest->execute()) {
            $remaining_deposit = $total_deposit - $investment_amount;

            // Update the latest transaction's tdeposit to reflect the remaining amount after investment
            $sql_update_deposit = "UPDATE transactions SET tdeposit = ? WHERE email = ? ORDER BY created_at DESC LIMIT 1";
            $stmt_update = $conn->prepare($sql_update_deposit);
            $stmt_update->bind_param("ds", $remaining_deposit, $logged_in_email);
            if ($stmt_update->execute()) {
                if ($is_first_investment && $referred_by) {
                    // Update the referrer's earnings
                    $sql_update_referrer_earnings = "UPDATE users SET referral_earnings = referral_earnings + ? WHERE email = ?";
                    $stmt_update_referrer = $conn->prepare($sql_update_referrer_earnings);
                    $stmt_update_referrer->bind_param("ds", $referral_earning, $referrer_email);
                    $stmt_update_referrer->execute();
                    $stmt_update_referrer->close();
                }

                echo "
                    <script>
                        alert('Investment successful. Your remaining balance is ' + $remaining_deposit + ' USD.');
                        window.location.href = 'dashboard.php';
                    </script>
                ";
            } else {
                echo "Error updating deposit: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            echo "Error inserting investment: " . $stmt_invest->error;
        }

        $stmt_invest->close();
    } else if ($investment_amount > $total_deposit) {
        echo "
            <script>
                alert('Insufficient funds. You cannot invest more than you have.');
                window.history.back();
            </script>
        ";
    } else {
        echo "Error: Required fields are missing.";
    }

    $conn->close();
}
?>


<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Investing Page | Investify</title>
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="../assets/global/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/global/css/line-awesome.min.css" />
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/main.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        .hydrated {
            margin: 1rem 0 1rem 18rem;
        }

        .form-group {
            margin: 1rem 0;
        }

        @media (min-width: 300px) and (max-width: 990px) {
            .hydrated {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <?php include('navbar1.php') ?>

    <div>
        <div class="container mt-5">
            <h2>Investment Form</h2>
            <div class="alert alert-info" role="alert">
                Your total deposit amount is: $<?php echo $total_deposit; ?>
            </div>
            
          Your referral person's plan amount is: $<?php echo $referrer_amount;?>

            <form id="investment-form" action="" method="POST">
                <div class="form-group">
                    <label for="plan">Investment Plans</label>
                    <select class="form-control" id="plan" name="plan" required>
                        <option value="">Select a plan</option>
                        <option value="7 Days">7 Days (15% profit)</option>
                        <option value="15 Days">15 Days (25% profit)</option>
                        <option value="1 Month">1 Month (50% profit)</option>
                        <option value="2 Months">2 Months (100% profit)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Investment Amount:</label>
                    <input type="number" class="form-control" id="amount" name="amount" min="10" required>
                </div>
                <button type="submit" class="btn btn-primary">Invest</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
