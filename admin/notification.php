
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
   include('dbcon.php');


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
$sql = "SELECT id, email, gateway, account, amount, message FROM withdraw";
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
            <th>Amount</th>
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
            <td>' . htmlspecialchars($row['account']) . '</td>
            <td>' . htmlspecialchars($row['gateway']) . '</td>
            <td>' . htmlspecialchars($row['amount']) . '</td>
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




    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="../assets/global/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="../assets/global/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/waypoints.js"
        type="text/javascript"></script>
    <!-- Bootstrap 5 js -->
    <!-- Pluglin Link -->
    <script src="../assets/templates/hyip_gold/js/lib/slick.min.js"
        type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/meanmenu.js"
        type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/counterup.js"
        type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/wow.min.js"
        type="text/javascript"></script>
    <!-- Main js -->
    <script src="../assets/templates/hyip_gold/js/main.js?v=1.0.0"
        type="text/javascript"></script>
    <script type="text/javascript">
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>Admin Feedback</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);
    </script>
    <script type="text/javascript">
            (function($) {
                "use strict";
                $(".langSel").on("change", function() {
                    window.location.href = "../change/" + $(this).val();
                });

            })(jQuery);
        </script>
    <script type="text/javascript">
            (function($) {
                "use strict";

                $('form').on('submit', function() {
                    if ($(this).valid()) {
                        $(':submit', this).attr('disabled', 'disabled');
                    }
                });

                var inputElements = $('[type=text],[type=password],select,textarea');
                $.each(inputElements, function(index, element) {
                    element = $(element);
                    element.closest('.form-group').find('label').attr('for', element.attr('name'));
                    element.attr('id', element.attr('name'))
                });

                $.each($('input, select, textarea'), function(i, element) {

                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }

                });


                $('.showFilterBtn').on('click', function() {
                    $('.responsive-filter-card').slideToggle();
                });


                Array.from(document.querySelectorAll('table')).forEach(table => {
                    let heading = table.querySelectorAll('thead tr th');
                    Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                        Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                            colum.setAttribute('data-label', heading[i].innerText)
                        });
                    });
                });

            })(jQuery);
        </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TV512QWDND"
        type="text/javascript"></script>
    <script type="text/javascript">
                  window.dataLayer = window.dataLayer || [];
                  function gtag(){dataLayer.push(arguments);}
                  gtag("js", new Date());
                
                  gtag("config", "G-TV512QWDND");
                </script>
    <link rel="stylesheet" href="../assets/global/css/iziToast.min.css">
    <script src="../assets/global/js/iziToast.min.js" type="text/javascript"></script>

    <script type="text/javascript">
    "use strict";
    function notify(status,message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
</script>















    
    <script type="text/javascript">
            window.onload = function() {
                var box = document.getElementById('chatLink');
                var isDragging = false;
                var offsetX = 0;
                var offsetY = 0;

                // Mouse Down Event
                box.addEventListener('mousedown', function(e) {
                    isDragging = true;
                    offsetX = e.clientX - box.getBoundingClientRect().left;
                    offsetY = e.clientY - box.getBoundingClientRect().top;
                });

                // Mouse Move Event
                document.addEventListener('mousemove', function(e) {
                    if (!isDragging) return;

                    e.preventDefault(); // Prevent selection while dragging
                    const newX = e.clientX - offsetX;
                    const newY = e.clientY - offsetY;
                    box.style.left = `${newX}px`;
                    box.style.top = `${newY}px`;
                });

                // Mouse Up Event
                document.addEventListener('mouseup', function() {
                    isDragging = false;
                });

                // Touch Start Event
                box.addEventListener('touchstart', function(e) {
                    var touchLocation = e.targetTouches[0];
                    offsetX = touchLocation.pageX - box.getBoundingClientRect().left;
                    offsetY = touchLocation.pageY - box.getBoundingClientRect().top;
                });

                // Touch Move Event
                box.addEventListener('touchmove', function(e) {
                    e.preventDefault(); // Prevent scrolling
                    var touchLocation = e.targetTouches[0];
                    var newX = touchLocation.pageX - offsetX;
                    var newY = touchLocation.pageY - offsetY;
                    box.style.left = newX + 'px';
                    box.style.top = newY + 'px';
                });

                // Touch End Event
                box.addEventListener('touchend', function(e) {
                    var x = parseInt(box.style.left);
                    var y = parseInt(box.style.top);
                    // Do something with the final x and y values
                });
            };
        </script>



    <script type="text/javascript">
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "../change/" + $(this).val();
            });

            $('.policy').on('click', function() {
                $.get('../cookie/accept', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],[type=password],[type=email],[type=number],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });

        })(jQuery);





    </script>

    <script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="|49" defer></script>
</body>

</html>
