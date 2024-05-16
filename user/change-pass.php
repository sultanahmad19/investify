<?php 
session_start();
?>
<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="ZUNLa9eXrtrjuVgMzc9Gt4cyy6EFGjvcyns483VV" />
    <title>Change Password | Investify</title>
    <meta name="title" Content="RTSGold - Change Password">
    
    <!-- favicon  -->
    
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="../assets/global/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/global/css/line-awesome.min.css" />
    <!-- Plugin Link -->
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
    <h6 class="page-title">Change Password</h6>
    </div>
                <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card custom--card">

                <div class="card-body">

                    <form action="" method="post">
                        <input type="hidden" name="_token" value="ZUNLa9eXrtrjuVgMzc9Gt4cyy6EFGjvcyns483VV">                        <div class="form-group mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control form--control" name="current_password" required
                                autocomplete="current-password">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control form--control" name="password" required
                                autocomplete="current-password">
                                                    </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control form--control" name="password_confirmation" required
                                autocomplete="current-password">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn--outline-base w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="../assets/global/js/jquery-3.6.0.min.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
    <script src="../assets/global/js/bootstrap.bundle.min.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/waypoints.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
    <!-- Bootstrap 5 js -->
    <!-- Pluglin Link -->
    <script src="../assets/templates/hyip_gold/js/lib/slick.min.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/meanmenu.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/counterup.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/wow.min.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
    <!-- Main js -->
    <script src="../assets/templates/hyip_gold/js/main.js?v=1.0.0" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
                <script type="b76470b7da3cfb4545b24b27-text/javascript">
            (function($) {
                "use strict";
                $(".langSel").on("change", function() {
                    window.location.href = "../change/" + $(this).val();
                });

            })(jQuery);
        </script>
        <script type="b76470b7da3cfb4545b24b27-text/javascript">
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
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TV512QWDND" type="b76470b7da3cfb4545b24b27-text/javascript"></script>
                <script type="b76470b7da3cfb4545b24b27-text/javascript">
                  window.dataLayer = window.dataLayer || [];
                  function gtag(){dataLayer.push(arguments);}
                  gtag("js", new Date());
                
                  gtag("config", "G-TV512QWDND");
                </script>    <link rel="stylesheet" href="../assets/global/css/iziToast.min.css">
<script src="../assets/global/js/iziToast.min.js" type="b76470b7da3cfb4545b24b27-text/javascript"></script>

<script type="b76470b7da3cfb4545b24b27-text/javascript">
    "use strict";
    function notify(status,message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
</script>













    

            <a id="chatLink" class="support-float" href="../ticket/new">
            <img src="../assets/images/support.png" />
        </a>
        <script type="b76470b7da3cfb4545b24b27-text/javascript">
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
    


    <script type="b76470b7da3cfb4545b24b27-text/javascript">
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

<script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="b76470b7da3cfb4545b24b27-|49" defer></script></body>

</html>
