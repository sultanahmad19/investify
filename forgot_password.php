<?php
session_start();
include('user/dbcon.php');
include('smtp/PHPMailerAutoload.php');

function generateToken($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $token;
}

function smtp_mailer($to, $subject, $msg) {
    $mail = new PHPMailer(); 
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    //$mail->SMTPDebug = 2; 
    $mail->Username = "officialinvestify@gmail.com";
    $mail->Password = "gzrz fadh yyyq zfth";
    $mail->SetFrom("officialinvestify@gmail.com");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    if(!$mail->Send()) {
        return $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $token = generateToken();
    $subject = "Password Reset";
    $msg = "Click the following link to reset your password: http://localhost/investify/reset_password.php?token=$token";
    // $msg = "Click the following link to reset your password: http://https://cryptotreasuresinvest.com/reset_password.php?token=$token";

    $result = smtp_mailer($email, $subject, $msg);
    
    if ($result === 'Sent') {
        // Update user record with token
        $updateTokenQuery = "UPDATE users SET token = ? WHERE email = ?";
        $updateTokenStmt = $conn->prepare($updateTokenQuery);
        $updateTokenStmt->bind_param("ss", $token, $email);
        $updateTokenStmt->execute();
        $updateTokenStmt->close();

        echo "<script>alert('Password reset instructions sent to your email.');</script>";
        echo "<script>setTimeout(function() { window.location.href = 'login.php'; }, 0);</script>";
        exit;
    } else {
        echo "Failed to send password reset instructions. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="XhVL1HZ4TLVjUyxnIQRNUw6Kh3Xd5RCF4dzrQ6Ll" />
    <title>Forgot Password | Investify</title>
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
                        class="verify-gcaptcha signup-form account-create-form primary-bg" role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <h2 class="signup-form-title">
                            Forgot Password </h2>
                        <div class="row">

                          

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">E-Mail Address</label>
                                    <input type="email" id="email" class="form-control form--control checkUser" name="email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                            </div>

                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" id="recaptcha" class="btn btn--outline-base w-100">
                                Submit </button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </section>

  


</body>
</html>

