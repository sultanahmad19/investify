


<?php
session_start();

include('dbcon.php');


// Get the search term from the GET request
$search = isset($_GET['search']) ? $_GET['search'] : null;

// SQL query to fetch all transactions
$sql = "SELECT trx_id, name, email, amount, twithdraw, created_at FROM transactions";

// If there's a search term, adjust the query to include a WHERE clause
if ($search) {
    $sql = "SELECT trx_id, name, email, amount, twithdraw, created_at 
            FROM transactions 
            WHERE trx_id LIKE ? OR name LIKE ? OR email LIKE ?";
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters
if ($search) {
    $like_pattern = '%' . $search . '%'; // Wildcard pattern for LIKE
    $stmt->bind_param("sss", $like_pattern, $like_pattern, $like_pattern); // Bind parameters for search
}

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result(); // Get the result set
?>








<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Deposit History | Investify</title>
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
            <h6 class="page-title">Deposit History</h6>
            <form action="" method="GET"> <!-- Capture search term via GET request -->
                <div class="input-group">
                    <input type="text" name="search" class="form--control form-control" value=""
                        placeholder="Search by transactions, name, or email"> <!-- Input field for search -->
                    <button type="submit" class="input-group-text bg--base ">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

        </div>
        <div class="row justify-content-end">


        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="dashboard-table">

                <table class="table transection__table bg-red table--responsive--xl">
    <thead>
        <tr>
            <th>Trx_id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Deposit</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr class="text-center">';
                echo '<td>' . htmlspecialchars($row['trx_id']) . '</td>'; // Display trx_id
                echo '<td>' . htmlspecialchars($row['name']) . '</td>'; // Display name
                echo '<td>' . htmlspecialchars($row['email']) . '</td>'; // Display email
                echo '<td class="budget">' . htmlspecialchars($row['amount']) . ' USD</td>'; // Display deposit
                echo '<td>' . htmlspecialchars($row['created_at']) . '</td>'; // Display time
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No transactions found.</td></tr>';
        }
        ?>
    </tbody>
</table>

<?php
// Free the result set and close the prepared statement and connection
$result->free();
$stmt->close();
$conn->close(); // Close the database connection
?>

           
                </div>
            </div>
        </div>

        <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content  modal--content">
                    <div class="modal-header modal--header">
                        <h5 class="modal-title modal--title">Details</h5>
                        <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body  modal--body">
                        <ul class="list-group userData mb-2">
                        </ul>
                        <div class="feedback"></div>
                    </div>
                    <div class="modal-footer modal--footer">
                        <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal">Close</button>
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















    <!-- <a id="chatLink" class="support-float" href="../ticket/new">
        <img src="../assets/images/support.png" />
    </a> -->
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