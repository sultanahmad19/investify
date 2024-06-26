<?php
session_start();

// Ensure there's a logged-in user
if (!isset($_SESSION['email'])) {
    header('location:../login.php');
    exit(); // Exit to ensure no further code is executed
}

include('dbcon.php');

$logged_in_email = $_SESSION['email'];
$message = '';

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['plan']) && is_array($_POST['plan']) && isset($_POST['amount']) && is_array($_POST['amount'])) {
        $plans = $_POST['plan']; // Array of plans
        $amounts = $_POST['amount']; // Array of amounts

        // Loop through each plan and process the purchase
        foreach ($plans as $index => $plan) {
            $amount = (float) $amounts[$index];

            // Validate if user has enough funds
            if ($amount > $total_deposit) {
                $message .= "Error: Insufficient funds for plan $plan. Please deposit more to buy this plan.<br>";
                continue;
            } else {
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
                $referral_earning = 0;
                $referred_by = null;

                // Check if user has existing entries in investments or refer_plan tables
                if ($has_existing_entries) {
                    $message .= "User has existing entries.<br>";

                    // Insert the referral plan into the database even if referral bonus is not given
                    $stmt_insert_referral_plan = $conn->prepare("INSERT INTO refer_plan (user_email, plan, amount) VALUES (?, ?, ?)");
                    $stmt_insert_referral_plan->bind_param("ssd", $logged_in_email, $plan, $amount);

                    if ($stmt_insert_referral_plan->execute()) {
                        // Deduct the amount from the user's deposit
                        $total_deposit -= $amount;

                        // Update the deposit in the database
                        $update_stmt = $conn->prepare("UPDATE transactions SET tdeposit = ? WHERE email = ? ORDER BY created_at DESC LIMIT 1");
                        $update_stmt->bind_param("ds", $total_deposit, $logged_in_email);
                        $update_stmt->execute();

                        $message .= "Referral plan $plan purchased successfully.<br>";
                    } else {
                        $message .= "Error purchasing referral plan $plan: " . $stmt_insert_referral_plan->error . "<br>";
                    }

                    $stmt_insert_referral_plan->close();

                } else {
                    // Retrieve the referral code used during registration if it's the user's first investment
                    if ($is_first_investment) {
                        $sql_get_referral_code = "SELECT referred_by FROM users WHERE email = ?";
                        $stmt_referral_code = $conn->prepare($sql_get_referral_code);
                        $stmt_referral_code->bind_param("s", $logged_in_email);
                        $stmt_referral_code->execute();
                        $result_referral_code = $stmt_referral_code->get_result();

                        if ($result_referral_code->num_rows > 0) {
                            $row_referral_code = $result_referral_code->fetch_assoc();
                            $referred_by = $row_referral_code['referred_by'];
                        }

                        $stmt_referral_code->close();

                        // Insert the referral plan into the database
                        $stmt_insert_referral_plan = $conn->prepare("INSERT INTO refer_plan (user_email, plan, amount) VALUES (?, ?, ?)");
                        $stmt_insert_referral_plan->bind_param("ssd", $logged_in_email, $plan, $amount);

                        if ($stmt_insert_referral_plan->execute()) {
                            // Deduct the amount from the user's deposit
                            $total_deposit -= $amount;

                            // Update the deposit in the database
                            $update_stmt = $conn->prepare("UPDATE transactions SET tdeposit = ? WHERE email = ? ORDER BY created_at DESC LIMIT 1");
                            $update_stmt->bind_param("ds", $total_deposit, $logged_in_email);
                            $update_stmt->execute();

                            // Fetch the referrer's email based on the referral code
                            $sql_get_referrer_email = "SELECT email FROM users WHERE referral_code = ?";
                            $stmt_referrer_email = $conn->prepare($sql_get_referrer_email);
                            $stmt_referrer_email->bind_param("s", $referred_by);
                            $stmt_referrer_email->execute();
                            $result_referrer_email = $stmt_referrer_email->get_result();

                           
                        } else {
                            $message .= "Error purchasing referral plan $plan: " . $stmt_insert_referral_plan->error . "<br>";
                        }

                        $stmt_insert_referral_plan->close();
                    } else {
                        $message .= "User has existing entries.<br>";

                        // Insert the referral plan into the database even if referral bonus is not given
                        $stmt_insert_referral_plan = $conn->prepare("INSERT INTO refer_plan (user_email, plan, amount) VALUES (?, ?, ?)");
                        $stmt_insert_referral_plan->bind_param("ssd", $logged_in_email, $plan, $amount);

                        if ($stmt_insert_referral_plan->execute()) {
                            // Deduct the amount from the user's deposit
                            $total_deposit -= $amount;

                            // Update the deposit in the database
                            $update_stmt = $conn->prepare("UPDATE transactions SET tdeposit = ? WHERE email = ? ORDER BY created_at DESC LIMIT 1");
                            $update_stmt->bind_param("ds", $total_deposit, $logged_in_email);
                            $update_stmt->execute();

                            $message .= "Referral plan $plan purchased successfully.<br>";
                        } else {
                            $message .= "Error purchasing referral plan $plan: " . $stmt_insert_referral_plan->error . "<br>";
                        }

                        $stmt_insert_referral_plan->close();
                    }
                }

                // Check if referred user has already purchased a plan
                $sql_check_referred_plans = "SELECT COUNT(*) AS plan_count FROM refer_plan WHERE user_email = ?";
                $stmt_check_referred_plans = $conn->prepare($sql_check_referred_plans);
                $stmt_check_referred_plans->bind_param("s", $logged_in_email);
                $stmt_check_referred_plans->execute();
                $result_check_referred_plans = $stmt_check_referred_plans->get_result();

                $referred_has_plans = false;
                if ($result_check_referred_plans->num_rows > 0) {
                    $row_referred_plans = $result_check_referred_plans->fetch_assoc();
                    $referred_has_plans = ($row_referred_plans['plan_count'] > 0);
                }

                $stmt_check_referred_plans->close();

                if ($referred_has_plans) {
                    // Fetch the referrer's email based on the referral code
                    $sql_get_referrer_email = "SELECT email FROM users WHERE referral_code = ?";
                    $stmt_referrer_email = $conn->prepare($sql_get_referrer_email);
                    $stmt_referrer_email->bind_param("s", $referred_by);
                    $stmt_referrer_email->execute();
                    $result_referrer_email = $stmt_referrer_email->get_result();

                    if ($result_referrer_email->num_rows > 0) {
                        $row_referrer_email = $result_referrer_email->fetch_assoc();
                        $referrer_email = $row_referrer_email['email'];

                        // Update the referral bonus to the latest plan amount
                        $referral_earning = 0.3 * $amount;

                        $sql_update_referrer_earnings = "UPDATE users SET referral_earnings = referral_earnings + ? WHERE email = ?";
                        $stmt_update_referrer = $conn->prepare($sql_update_referrer_earnings);
                        $stmt_update_referrer->bind_param("ds", $referral_earning, $referrer_email);
                        $stmt_update_referrer->execute();
                        $stmt_update_referrer->close();

                        $message .= "Buy Successfully <br>";
                        // Redirect to referrals.php after 2 seconds
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo '   window.location.href = "referrals.php";';  // Redirect to referrals.php
    echo '}, 2000);'; // 2 second delay
    echo '</script>';
                    } else {
                        $message .= "Buy Successful<br>";
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () {';
                        echo '   window.location.href = "referrals.php";';  // Redirect to referrals.php
                        echo '}, 2000);'; // 2 second delay
                        echo '</script>';
                    }

                    $stmt_referrer_email->close();
                } else {
                    // Referrer does not have an entry in refer_plan table. Give a default bonus of $1.5
                    $referral_earning = 1.5; // Default bonus of $1.5
                    $sql_update_referrer_earnings = "UPDATE users SET referral_earnings = referral_earnings + ? WHERE email = ?";
                    $stmt_update_referrer = $conn->prepare($sql_update_referrer_earnings);
                    $stmt_update_referrer->bind_param("ds", $referral_earning, $referrer_email);
                    $stmt_update_referrer->execute();
                    $stmt_update_referrer->close();

                    $message .= "Success";
                     // Redirect to referrals.php after 2 seconds
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo '   window.location.href = "referrals.php";';  // Redirect to referrals.php
    echo '}, 2000);'; // 2 second delay
    echo '</script>';
                }
            }
        }
    } else {
        $message .= "Error: Invalid input data.<br>";
    }
}
?>





