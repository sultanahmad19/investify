<?php
session_start();

include('dbcon.php');

// Check if the form data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $id = $_POST['id']; // If you're passing ID as part of the form
    $gateway = $_POST['gateway'];
    $amount = $_POST['amount'];

    // Retrieve the logged-in user's email from the session
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email']; // Store the email from the session

        // Ensure the data is valid
        if (!empty($gateway) && is_numeric($amount) && $amount >= 10) {
            // Prepare the SQL query to include the email
            $sql = "INSERT INTO deposit (id, gateway, amount, email) 
                    VALUES (?, ?, ?, ?)";

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            // Bind parameters to the query, including the email
            $stmt->bind_param("ssss", $id, $gateway, $amount, $email);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Record inserted successfully";
                header("Location: checkout.php"); // Redirect after insertion
                exit(); // Ensure you exit after redirecting
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Invalid input: Amount must be at least 10 USD.";
        }
    } else {
        echo "Session does not contain user email.";
    }
}

// Close the database connection
$conn->close();
?>





<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Deposit Methods | Investify</title>

    
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
        <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
            <h6 class="page-title">Deposit Methods</h6>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
            <form id="depositForm" action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="card custom--card">
        <div class="card-body">
            <div class="form-group mb-3 has-icon-select">
                <label class="form-label">Select Gateway</label>
                <select class="form--control form-select" id="gateway" name="gateway" required>
                    <option value="">Select One</option>
                    <option value="Perfect-money">Perfect Money</option>
                    <option value="Crypto Wallet">Crypto Wallet</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Amount</label>
                <div class="input-group">
                    <input type="number" step="any" name="amount" id="amount" class="form-control form--control" value="" autocomplete="off" required>
                    <span class="input-group-text bg--base">USD</span>
                </div>
                <span id="amountError" class="text-danger d-none">Amount must be at least 10 USD.</span>
            </div>

            <div class="mt-3 preview-details d-none"> <!-- Initially hidden -->
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Limit</span>
                        <span><span class="min fw-bold">10</span> USD - <span class="max fw-bold">500,000</span> USD</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Charge</span>
                        <span><span class="charge fw-bold">0</span> USD</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Payable</span> <span><span class="payable fw-bold">10</span> USD</span>
                    </li>
                </ul>
            </div>

            <button type="submit" class="btn btn--outline-base w-100 mt-3">Submit</button>
        </div>
    </div>
</form>
            </div>
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