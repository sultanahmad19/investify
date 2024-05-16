

<?php
session_start();

include('dbcon.php');


// Get the ID from the query parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Prepare the SQL DELETE query
    $sql = "DELETE FROM tdeposit WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the ID parameter
        $stmt->bind_param("i", $id);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            // Redirect after successful deletion
            header("Location: notification.php?message=Record+deleted+successfully");
        } else {
            // Handle deletion error
            header("Location: notification.php?error=SQL+error:+".urlencode($stmt->error));
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        header("Location: notification.php?error=Error+preparing+statement");
    }
} else {
    // If ID is not valid, redirect with error
    header("Location: notification.php?error=Invalid+ID");
}

// Close the connection
$conn->close();
?>
