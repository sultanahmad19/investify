<?php
session_start();

include('user/dbcon.php'); // Assuming this includes your database connection

// Variables to store alert messages
$emailExistsAlert = '';
$passwordFormatAlert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $referred_by = $_POST['referral_code'] ?? null;

    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $checkStmt = $conn->prepare($checkEmailQuery);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $emailExistsAlert = "Email already exists. Please use a different email.";
        } else {
            // Validate password format
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
                $passwordFormatAlert = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
            } else {
                // Hash the password securely
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Generate a unique referral code
                $referral_code = strtoupper(bin2hex(random_bytes(5)));

                // Use prepared statements to insert data
                $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, referral_code, referred_by) VALUES (?, ?, ?, ?, ?, ?)");

                if ($stmt) {
                    $stmt->bind_param("ssisss", $name, $email, $phone, $hashedPassword, $referral_code, $referred_by);

                    if ($stmt->execute()) {
                        // Check if there's a referral code and process referral earnings
                        if (!empty($referred_by)) {
                            // Fetch the referrer's email based on the referral code
                            $getReferrerEmailQuery = "SELECT email FROM users WHERE referral_code = ?";
                            $getReferrerStmt = $conn->prepare($getReferrerEmailQuery);
                            $getReferrerStmt->bind_param("s", $referred_by);
                            $getReferrerStmt->execute();
                            $getReferrerResult = $getReferrerStmt->get_result();

                            if ($getReferrerResult->num_rows > 0) {
                                $referrerRow = $getReferrerResult->fetch_assoc();
                                $referrerEmail = $referrerRow['email'];

                                // Update the referrer's referral count or any other relevant action upon registration

                                // Example: Update the referrer's referral count
                                // $updateReferrerCountQuery = "UPDATE users SET referral_count = referral_count + 1 WHERE email = ?";
                                // $updateReferrerCountStmt = $conn->prepare($updateReferrerCountQuery);
                                // $updateReferrerCountStmt->bind_param("s", $referrerEmail);
                                // $updateReferrerCountStmt->execute();

                                // $updateReferrerCountStmt->close();
                            }

                            $getReferrerStmt->close();
                        }

                        header('Location: login.php'); // Redirect to login page after successful registration
                        exit(); // Exit after redirection
                    } else {
                        echo 'Registration failed: ' . $stmt->error;
                    }

                    $stmt->close(); // Close the statement
                } else {
                    echo 'Statement preparation failed: ' . $conn->error;
                }
            }
        }
    }
}

// Close the connection
$conn->close();
?>


<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="XhVL1HZ4TLVjUyxnIQRNUw6Kh3Xd5RCF4dzrQ6Ll" />
    <title>Register | Investify</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="images/favicon.png" rel="icon" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/lib/slick.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/lib/meanmenu.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/lib/animated.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/main.css">
    <link rel="stylesheet" href="templates/hyip_gold/css/custom.css?cs">
    <link rel="stylesheet" href="templates/hyip_gold/css/color.php?color=be9142&secondColor=f8f58f">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .phone-container {
            margin: 20px;
        }
    </style>
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
                        <img class="w-100" src="templates/hyip_gold/images/register.png" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <form class="verify-gcaptcha signup-form account-create-form primary-bg" role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="XhVL1HZ4TLVjUyxnIQRNUw6Kh3Xd5RCF4dzrQ6Ll">
                        <h2 class="signup-form-title">Create Account</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label"> Name</label>
                                    <input type="text" class="form-control form--control" name="name" value="" required>
                                    <small class="text-danger usernameExist"></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">E-Mail Address</label>
                                    <input type="email" class="form-control form--control checkUser" name="email" value="" required>
                                    <?php if (!empty($emailExistsAlert)) : ?>
                                        <small class="text-danger"><?php echo $emailExistsAlert; ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <div class="input-group">
                                        <input type="tel" id="phone" name="phone" value="" class="form-control form--control checkUser" required>
                                    </div>
                                    <small class="text-danger mobileExist"></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control form--control" name="password" required>
                                    <?php if (!empty($passwordFormatAlert)) : ?>
                                        <small class="text-danger"><?php echo $passwordFormatAlert; ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Referral Code (optional)</label>
                                    <input type="text" id="referral_code" class="form-control form--control" name="referral_code" placeholder="Referral Code">
                                </div>
                            </div>
                            <div class="mb-3"></div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" id="recaptcha" class="btn btn--outline-base w-100">Register</button>
                        </div>
                        <p class="mb-0">
                            Already have an account? <a href="login.php" class="text--base">Login</a>
                        </p>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const referralCode = urlParams.get('ref');

            if (referralCode) {
                document.getElementById('referral_code').value = referralCode;
            }
        });
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInputField = document.querySelector("#phone");
        const iti = window.intlTelInput(phoneInputField, {
            initialCountry: "auto",
            preferredCountries: ["pk", "in"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        phoneInputField.addEventListener("blur", function() {
            const phoneNumber = iti.getNumber();
            console.log("Phone number with country code:", phoneNumber);
        });
    </script>

</body>
</html>
