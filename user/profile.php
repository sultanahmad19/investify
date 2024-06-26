<?php
// Start session
session_start();


// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect user to login page or handle as needed
    header("Location: login.php");
    exit;
}
include('dbcon.php');


// Get the logged-in user's email from session
$email = $_SESSION['email'];

// Prepare SQL query to fetch user data based on email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

// Execute the query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title> Profile | Investify</title>

    
    <!-- favicon  -->
    
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">

    
    <!-- Bootstrap CSS -->
    <link href="../assets/global/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/global/css/line-awesome.min.css" />
    <!-- Plugin Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <link rel="stylesheet" href="../templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="../templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="../templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/main.css">
    <link rel="stylesheet" href="../templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>
<body>
    <?php include('navbar.php') ?>
    <div class="body-wrapper">
        <!-- HTML content here -->
        <div class="card-body">
            <h4 class="mb-2">User Profile</h4>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="las la-user base--color"></i> Username</span>
                    <!-- <span class="fw-bold"><?php echo $user['name']; ?></span> -->
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="las la-envelope base--color"></i> Email</span>
                    <span class="fw-bold"><?php echo $user['email']; ?></span>
                </li>
                <!-- Add more list items for other user details -->
            </ul>
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
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../assets/global/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/global/js/bootstrap.bundle.min.js"></script>
    <script src="../templates/hyip_gold/js/lib/waypoints.js"></script>
    <!-- Bootstrap 5 js -->
    <!-- Pluglin Link -->
    <script src="../templates/hyip_gold/js/lib/slick.min.js"></script>
    <script src="../templates/hyip_gold/js/lib/meanmenu.js"></script>
    <script src="../templates/hyip_gold/js/lib/counterup.js"></script>
    <script src="../templates/hyip_gold/js/lib/wow.min.js"></script>
    <!-- Main js -->
    <script src="../templates/hyip_gold/js/main.js?v=1.0.0"></script>

    <script>
        document.querySelector('input[name="amount"]').addEventListener('input', function() {
            const preview = document.querySelector('.preview-details');
            if (this.value > 0) {
                preview.classList.remove('d-none'); // Show the section
            } else {
                preview.classList.add('d-none'); // Hide the section if no value or zero
            }
        });
    </script>

<script>
document.getElementById('depositForm').addEventListener('submit', function(event) {
    const amountInput = document.getElementById('amount');
    const amountError = document.getElementById('amountError');
    
    if (amountInput.value < 10) {
        event.preventDefault(); // Prevent form submission
        amountError.classList.remove('d-none'); // Show the error message
    } else {
        amountError.classList.add('d-none'); // Hide the error message
    }
});
</script>

    <!-- 
INSERT INTO `deposit` (`id`, `gateway`, `amount`, `time`) VALUES (NULL, 'essssss', '21', 'current_timestamp()');  -->















    
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

    <script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="|49" defer></script>
</body>


</html>
<?php
} else {
    // User not found
    // Handle error or redirect as needed
    echo "User not found.";
}
// Close statement and database connection
$stmt->close();
$conn->close();
?>
