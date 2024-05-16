<?php
 session_start();
 ?>

<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Dashboard | Investify</title>
    <meta name="title" Content="RTSGold - Dashboard">

    <!-- Bootstrap CSS -->
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
        .join-card{
            border: 2px solid #BF9243;
            padding: 12px 10px;
            border-radius: 8px;
            display: flex;
            gap: 10px
        }
        .join-card__icon {
            width: 100px;
            align-self: center
        }
        .join-card__icon img{
            max-width: 100%;
            min-width: 100px;
            border-radius: 5px;
            min-height: 70px;
        }
        .join-card__desc{
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }
        .join-card__title{
            text-align: left;
            font-size: 0.9rem;
            margin-bottom: 6px
        }

        @media (max-width: 320.98px) {
            .trx {
                font-size: 11px;
            }
        }
    </style>
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">
</head>

<body>
        
<?php include ('navbar.php') ?>


        <div class="body-wrapper">
            <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
    <h6 class="page-title">Dashboard</h6>
    </div>
            
        <!--========================== Announcement Section Start ==========================-->
        <div class="container-fluid">
            <div class="row gy-4 align-items-center mb-4">
                <div class="col-12 px-0">
                    <div class="row join-us-wrapper">
                                            </div>
                </div>
            </div>
        </div>
    
        <?php

include('dbcon.php');


// SQL query to fetch total number of users
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);

// Check if query was successful
if ($result && $result->num_rows > 0) {
    // Fetch the total number of users
    $row = $result->fetch_assoc();
    $total_users = $row["total_users"];
} else {
    $total_users = 0; // If no users found, set total users to 0
}

// Close database connection
$conn->close();
?>
   
            
            

    <div class="row gy-4">
        <div class="col-xxl-4 col-sm-6">
            <div class="card-item">
                <div class="card-item-body d-flex justify-content-between">
                    <div class="card-item-body-left">
                        <i class="fas fa-users"></i>
                        <p>Total users</p>
                        <h4><?php echo $total_users; ?></h4> <!-- Display total number of users here -->
                
                    </div>
                    <div class="card-item-body-right">
                        <a class="btn btn--outline-base btn--back-bg btn-dashboard"
                            href="users.php">View All</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
include('dbcon.php');

// Fetch the total amount invested by all users
$sql_total_investment = "SELECT SUM(tamount) AS total_investment FROM investments";
$result = $conn->query($sql_total_investment);

$total_investment = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_investment = (float) $row['total_investment']; 
}

$conn->close();

?>

                
               
        <div class="col-xxl-4 col-sm-6">
            <div class="card-item">
                <div class="card-item-body d-flex justify-content-between">
                    <div class="card-item-body-left">
                        <i class="fas fa-chart-area"></i>
                        <p>Total Invest </p>
                        <h4><?php echo $total_investment; ?> USD</h4>
                    </div>
                   
                </div>
            </div>
        </div>


        <?php
include('dbcon.php');

// Fetch the total amount withdrawn by all users
$sql_total_withdraw = "SELECT SUM(twithdraw) AS total_withdraw FROM transactions";
$result = $conn->query($sql_total_withdraw);

$total_withdraw = 0;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_withdraw = (float) $row['total_withdraw']; 
}

$conn->close();

?>


        
        
        <div class="col-xxl-4 col-sm-6 ">
            <div class="card-item">
                <div class="card-item-body d-flex justify-content-between">
                    <div class="card-item-body-left">
                        <i class="fas fa-cloud-download-alt"></i>
                        <p>Total Withdraw</p>

                        <h4><?php echo $total_withdraw; ?> USD</h4>
                    </div>
                    

    </div>

    
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="../assets/global/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="../assets/global/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/waypoints.js" type="text/javascript"></script>
    <!-- Bootstrap 5 js -->
    <!-- Pluglin Link -->
    <script src="../assets/templates/hyip_gold/js/lib/slick.min.js" type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/meanmenu.js" type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/counterup.js" type="text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/wow.min.js" type="text/javascript"></script>
    <!-- Main js -->













    

            <a id="chatLink" class="support-float" href="../ticket/new">
            <img src="../assets/images/support.png" />
        </a>
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

<script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="|49" defer></script></body>
    </body>
</html>
