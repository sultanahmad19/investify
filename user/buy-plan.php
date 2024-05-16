<?php
session_start();

// Ensure there's a logged-in user
if (!isset($_SESSION['email'])) {
    die('No logged-in user. Please login.');
    header('location:../login.php');
}

include('dbcon.php');

$logged_in_email = $_SESSION['email'];

// Fetch the user's current deposit
$sql_get_deposit = "SELECT tdeposit FROM transactions WHERE email = ? ORDER BY created_at";
$stmt = $conn->prepare($sql_get_deposit);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();

$current_deposit = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_deposit = (float) $row['tdeposit']; // Current available balance
}

$stmt->close(); // Always close the prepared statement

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the plan and amount from the form
    $plan = isset($_POST['plan']) ? $_POST['plan'] : '';
    $investment_amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    $investment_tamount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;

    // Validate form data
    if ($plan && $investment_amount && $investment_tamount > 0 && $investment_amount <= $current_deposit) {
        // Fetch trx_id from transactions table
        $sql_get_trx_id = "SELECT trx_id FROM transactions WHERE email = ? ORDER BY created_at LIMIT 1";
        $stmt_trx_id = $conn->prepare($sql_get_trx_id);
        $stmt_trx_id->bind_param("s", $logged_in_email);
        $stmt_trx_id->execute();
        $result_trx_id = $stmt_trx_id->get_result();

        if ($result_trx_id->num_rows > 0) {
            $row_trx_id = $result_trx_id->fetch_assoc();
            $trx_id = $row_trx_id['trx_id'];

            // Insert into investments with trx_id
            $sql_invest = "INSERT INTO investments (email, plan, amount, tamount, trx_id) VALUES (?, ?, ?, ?, ?)";
            $stmt_invest = $conn->prepare($sql_invest);
            $stmt_invest->bind_param("ssdds", $logged_in_email, $plan, $investment_amount, $investment_tamount, $trx_id);

            if ($stmt_invest->execute()) {
                // Deduct the invested amount from tdeposit
                $remaining_deposit = $current_deposit - $investment_amount;

                // Update the tdeposit in the transactions table
                $sql_update_deposit = "UPDATE transactions SET tdeposit = ? WHERE email = ?";
                $stmt_update = $conn->prepare($sql_update_deposit);
                $stmt_update->bind_param("ds", $remaining_deposit, $logged_in_email);
                $stmt_update->execute();
                $stmt_update->close();

                echo "
                    <script>
                        alert('Investment successful. Your remaining balance is ' + $remaining_deposit + ' USD.');
                        window.location.href = 'dashboard.php';
                    </script>
                ";
            } else {
                echo "Error inserting investment: " . $stmt_invest->error;
            }

            $stmt_invest->close(); // Close the statement
        } else {
            echo "Error: No transaction found for this user.";
        }

        $stmt_trx_id->close(); // Close the statement
    } else if ($investment_amount > $current_deposit) {
        // If the investment amount exceeds current deposit
        echo "
            <script>
                alert('Insufficient funds. You cannot invest more than you have.');
                window.history.back(); // Go back
            </script>
        ";
    } else {
        echo "Error: Required fields are missing.";
    }

    $conn->close(); // Close the database connection
}
?>


<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Investing | Investify </title>

    
    <!-- favicon  -->
    
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    .hydrated{
        margin: 1rem 0 1rem 18rem;
    }
    .form-group{
        margin: 1rem 0;
    }
</style>


</head>

<body>
    


    
    
    <?php include('navbar1.php') ?>
    
    
    <div> 
        
        
        <div class="container mt-5">
        <h2>Investment Form</h2>
        <form id="investment-form" action="" method="POST">
            <div class="form-group">
                <label for="plan">Investment Plan:</label>
                <select class="form-control" id="plan" name="plan" required>
                    <option value="">Select a plan</option>
                    <option value="7 Days">7 Days</option>
                    <option value="15 Days">15 Days</option>
                    <option value="1 Month">1 Month</option>
                    <option value="2 Months">2 Months</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Investment Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Invest</button>
        </form>
    </div>





   





<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Optional, for jQuery support -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Optional, for Bootstrap support -->

</body>

</html>