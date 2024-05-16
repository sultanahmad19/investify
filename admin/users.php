



<?php
include('dbcon.php');



$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);



?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users-details | Investify</title>


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
            margin-left: 20rem;
            margin-right: 2rem;
            padding: 0 !important;
        }
        td a:hover{
            color: black;
            padding: 0;
            scale: 1.2;
        }
    </style>
</head>
<body>
<?php include ('navbar.php') ?>
    
<div class="dashboard-table pt-60">
    <h2 class="dashboard-table-title mb-30">My Transaction</h2>
    <table class="table text-center transection__table table--responsive--xl">
        <thead class="text-center">
            <tr>
                <th>S.no</th>
                <th>Name</th>
                <th>Email</th>
                <th>Notification</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($result->num_rows > 0) {
                // Output each row of data
                $sno = 1; // Serial number for the table
                while ($row = $result->fetch_assoc()) {
                  
                    
                    echo "<tr>";
                    echo "<td>" . $sno++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . '<a href="notification.php"><strong>See Notification!</strong> </a>' . "</td>"; // Display the notification status
                    echo "</tr>";
                }
            } else {
                // If no data is found
                echo '<tr><td colspan="4" class="text-center">No Users Found</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
$conn->close();
?>
</body>
</html>