<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Referral Plans | Investify</title>

    <!-- favicon -->
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link href="../assets/global/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/global/css/line-awesome.min.css" />
    <!-- Plugin Link -->
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

        .message {
            margin: 20px auto;
            padding: 10px;
            border-radius: 5px;
            max-width: 600px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .message.success {
            background-color: #c6efce; /* green background color */
            color: #2e865f; /* green text color */
            border: 1px solid #3e8e41; /* green border color */
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            <h2>Referral Plans</h2>
            <div class="alert alert-info" role="alert">
                Your total deposit amount is: $<?php echo $total_deposit; ?>
            </div>
            
            <?php if ($message): ?>
            <div class="message <?php echo (strpos($message, 'success') !== false) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
                <?php if (strpos($message, 'success') !== false): ?>
                <script>
                    setTimeout(function () {
                        window.location.href = 'referrals.php';
                    }, 3000);
                </script>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <form id="referral-plan-form" action="" method="POST">
                <div class="form-group">
                    <label for="plan">Referral Plans</label>
                    <select class="form-control" id="plan" name="plan[]" required>
                        <option value="">Select a plan</option>
                        <option value="Silver">Silver</option>
                        <option value="Platinum">Platinum</option>
                        <option value="Gold">Gold</option>
                        <option value="Diamond">Diamond</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Package Amount:</label>
                    <input type="" class="form-control" id="amount" name="amount[]" min="10" required readonly>
                </div>
                <button type="submit" class="btn btn-primary">Buy</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Optional, for jQuery support -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Optional, for Bootstrap support -->

    <script>
        // Function to set amount based on selected plan
        function setAmount() {
            var plan = document.getElementById("plan").value;
            var amountField = document.getElementById("amount");

            switch (plan) {
                case "Silver":
                    amountField.value = 10;
                    break;
                case "Platinum":
                    amountField.value = 20;
                    break;
                case "Gold":
                    amountField.value = 50;
                    break;
                case "Diamond":
                    amountField.value = 100;
                    break;
                default:
                    amountField.value = "";
            }
        }

        // Call setAmount initially to set default amount
        setAmount();

        // Add event listener to plan dropdown to update amount on change
        document.getElementById("plan").addEventListener("change", setAmount);
    </script>
</body>

</html>
