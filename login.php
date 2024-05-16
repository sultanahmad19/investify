
<?php
session_start();

include('user/dbcon.php');


// Assuming the login script sets session variables after successful authentication
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Verify login and fetch user details
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $name, $email, $hashed_password);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                // Set session variables on successful login
                $_SESSION['user_id'] = $user_id;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                
                header("Location: user/dashboard.php");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No user found with that email.";
        }
        $stmt->close();
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
    <title>Login | Investify</title>
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
                        class="verify-gcaptcha signup-form account-create-form primary-bg" role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="XhVL1HZ4TLVjUyxnIQRNUw6Kh3Xd5RCF4dzrQ6Ll">
                        <h2 class="signup-form-title">
                            Login </h2>
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

                            
                            <div class="mb-3">
                            </div>

                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" id="recaptcha" class="btn btn--outline-base w-100">
                                Login </button>
                        </div>
                        <p class="mb-0">
                        Don't have an account? <a href="register.php" class="text--base">
                                Register </a>
                        </p>
                        <br>
                        <p class="mb-0">
                        Admin wants to login? <a href="admin/login.php" class="text--base">
                                <strong>Admin</strong> </a>
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
