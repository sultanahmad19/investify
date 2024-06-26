<?php
session_start();

include('dbcon.php');

if (!isset($_SESSION['email'])) {
    header('location:../login.php');
    exit(); // Ensure no further code is executed
}

$user_email = $_SESSION['email'];

// Fetch the last deposit and withdrawal for the logged-in user
$sql_last_transaction = "SELECT twithdraw FROM transactions WHERE email = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql_last_transaction);
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$last_withdrawal = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_withdrawal = $row['twithdraw'];
} else {
    $last_deposit = "0";
    $last_withdrawal = "0";
}

// Get the user's ID and referral code
$user_id_query = "SELECT id, referral_code FROM users WHERE email = ?";
$stmt = $conn->prepare($user_id_query);
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    $referral_code = $user['referral_code'];
} else {
    die("User not found.");
}

// Fetch the total deposit amount for the logged-in user
$sql_total_deposit = "SELECT SUM(tdeposit) AS total_deposit FROM transactions WHERE email = ?";
$stmt = $conn->prepare($sql_total_deposit);
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$total_deposit = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_deposit = (float) $row['total_deposit'];
} else {
    $total_deposit = 0;
}

$stmt->close();
$conn->close();
?>



<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Dashboard | Investify</title>




    <!-- favicon  -->
    
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <link href="../assets/global/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/global/css/line-awesome.min.css" />


    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/main.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">



    <style>
         .btn.disabled, .btn[aria-disabled="true"] {
        pointer-events: none;
        opacity: 0.65;
    }
    </style>
</head>

<body>



<?php
include('dbcon.php');


// Ensure the user is logged in
if (isset($_SESSION['user_id'])) {
    // Retrieve session variables for name and email
    $name = htmlspecialchars($_SESSION['name']); // Sanitize
    $email = htmlspecialchars($_SESSION['email']); // Sanitize
} else {
    // If not logged in, redirect to login page
    // header("Location: ../login.php");
    exit();
}

?>


<div class="overlay"></div>
    
        
    
        <div class="dashboard">
        <div class="dashboard-sidebar">
        <div class="inner-sidebar">
        <div class="sidebar-logo">
            <a href="dashboard.php">
                <img src="../images/logo.png" alt="logo img">
            </a>
        </div>
        <!-- Sidebar Remove Btn Start -->
        <div class="cross-btn d-lg-none d-block">
            <i class="fas fa-times"></i>
        </div>
        <!-- Sidebar Remove Btn End -->
        <div class="sidebar__menuWrapper">
            <!-- account blance start here -->
            <div class="dashboard-account">
                <div class="dashboard-account__icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h6 class="dashboard-account__title"><?php echo $name; ?></h6>
               

            </div>
            


            <div class="sidebar-menu">
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-list__item ">
                        <a href="dashboard.php" class="sidebar-menu-list__link">
                            <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="investment.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-cubes pr-1"></i>
                            </span>
                            <span class="text">Investment</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="deposit.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-coins"></i>
                            </span>
                            <span class="text">Add Deposit</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="deposit-history.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-coins"></i>
                            </span>
                            <span class="text">Deposit history</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-menu-list__item  ">
                        <a href="withdraw.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </span>
                            <span class="text">Withdraw</span>
                        </a>
                    </li> -->
                    <li class="sidebar-menu-list__item  ">
                        <a href="withdraw-history.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </span>
                            <span class="text">Withdraw Log</span>
                        </a>
                    </li>
                   

                   
                    
                                        <li class="sidebar-menu-list__item ">
                        <a href="transactions.php" class="sidebar-menu-list__link">
                            <span class="icon"><i class="fas fa-exchange-alt pr-1"></i></span>
                            <span class="text">Transaction</span>
                        </a>
                    </li>

                    
                    <li class="sidebar-menu-list__item ">
                        <a href="referrals.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-handshake  pr-1"></i>
                            </span>
                            <span class="text">Referrals</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item ">
                        <a href="refer.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-handshake  pr-1"></i>
                            </span>
                            <span class="text">Referral Plans</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item ">
                        <a href="logout.php" class="sidebar-menu-list__link">
                            <span class="icon"><i class="fas fa-sign-out-alt"></i> </span>
                            <span class="text">Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>


<!-- ------------ rigth navbar-----  -->




<div class="dashboard-nav d-flex flex-wrap align-items-center justify-content-between">
        <!-- Hambarger Remove Btn Start -->
        <div class="nav-left d-lg-none d-block">
            <div class="hambarger-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="nav-left">
            <ul>
                <li>
                    <i class="fas fa-headset"></i>
                    Support            </li>
                    <li>
                                        <a href="mailto:officialinvestify@gmail.com">
                                        <i class="fa-solid fa-envelope"></i> officialinvestify@gmail.com
                                        </a>
                                    </li>
            </ul>
        </div>











    <div class="nav-right">

            <ul class="prfile-menu">
                <li>
                    <div class="user-profile d-flex gap-1 align-items-center">
                                            <div class="dropdown">
                            <button class="btn dashboard-dropdown-button dropdown-toggle d-flex align-items-center " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-profile-meta">
                                    <span class="name"><?php echo $name; ?></span>
                                    <span class="meta-email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></span>
                                </span>
                                <!-- <span class="ms-2 fs-4 text-white">
                                    <i class="fas fa-angle-down"></i>
                                </span> -->
                            </button>
                            <!-- <ul class="dashboard-dropdown d-blok dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                
                                <li>
                                    <a class="dropdown-item" href="logout.php">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout                                </a>
                                </li>
                            </ul> -->
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>



    
    

    
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
    

   
            
            

    <div class="row gy-4">

    <div class="col-xxl-4 col-sm-6">
    <div class="card-item">
        <div class="card-item-body d-flex justify-content-between">
            <div class="card-item-body-left">
            <i class="fa-solid fa-vault"></i>
                <p>Account Balance</p>
                
                <h4><?php echo $total_deposit; ?> USD</h4>
            </div>
            <div class="card-item-body-right">
                <?php if ($total_deposit > 0): ?>
                    <a class="btn btn--outline-base btn--back-bg btn-dashboard" href="withdraw.php">Withdraw</a>
                <?php else: ?>
                    <a class="btn btn--outline-base btn--back-bg btn-dashboard disabled" href="javascript:void(0);">Withdraw</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

    





