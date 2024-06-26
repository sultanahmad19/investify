<?php
session_start();
include('dbcon.php');

$message = '';
$message_type = '';

if (!isset($_SESSION['email'])) {
    die('No logged-in user. Please login.');
    header('Location: ../login.php');
    exit();
}

$logged_in_email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $logged_in_email;
    $account = $_POST['account'];
    $gateway = $_POST['gateway'];
    $message_content = $_POST['message'];
    $amount = $_POST['amount'];

    if ($amount < 10) {
        $message = "Withdrawal amount must be at least 10 USD.";
        $message_type = "danger";
    } else {
        $sql = "INSERT INTO `withdraw` (`email`, `account`, `gateway`, `message`, `amount`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $message = "Error preparing statement: " . $conn->error;
            $message_type = "danger";
        } else {
            $stmt->bind_param("ssssi", $email, $account, $gateway, $message_content, $amount);

            if ($stmt->execute()) {
                $message = "Withdrawal request submitted successfully!";
                $message_type = "success";
                header("Refresh: 1; URL=dashboard.php");
            } else {
                $message = "SQL Error: " . $stmt->error;
                $message_type = "danger";
            }

            $stmt->close();
        }

        $conn->close();
    }
}
?>

<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="aLqZIwD1QSKytuEgW8Hr2AWLgxNiAEMrqFQaeaBJ" />
    <title>Withdraw Money | Investify</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- favicon  -->
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">

    <link href="../assets/global/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/global/css/line-awesome.min.css"/>
    <!-- Plugin Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/main.css">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../assets/templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">
    <style>
        .popup {
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            background-color: blueviolet; /* Green */
            color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s;
        }

        .popup.show {
            opacity: 1;
        }
    </style>
</head>

<body>
<?php include('navbar.php') ?>

<div class="body-wrapper">
    <?php if ($message): ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
        <h6 class="page-title">Withdraw Money</h6>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card custom--card">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group mb-3 has-icon-select">
                            <label class="form-label">Method</label>
                            <select class="form-select form--control" name="gateway" required>
                                <option value="">Select Gateway</option>
                                <option value="Perfect-money">Perfect Money</option>
                                <option value="Binance">Binance</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="account" required class="form-control form--control">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Message</label>
                            <input type="text" name="message" value="I want to withdraw my amount!" class="form-control form--control">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Amount (USD)</label>
                            <input type="number" name="amount" min="10" required class="form-control form--control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Submit" class="btn btn--outline-base w-100 mt-3">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="../assets/global/js/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="../assets/global/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="../assets/templates/hyip_gold/js/lib/waypoints.js" type="text/javascript"></script>
<!-- Bootstrap 5 js -->
<!-- Pluglin Link -->
<script src="../assets/templates/hyip_gold/js/lib/slick.min.js" type="text/javascript"></script>
<script src="../assets/templates/hyip_gold/js/lib/meanmenu.js" type="text/javascript"></script>
<script src="../assets/templates/hyip_gold/js/lib/counterup.js" type="text/javascript"></script>
<script src="../assets/templates/hyip_gold/js/lib/wow.min.js" type="text/javascript"></script>
<!-- Main js -->
<script src="../assets/templates/hyip_gold/js/main.js?v=1.0.0" type="text/javascript"></script>

</html>
