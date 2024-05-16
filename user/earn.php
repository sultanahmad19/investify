<?php
include('dbcon.php');


$logged_in_email = $_SESSION['email']; // The logged-in user's email

// Fetch the user's investments that have ended
$sql_investments_ended = "
    SELECT id, amount 
    FROM investments 
    WHERE email = ? 
      AND created_at <= CURRENT_DATE() 
      AND status = 'active'
";
$stmt = $conn->prepare($sql_investments_ended);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();

// Initialize available earnings
$available_earnings = 0;

// Loop through ended investments
while ($row = $result->fetch_assoc()) {
    $investment_id = $row['id'];
    $investment_amount = (float) $row['amount'];

    // Add the investment amount to available earnings
    $available_earnings += $investment_amount;

    // Mark the investment as complete
    $sql_mark_complete = "UPDATE investments SET status = 'completed' WHERE id = ?";
    $stmt_update = $conn->prepare($sql_mark_complete);
    $stmt_update->bind_param("i", $investment_id);
    $stmt_update->execute();
    $stmt_update->close();
}

// Update 'available_earnings' in 'transactions' table
$sql_update_earnings = "
    UPDATE transactions 
    SET available_earnings = available_earnings + ? 
    WHERE email = ?
";
$stmt_update_earnings = $conn->prepare($sql_update_earnings);
$stmt_update_earnings->bind_param("ds", $available_earnings, $logged_in_email);
$stmt_update_earnings->execute();
$stmt_update_earnings->close();

// Reduce 'investment_amount' in 'transactions' by 'available_earnings'
$sql_reduce_investment = "
    UPDATE investments 
    SET amount =  amount - ? 
    WHERE email = ?
";
$stmt_reduce_investment = $conn->prepare($sql_reduce_investment);
$stmt_reduce_investment->bind_param("ds", $available_earnings, $logged_in_email);
$stmt_reduce_investment->execute();
$stmt_reduce_investment->close();

$conn->close(); // Close the database connection
?>
