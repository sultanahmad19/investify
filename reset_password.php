<?php
session_start();
include('user/dbcon.php');

if(isset($_POST['token'], $_POST['password'])) {
    $token = $_POST['token'];
    $new_password = $_POST['password'];

    $sql = "SELECT email FROM users WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_sql = "UPDATE users SET password = ?, token = NULL WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $hashed_password, $email);
        
        if ($update_stmt->execute()) {
            echo "<script>alert('Password updated successfully.');</script>";
            echo "<script>setTimeout(function() { window.location.href = 'login.php'; }, 0);</script>";
            exit;
        } else {
            echo "Error updating password: " . $conn->error;
        }

        $update_stmt->close();
    } else {
        echo "Token not found or invalid.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="XhVL1HZ4TLVjUyxnIQRNUw6Kh3Xd5RCF4dzrQ6Ll" />
    <title>Reset Password | Investify</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- favicon  -->
    
    <link href="images/favicon.png" rel="icon" type="image/x-icon">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Plugin Link -->
    <link rel="stylesheet" href="templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/main.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">

</head>
<body>
    <!-- Overlay -->
    <div class="overlay"></div>
    <a href="javascript::void(0)" class="scrollToTop"><i class="las la-chevron-up"></i></a>

    <?php include('components/navbar.php')?>



    <section class="signup-page pt-120 pb-120 section-common-bg">
        <div class="container">
            <div class="row justify-content-center align-items-center ">
                <div class="col-xl-6 col-lg-6">
                    <div class="sign-in-left d-none d-lg-inline-block">
                        <img class="w-100" src="templates/hyip_gold/images/login.png" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <form  
                        class="verify-gcaptcha signup-form account-create-form primary-bg" role="form" method="POST">
                        <h2 class="signup-form-title">
                        Reset Password </h2>
                        <div class="row">

                        <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">
       

                        <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password" class="form-label">Add New Password</label>
                                    <input type="password" id="password" class="form-control form--control" name="password" required>
                                </div>

                            <div class="mb-3">
                            </div>

                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" id="recaptcha" class="btn btn--outline-base w-100">
                            Reset Password </button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </section>

  


</body>
</html>

