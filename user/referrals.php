

<?php
session_start();

include('dbcon.php');

if (!isset($_SESSION['email'])) {
    header('location:../login.php');
    exit(); // Ensure no further code is executed
}

$user_email = $_SESSION['email'];



// Get the user's ID and referral code
$user_id_query = "SELECT id, referral_code, referral_earnings FROM users WHERE email = ?";
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
    $referral_earnings = $user['referral_earnings'];
} else {
    die("User not found.");
}

// Get the number of users referred by this user
$query = "SELECT COUNT(*) AS referral_count FROM users WHERE referred_by = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}
$stmt->bind_param("s", $referral_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $referral_data = $result->fetch_assoc();
    $referral_count = $referral_data['referral_count'];
} else {
    $referral_count = 0; 
}

$stmt->close();
$conn->close();
?>



<?php
// Include database connection
include('dbcon.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['transfer_referral'])) {
        // Get the logged-in user's email
        $logged_in_email = $_SESSION['email'];

        // Fetch the referral earnings
        $referralQuery = "SELECT referral_earnings FROM users WHERE email = ?";
        $stmt = $conn->prepare($referralQuery);
        $stmt->bind_param("s", $logged_in_email);
        $stmt->execute();
        $referralResult = $stmt->get_result();

        if ($referralResult->num_rows > 0) {
            $referralRow = $referralResult->fetch_assoc();
            $referral_earnings = $referralRow['referral_earnings'];

            // Update the tdeposit column in transactions table
            $updateQuery = "UPDATE transactions SET tdeposit = tdeposit + ? WHERE email = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ds", $referral_earnings, $logged_in_email);

            if ($stmt->execute()) {
                // Update referral_earnings to 0 after successful transfer
                $updateUserQuery = "UPDATE users SET referral_earnings = 0 WHERE email = ?";
                $stmt = $conn->prepare($updateUserQuery);
                $stmt->bind_param("s", $logged_in_email);
                $stmt->execute();

                echo "
                    <script>
                        alert('Referral earnings transferred successfully.');
                        window.location.href = 'dashboard.php'; // Redirect to dashboard
                    </script>
                ";
            } else {
                echo "Error updating data: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo 'No referral earnings found for the logged-in user.<br>';
        }
    }
}

$conn->close();
?>







<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Referrals| Investify</title>
    
    <!-- favicon  -->
    
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">

</head>

<body>

    <?php include ('navbar.php') ?>


    <div class="body-wrapper">
    <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
            


            <h6 class="page-title">Referrals</h6>
            </div>


            <div class="row gy-4">
            <div class="col-xxl-4 col-sm-6">
            <div class="card-item">
                <div class="card-item-body d-flex justify-content-between">
                    <div class="card-item-body-left">
                    <i class="fa-solid fa-user-plus"></i>
                        <p>Users With Your Referance</p>
                        <h4><?php echo $referral_count; ?></h4>
                    </div>
                    <div class="card-item-body-right">
                        <a class="btn btn--outline-base btn--back-bg btn-dashboard"
                            href="refer.php">Invest</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6">
    <div class="card-item">
        <div class="card-item-body d-flex justify-content-between">
            <div class="card-item-body-left">
                <i class="fas fa-coins"></i>
                <p>Referral Earning</p>
                <h4><?php echo $referral_earnings; ?> USD</h4>
            </div>
            <div class="card-item-body-right">
            <form action="" method="POST">
    <input type="hidden" name="transfer_referral" value="1">
    <button type="submit" class="btn btn--outline-base btn--back-bg btn-dashboard" <?php echo $referral_earnings == 0 ? 'disabled' : ''; ?>>
        Transfer
    </button>
</form>

            </div>
        </div>
        
    </div>
</div>

        
        <div class="col-xxl-4 col-sm-6">
    <div class="card-item">
        <div class="card-item-body d-flex justify-content-between">
            <div class="card-item-body-left">
                
                <i class="fa-solid fa-box"></i>
                    <p>Your Referral Code </p>
                        <h4><?php echo $referral_code; ?> </h4>
            </div>
        </div>
    </div>
            </div>

        
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















<a id="chatLink" class="support-float" href="mailto:officialinvestify@gmail.com">
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