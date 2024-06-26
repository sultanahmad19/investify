<?php
session_start();
include('dbcon.php');
include('../smtp/PHPMailerAutoload.php');

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
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    if(!$mail->Send()) {
        return $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}

$login_feedback = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("SELECT name, email, password FROM admin WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($fetched_name, $fetched_email, $hashed_password);
                $stmt->fetch();
                if (password_verify($password, $hashed_password)) {
                    $token = generateToken();
                    $subject = "Admin Login Confirmation";
                    $msg = "Click the following link to confirm your login and access the dashboard: http://localhost/investify/admin/admin_dashboard.php?token=$token";
                    // $msg = "Click the following link to confirm your login and access the dashboard: https://cryptotreasuresinvest.com/admin/admin_dashboard.php?token=$token";


                    $result = smtp_mailer($email, $subject, $msg);
                    if ($result === 'Sent') {
                        $updateTokenQuery = "UPDATE admin SET login_token = ? WHERE email = ?";
                        $updateTokenStmt = $conn->prepare($updateTokenQuery);
                        $updateTokenStmt->bind_param("ss", $token, $email);
                        $updateTokenStmt->execute();
                        $updateTokenStmt->close();

                        echo "<script>alert('Login confirmation link sent to your email.');</script>";
                        echo "<script>setTimeout(function() { window.location.href = 'login.php'; }, 0);</script>";
                        exit;
                    } else {
                        $login_feedback = "Failed to send confirmation link. Please try again later.";
                    }
                } else {
                    $login_feedback = 'Incorrect password.';
                }
            } else {
                $login_feedback = 'No user found with that email.';
            }
        } else {
            $login_feedback = 'Query execution failed: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $login_feedback = 'Statement preparation failed: ' . $conn->error;
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="XhVL1HZ4TLVjUyxnIQRNUw6Kh3Xd5RCF4dzrQ6Ll" />
    <title> Login | Investify</title>
    <link rel="stylesheet" href="../css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Plugin Link -->
    <link rel="stylesheet" href="../templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="../templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="../templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="../templates/hyip_gold/css/main.css">
    <link rel="stylesheet" href="../templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="../templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">

</head>
<body>
    <!-- Overlay -->
    <div class="overlay"></div>
    <a href="javascript::void(0)" class="scrollToTop"><i class="las la-chevron-up"></i></a>

    <?php include('navbar1.php')?>



    <section class="signup-page pt-120 pb-120 section-common-bg">
        <div class="container">
            <div class="row justify-content-center align-items-center ">
                <div class="col-xl-6 col-lg-6">
                    <div class="sign-in-left d-none d-lg-inline-block">
                        <img class="w-100" src="../templates/hyip_gold/images/login.png" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <form  
                        class="verify-gcaptcha signup-form account-create-form primary-bg" role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="XhVL1HZ4TLVjUyxnIQRNUw6Kh3Xd5RCF4dzrQ6Ll">
                        <h2 class="signup-form-title">
                            Admin Login </h2>
                        <div class="row">

                          

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">E-Mail Address</label>
                                    <input type="email" id="email" class="form-control form--control checkUser" name="email"
                                        value="" required>
                                </div>
                            </div>

                           

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" id="password" class="form-control form--control" name="password" required>
                                </div>
                            </div>

                            
                            <div class="mb-3 text-danger">
                    <?php echo $login_feedback; ?>

                            </div>

                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" id="recaptcha" class="btn btn--outline-base w-100">
                                Login </button>
                        </div>
                        
                        <br>
                        <p class="mb-0">
                        Go back to User login? <a href="../login.php" class="text--base">
                                <strong>User</strong> </a>
                        </p>
                      
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="modal custom--modal fade" id="existModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header ">
                    <h5 class="modal-title " id="existModalLongTitle">You are with us</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
                <div class="modal-body  ">
                    <h6 class="text-center ">You already have an account please Login </h6>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <a href="login.php" class="btn btn--base btn-sm">Register</a>
                </div>
            </div>
        </div>
    </div>


</body>
</html>