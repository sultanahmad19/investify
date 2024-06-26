

<?php
session_start();

include('dbcon.php');

// Fetch the record by ID passed via GET
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id === null) {
    die("Invalid ID provided.");
}

$sql = "SELECT name, email, twithdraw FROM transactions WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $id); // Bind the ID
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result

// Fetch the data
$data = $result->fetch_assoc();

$stmt->close(); // Close the statement
$conn->close(); // Close the connection

// Ensure there's valid data
if (!$data) {
    die("No data found for the given ID");
}
?>


<?php
include('dbcon.php');

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ID and amount from the form
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : null;

    // Validate the data
    if ($id === null || !is_numeric($amount)) {
        $message = "Invalid input";
        $message_type = "danger"; // Error type
    } else {
        // Prepare the SQL query to update the `twithdraw` and subtract the amount from `tdeposit`
        $sql = "UPDATE transactions 
                SET twithdraw = ?, 
                    tdeposit = tdeposit - ? 
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $message = "Error preparing statement: " . $conn->error;
            $message_type = "danger";
        } else {
            $stmt->bind_param("ddi", $amount, $amount, $id); // Bind the parameters

            if ($stmt->execute()) {
                $message = "Withdrawal updated successfully";
                $message_type = "success"; // Success type

                // Redirect after a short delay
                header("Refresh: 2; URL=transection.php"); // Redirect to another page after 2 seconds
            } else {
                $message = "SQL Error: " . $stmt->error;
                $message_type = "danger";
            }

            $stmt->close(); // Close the statement
        }
    }
}

$conn->close(); // Close the connection
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit | Investify</title>

    <meta name="description" content="RTSGold - A perfect investment platform to invest and earn regular profit, low investment perfect plans and highest returns per hour and weekly and monthly basis with crypto and local payment methods and withdrawal system.">
    <meta name="keywords" content="rtsgold,rts gold,rtsgold.com,rts gold com,rtsgold review,rtsgold reviews,rtsgold login,login rtsgold,rtsgold register,register rtsgold">
    <link rel="shortcut icon" href="../assets/images/logoIcon/favicon.png" type="image/x-icon">

    
    <link rel="apple-touch-icon" href="../assets/images/logoIcon/logo.png">
   

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        .dashboard-table{
            margin-left: 20rem;
            margin-right: 2rem;
            padding: 0 !important;
        }

        body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
    }
    .container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        color: black;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .form-group input[type="text"] {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .form-group input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
    .form-group input[type="submit"]:hover {
        background-color: #0056b3;
    }
    </style>

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


<div class="container">
    <h2>Add Withdraw</h2>
    
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="amount">Add Withdrawal:</label>
            <input type="text" id="amount" name="amount" >
        </div>
        <div class="form-group">
            <input type="submit" value="Update">
        </div>
        
    </form>

</div>







</body>
</html>