<?php
include('dbcon.php');

$logged_in_email = $_SESSION['email']; // Logged-in user's email

// Retrieve 'available_earnings' from the last row in the 'transactions' table for the logged-in user
$sql_get_earnings = "SELECT  SUM(available_earnings) AS available_earnings
                     FROM transactions 
                     WHERE email = ? 
                     ORDER BY id DESC 
                     "; // Adjust 'id' to your primary key or an appropriate column

$stmt = $conn->prepare($sql_get_earnings);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();

$available_earnings = 0; // Default value

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $available_earnings = (float) $row['available_earnings']; // Fetch the available earnings
}

$stmt->close();
$conn->close();
?>

<div class="col-xxl-4 col-sm-6">
    <div class="card-item">
        <div class="card-item-body d-flex justify-content-between">
            <div class="card-item-body-left">
                <i class="fas fa-coins"></i>
                <p>Earning Amount</p>
                <h4><?php echo $available_earnings; ?> USD</h4>
            </div>
            <div class="card-item-body-right">
                <?php if ($available_earnings > 0): ?>
                    <a id="transfer-link" class="btn btn--outline-base btn--back-bg btn-dashboard" href="transfer.php" data-bs-toggle="tooltip" data-bs-placement="top" title="Transfer money to Account Balance">Transfer</a>

                <?php else: ?>
                    <a class="btn btn--outline-base btn--back-bg btn-dashboard disabled" href="transfer.php">Transfer</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

        
       



<?php
include('earn.php');

// Ensure there's a logged-in user
if (!isset($_SESSION['email'])) {
    die('No logged-in user. Please login.');
}

include('dbcon.php');

$logged_in_email = $_SESSION['email']; // The logged-in user's email

// Fetch the amount from the last row (latest investment) by the user
$sql_last_investment = "SELECT amount FROM investments WHERE email = ? ORDER BY id DESC ";
$stmt = $conn->prepare($sql_last_investment);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();

$last_investment_amount = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_investment_amount = (float) $row['amount']; 
}

$stmt->close(); 
$conn->close();

?>


        
        <div class="col-xxl-4 col-sm-6">
            <div class="card-item">
                <div class="card-item-body d-flex justify-content-between">
                    <div class="card-item-body-left">
                        <i class="fas fa-chart-area"></i>
                        <p>Recent Invest </p>
                        <h4><?php echo $last_investment_amount; ?> USD</h4>
                    </div>
                    <div class="card-item-body-right">
                        <a class="btn btn--outline-base btn--back-bg btn-dashboard"
                            href="investment.php">Invest</a>
                    </div>
                   
                </div>
            </div>
        </div>


        <?php

// Ensure there's a logged-in user
if (!isset($_SESSION['email'])) {
    die('No logged-in user. Please login.');
}

include('dbcon.php');

$logged_in_email = $_SESSION['email']; // The logged-in user's email

// Fetch the total amount invested by the user
$sql_total_investment = "SELECT SUM(tamount) AS total_investment FROM investments WHERE email = ?";
$stmt = $conn->prepare($sql_total_investment);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();

$total_investment = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_investment = (float) $row['total_investment']; 
}

$stmt->close(); 
$conn->close();

?>



        
        <div class="col-xxl-4 col-sm-6">
            <div class="card-item">
                <div class="card-item-body d-flex justify-content-between">
                    <div class="card-item-body-left">
                    <i class="fa-solid fa-money-bill"></i>
                    <p>Total Invest </p>
                        <h4><?php echo $total_investment; ?> USD</h4>
                    </div>
                    
                   
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-sm-6">
            <div class="card-item">
                <div class="card-item-body d-flex justify-content-between">
                    <div class="card-item-body-left">
                    <i class="fas fa-cloud-download-alt"></i>
                <p>Last Withdrawal</p>
                <h4><?php echo $last_withdrawal ?> USD</h4>
                    </div>
                    
                   
                </div>
            </div>
        </div>
        


        
</div>














<!-- <a id="chatLink" class="support-float" href="mailto:officialinvestify@gmail.com">
        <img src="../assets/images/support.png" />
    </a> -->

   
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
 
    <script src="../templates/hyip_gold/js/main.js?v=1.0.0"></script>


    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('transfer-link').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default link behavior

        fetch('transfer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action: 'transfer' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Are you Sure !');
                document.querySelector('h4').textContent = data.new_balance + ' USD';
                // Reload the page after a short delay
                setTimeout(function() {
                    window.location.reload();
                }, 1000); // Reload after 2 seconds (adjust as needed)
            } else {
                alert('Transfer failed: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
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