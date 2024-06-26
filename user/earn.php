<?php
include('dbcon.php');

if (!isset($_SESSION['email'])) {
    header('location:../login.php');
    exit(); // Ensure no further code is executed
}

$logged_in_email = $_SESSION['email'];

$sql_investments_ended = "
    SELECT id, amount, profit, created_at, duration
    FROM investments 
    WHERE email = ? 
      AND status = 'active'
";
$stmt = $conn->prepare($sql_investments_ended);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();

$available_earnings = 0;

while ($row = $result->fetch_assoc()) {
    $investment_id = $row['id'];
    $investment_amount = (float) $row['amount'];
    $investment_profit = (float) $row['profit'];
    $created_at = $row['created_at'];
    $duration = (int) $row['duration'];

    // Calculate the end date of the investment
    $end_date = date('Y-m-d', strtotime("$created_at + $duration days"));

    // Check if the investment duration has ended
    if (strtotime($end_date) <= strtotime(date('Y-m-d'))) {
        $available_earnings += $investment_amount + $investment_profit;

        // Mark the investment as completed
        $sql_mark_complete = "UPDATE investments SET status = 'completed' WHERE id = ?";
        $stmt_update = $conn->prepare($sql_mark_complete);
        $stmt_update->bind_param("i", $investment_id);
        $stmt_update->execute();
        $stmt_update->close();
    }
}

$stmt->close();

// Fetch the last transaction record for this user
$sql_get_last_transaction = "
    SELECT id, available_earnings 
    FROM transactions 
    WHERE email = ? 
    ORDER BY created_at DESC 
    LIMIT 1
";
$stmt_get_last_transaction = $conn->prepare($sql_get_last_transaction);
$stmt_get_last_transaction->bind_param("s", $logged_in_email);
$stmt_get_last_transaction->execute();
$result_last_transaction = $stmt_get_last_transaction->get_result();

if ($result_last_transaction->num_rows > 0) {
    $last_transaction = $result_last_transaction->fetch_assoc();
    $last_transaction_id = $last_transaction['id'];
    $updated_earnings = (float) $last_transaction['available_earnings'] + $available_earnings;

    // Update only the last transaction record with the new earnings
    $sql_update_last_earnings = "
        UPDATE transactions 
        SET available_earnings = ? 
        WHERE id = ?
    ";
    $stmt_update_last_earnings = $conn->prepare($sql_update_last_earnings);
    $stmt_update_last_earnings->bind_param("di", $updated_earnings, $last_transaction_id);
    $stmt_update_last_earnings->execute();
    $stmt_update_last_earnings->close();
}

$stmt_get_last_transaction->close();
$conn->close();
?>
