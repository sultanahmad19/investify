<?php
session_start();
include('dbcon.php');

if (!isset($_GET['token'])) {
    die("Invalid token");
}

$token = $_GET['token'];
$stmt = $conn->prepare("SELECT name, email FROM admin WHERE login_token = ?");
if ($stmt) {
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $email);
        $stmt->fetch();
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid or expired token.";
    }
    $stmt->close();
} else {
    echo 'Statement preparation failed: ' . $conn->error;
}
$conn->close();
?>
