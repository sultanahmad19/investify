<?php
session_start();
include('dbcon.php');

$response = ['success' => false, 'message' => '', 'new_balance' => 0];

if (!isset($_SESSION['email'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit();
}

$logged_in_email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['action']) && $input['action'] === 'transfer') {
        // Fetch the available earnings
        $sql_get_earnings = "
            SELECT SUM(available_earnings) AS available_earnings 
            FROM transactions 
            WHERE email = ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ";
        $stmt_get_earnings = $conn->prepare($sql_get_earnings);
        $stmt_get_earnings->bind_param("s", $logged_in_email);
        $stmt_get_earnings->execute();
        $result_earnings = $stmt_get_earnings->get_result();

        if ($result_earnings->num_rows > 0) {
            $last_transaction = $result_earnings->fetch_assoc();
            $available_earnings = (float) $last_transaction['available_earnings'];

            if ($available_earnings > 0) {
                // Update the tdeposit and reset available_earnings
                $sql_update_deposit = "
                    UPDATE transactions 
                    SET tdeposit = tdeposit + ?, available_earnings = 0 
                    WHERE email = ? 
                    ORDER BY created_at DESC 
                    LIMIT 1
                ";
                $stmt_update_deposit = $conn->prepare($sql_update_deposit);
                $stmt_update_deposit->bind_param("ds", $available_earnings, $logged_in_email);

                if ($stmt_update_deposit->execute()) {
                    $response['success'] = true;
                    $response['new_balance'] = 0; // Since we transferred all available earnings
                } else {
                    $response['message'] = 'Error updating deposit: ' . $stmt_update_deposit->error;
                }

                $stmt_update_deposit->close();
            } else {
                $response['message'] = 'No available earnings to transfer';
            }
        } else {
            $response['message'] = 'No earnings found for user';
        }

        $stmt_get_earnings->close();
    } else {
        $response['message'] = 'Invalid request';
    }
}

$conn->close();
echo json_encode($response);
?>
