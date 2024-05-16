
<?php
session_start();

include('dbcon.php');


$message = '';
$message_type = '';

// Check if form data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Prepare the SQL query to delete a record based on ID
    $sql = "DELETE FROM tdposit WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $message = "Error preparing statement: " . $conn->error;
        $message_type = "danger";
    } else {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "Record deleted successfully";
            $message_type = "success"; 

            // Redirect after a short delay
            header("Refresh: 2; URL=notification.php");
        } else {
            $message = "SQL Error: " . $stmt->error;
            $message_type = "danger";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification | Investify</title>

    
    
    <meta name="twitter:card" content="summary_large_image">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <link href="../assets/global/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/global/css/line-awesome.min.css" />
    <!-- Plugin Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/main.css">


    <style>
        .dashboard-table{
            margin-top: 1rem;
            margin-left: 20rem;
            margin-right: 2rem;
            padding: 0 !important;
        }
        .table .transection__table a:hover{
            text-decoration: none !important;
        }
        td a:hover{
            padding: 0 !important;
            color: black;
        }
    </style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Auto-dismiss alert after 2 seconds (2000 milliseconds)
        setTimeout(function() {
            $(".alert").fadeOut("slow");
        }, 2000);
    });
    </script>

</head>
<body>
<?php include ('navbar.php') ?>

 <!-- Show alert message -->
 <?php if ($message): ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        </div>
    <?php endif; ?>
<div class="dashboard-table">
    <h3 class="mb-2" style="color: #333;">Transaction Type: <span style="color: green;">Deposit</span></h3>

    <?php
    // Database connection details
    $host = 'localhost';
    $dbname = 'digital';
    $user = 'root';
    $pass = '';

    // Create a new mysqli connection
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Fetch data from the transactions table
    $sql = "SELECT id, trx_id, name, email, tdeposit, created_at FROM tdeposit";
    $result = $conn->query($sql);

    // HTML structure for the table
    echo '
    <table class="table transection__table text-center table--responsive--xl">
        <thead>
            <tr>
                <th>TrxId</th>
                <th>Name</th>
                <th>Email</th>
                <th>Deposit </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    ';

    // Loop through the results and output them to the table
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Define the edit and delete URLs
            $edit_url = 'edit.php?id=' . urlencode($row['id']); // URL for editing
            $delete_url = 'delete.php?id=' . urlencode($row['id']); // URL for deleting

            echo '
            <tr>
                <td><strong>' . htmlspecialchars($row['trx_id']) . '</strong></td>
                <td>' . htmlspecialchars($row['name']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>' . htmlspecialchars($row['tdeposit']) .  ' '.'USD' .  '</td>
                <td> 
                    <a href="' . htmlspecialchars($delete_url) . '" onclick="return confirm(\'Are you sure you want to delete deposit record?\')"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            ';
        }
    } else {
        echo '<tr><td colspan="6">No transactions found.</td></tr>';
    }

    echo '
        </tbody>
    </table>
    ';

    // Close the database connection
    $conn->close();
    ?>
</div>




<br>
<br>

        </div>
        <div class="dashboard-table">
            <h3 class="mb-2" style="color: #333;">Transection Type: <span style="color: red;">Withdraw</span></h3>
            <?php
include('dbcon.php');


// Fetch data from the `withdraw` table
$sql = "SELECT id, email, gateway, phone, message FROM withdraw";
$result = $conn->query($sql);

// HTML structure for the table
echo '
<table class="table transection__table text-center table--responsive--xl">
    <thead>
        <tr>
            <th>S.no</th>
            <th>Email</th>
            <th>Account</th>
            <th>Gateway</th>
            <th>Message</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
';

// Initialize a counter for serial numbers
$serial_number = 1;

// Loop through the results and output them to the table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wdelete_url = 'withdraw-delete.php?id=' . urlencode($row['id']); // URL for deleting

        echo '
        <tr>
            <td>' . $serial_number . '</td> <!-- Serial number -->
            <td>' . htmlspecialchars($row['email']) . '</td>
            <td>' . htmlspecialchars($row['phone']) . '</td>
            <td>' . htmlspecialchars($row['gateway']) . '</td>
            <td>' . htmlspecialchars($row['message']) . '</td>

            <td>
                <a href="' . htmlspecialchars($wdelete_url) . '" onclick="return confirm(\'Are you sure you want to delete Withdraw record?\')"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>
        ';

        // Increment the serial number for the next row
        $serial_number++;
    }
} else {
    echo '<tr><td colspan="5">No transactions found.</td></tr>'; // Adjust colspan to match the number of columns
}

echo '
    </tbody>
</table>
';

// Close the database connection
$conn->close();
?>

        </div>







</body>
</html>
