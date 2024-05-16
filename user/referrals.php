
<?php
session_start();
include('dbcon.php');


?>

<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Referrals | Investify</title>
    <meta name="title" Content="RTSGold - Referrals">

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
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/main.css">
    <link href="../assets/global/css/jquery.treeView.css" rel="stylesheet" type="text/css">
        
        
        
        <style>
        .box-counter {
            background: #232144;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 18px
        }

        .box-counter span {
            font-family: var(--body-font);
            font-weight: 400;
            color: hsl(var(--white)/0.5);
            display: inline-block;
            margin-bottom: 4px
        }

        .box-counter h6 {
            margin-bottom: 0;
            font-weight: 700;
            font-family: var(--body-font);
            color: hsl(var(--heading-color))
        }

        .checkBtnStyle {
            display: inline-block;
            color: #fff;
            background: #141928;
            padding: 2px 10px;
            border-radius: 7px;
            margin-top: 10px;

        }
    </style>
    <style>

    </style>
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">
</head>

<body>
        <?php include ('navbar.php') ?>
    
    

        <div class="body-wrapper">
            <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
    <h6 class="page-title">Referrals</h6>
    </div>
                <div class="row justify-content-center">
        <div class="card custom--card">
            <div class="card-body">

                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="box-counter">
                                <span>Direct Referrals</span>
                                <br>
                                <a href="javascript:void(0);" class="checkBtn checkBtnStyle"
                                    data-type="directReferrals">Check</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="box-counter">
                                <span>Direct Investment</span>
                                <br>
                                <a href="javascript:void(0);" class="checkBtn checkBtnStyle"
                                    data-type="directInvestments">Check</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="box-counter">
                                <span>Direct Commission</span>
                                
                                <br>
                                <a href="javascript:void(0);" class="checkBtn checkBtnStyle"
                                    data-type="directCommission">Check</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="box-counter">
                                <span>Indirect Referrals</span>
                                <br>
                                <a href="javascript:void(0);" class="checkBtn checkBtnStyle"
                                    data-type="indirectReferrals">Check</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="box-counter">
                                <span>Indirect Investment</span>
                                <br>
                                <a href="javascript:void(0);" class="checkBtn checkBtnStyle"
                                    data-type="indirectInvestments">Check</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="box-counter">
                                <span>Indirect Commission</span>
                                <br>
                                <a href="javascript:void(0);" class="checkBtn checkBtnStyle"
                                    data-type="indirectCommission">Check</a>
                            </div>
                        </div>

                    </div>
                </div>

                                <div class="form-group mb-3">
                    <label>Referral Link</label>
                    <div class="input-group">
                        <input type="text" name="text" class="form-control form--control referralURL"
                            value="../reference/1094358815" readonly>
                        <button class="input-group-text bg--base copytext copyBoard" id="copyBoard">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
        </div>
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="../assets/global/js/jquery-3.6.0.min.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <script src="../assets/global/js/bootstrap.bundle.min.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/waypoints.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <!-- Bootstrap 5 js -->
    <!-- Pluglin Link -->
    <script src="../assets/templates/hyip_gold/js/lib/slick.min.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/meanmenu.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/counterup.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <script src="../assets/templates/hyip_gold/js/lib/wow.min.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <!-- Main js -->
    <script src="../assets/templates/hyip_gold/js/main.js?v=1.0.0" type="73f3a2659898610bb3388e61-text/javascript"></script>
            <script src="../assets/global/js/jquery.treeView.js" type="73f3a2659898610bb3388e61-text/javascript"></script>
    <script type="73f3a2659898610bb3388e61-text/javascript">
        (function($) {
            "use strict"
            $('.treeview').treeView();
            $('.copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });

            $('.checkBtn').on('click', function() {
                if ($(this).hasClass('checkBtn')) {
                    let type = $(this).data('type');
                    $(this).html('<i class="fa fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: "../user/referrals/data",
                        data: {
                            type: type
                        },
                        success: (response) => {
                            $(this).html(response.message);
                            $(this).removeClass('checkBtn');
                            $(this).css('cursor', 'default');
                        }
                    });
                }
            });
        })(jQuery);
    </script>
        <script type="73f3a2659898610bb3388e61-text/javascript">
            (function($) {
                "use strict";
                $(".langSel").on("change", function() {
                    window.location.href = "../change/" + $(this).val();
                });

            })(jQuery);
        </script>
        <script type="73f3a2659898610bb3388e61-text/javascript">
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
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TV512QWDND" type="73f3a2659898610bb3388e61-text/javascript"></script>
                <script type="73f3a2659898610bb3388e61-text/javascript">
                  window.dataLayer = window.dataLayer || [];
                  function gtag(){dataLayer.push(arguments);}
                  gtag("js", new Date());
                
                  gtag("config", "G-TV512QWDND");
                </script>    <link rel="stylesheet" href="../assets/global/css/iziToast.min.css">
<script src="../assets/global/js/iziToast.min.js" type="73f3a2659898610bb3388e61-text/javascript"></script>

<script type="73f3a2659898610bb3388e61-text/javascript">
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
        <script type="73f3a2659898610bb3388e61-text/javascript">
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
    


    <script type="73f3a2659898610bb3388e61-text/javascript">
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

<script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="73f3a2659898610bb3388e61-|49" defer></script></body>

</html>
