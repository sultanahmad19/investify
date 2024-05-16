

<?php
session_start();

include('dbcon.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM withdraw WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: notification.php?message=Record+deleted+successfully");
        } else {
            header("Location: notification.php?error=SQL+error:+".urlencode($stmt->error));
        }

        $stmt->close();
    } else {
        header("Location: notification.php?error=Error+preparing+statement");
    }
} else {
    header("Location: notification.php?error=Invalid+ID");
}

$conn->close();
?>
