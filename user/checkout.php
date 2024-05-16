
<?php
session_start();

// Ensure there's a logged-in user and retrieve their email
if (!isset($_SESSION['email'])) {
    die('No logged-in user. Please login.'); // Provide an appropriate message or redirect to login
}

// Database connection details
$host = 'localhost';
$dbname = 'digital'; // Your database name
$user = 'root';
$pass = '';

// Create a new mysqli connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$usd_to_pkr_rate = 278.56; // Example conversion rate, adjust as needed

// Get the logged-in user's email
$logged_in_email = $_SESSION['email'];

// Fetch the latest deposit amount for the logged-in user
$amountQuery = "SELECT amount FROM deposit WHERE email = ? ORDER BY id DESC LIMIT 1"; 
$stmt = $conn->prepare($amountQuery);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$amountResult = $stmt->get_result();

$amount = 0;
$pkr_amount = 0;

if ($amountResult->num_rows > 0) {
    $amountRow = $amountResult->fetch_assoc();
    $amount = htmlspecialchars($amountRow['amount']); // Sanitize the amount
    
    // Convert amount from USD to PKR
    $pkr_amount = $amount * $usd_to_pkr_rate; // Conversion to PKR
} else {
    echo 'No deposit records found for the logged-in user.<br>';
}

// Fetch the logged-in user's name and email
$userQuery = "SELECT name, email FROM users WHERE email = ?"; 
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$userResult = $stmt->get_result();

$name = '';
$email = '';

if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $name = htmlspecialchars($userRow['name']); // Sanitize the name
    $email = htmlspecialchars($userRow['email']); // Sanitize the email
} else {
    echo 'No user records found for the logged-in user.<br>';
}

// Close the database connection
$stmt->close();
$conn->close();
?>





<?php
// Database connection details
$host = 'localhost';
$dbname = 'digital';
$user = 'root';
$pass = '';

// Create a new mysqli connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data with error handling
    $id = isset($_POST['id']) ? $_POST['id'] : null; 
    $trx_id = isset($_POST['trx_id']) ? $_POST['trx_id'] : null;
    $method_code = isset($_POST['method_code']) ? $_POST['method_code'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $amount = isset($_POST['amount']) ? $_POST['amount'] : null;

    // Check for required fields
    if ($id && $trx_id && $method_code && $name && $email) {
        // Prepare the SQL statement with added fields
        $stmt = $conn->prepare("INSERT INTO transactions (id, trx_id, method_code, name, email, amount) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissi", $id,  $trx_id, $method_code, $name, $email, $amount);

        if ($stmt->execute()) {
           
            echo "
                <script>
                    alert('Transaction recorded successfully.');
                    setTimeout(function() {
                        window.location.href = 'deposit.php';
                    }, 1000); 
                </script>
            ";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error: Required fields are missing.";
    }
} 

$conn->close();
?>


<?php
// Database connection details
$host = 'localhost';
$dbname = 'digital';
$user = 'root';
$pass = '';

// Create a new mysqli connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data with error handling
    $id = isset($_POST['id']) ? $_POST['id'] : null; 
    $trx_id = isset($_POST['trx_id']) ? $_POST['trx_id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $amount = isset($_POST['amount']) ? $_POST['amount'] : null;

    // Check for required fields
    if ($id && $trx_id && $method_code && $name && $email) {
        // Prepare the SQL statement with added fields
        $stmt = $conn->prepare("INSERT INTO tdeposit (id, trx_id, name, email, tdeposit) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $id,  $trx_id, $name, $email, $amount);

        if ($stmt->execute()) {
           
            // echo "
            //     <script>
            //         alert('Transaction recorded successfully.');
            //         setTimeout(function() {
            //             window.location.href = 'deposit.php';
            //         }, 1000); 
            //     </script>
            // ";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error: Required fields are missing.";
    }
} 

$conn->close();
?>













<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Checkout | Investify</title>

<link rel="shortcut icon" type="image/png" href="https://www.onecashpk.com/assets/templates/basic/images/favicon.png">
<!-- bootstrap 4  -->
<link rel="stylesheet" href="https://www.onecashpk.com/assets/global/css/bootstrap.min.css">
<!-- fontawesome 5  -->
<link rel="stylesheet" href="https://www.onecashpk.com/assets/global/css/all.min.css"> 
<!-- lineawesome font -->
<link rel="stylesheet" href="https://www.onecashpk.com/assets/global/css/line-awesome.min.css"> 
  <!-- template css -->
  <link href="https://www.onecashpk.com/assets/global/css/new_template/template.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://www.onecashpk.com/assets/templates/basic/merchant/css/main.css?cache=1708657684">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <!-- favicon  -->
    
    <link href="../images/favicon.png" rel="icon" type="image/x-icon">

    
        <style>
            #wrapper #content-wrapper{
                background: #081828 !important
            }

            .checkout-wrapper{
                background: #0C2136 !important;
                box-shadow: 0 0 50px #000 !important
            }
            .checkout-section {
                padding: 2.5rem 0;
            }

            .checkout-wrapper .product-price {
                font-size: 1.47rem !important;
            }

            .checkout-wrapper__header .title {
                font-size: .9rem !important;
            }

            .checkout-wrapper .p-close {
                top: 12px;
                right: 10px;
                background: transparent;
            }

            .checkout-wrapper .p-close i {
                color: #fff;
                font-size: 16px
            }



            #onecash_pay_btn {
                background: #51b2c1;
                color: #fff;
                font-size: .95rem;
            }

            .policy-link:hover {
                color: #2c71ff !important;
            }

            .user-account-check {
                position: relative;
                cursor: pointer;
            }

            .user-account-check label i {
                -webkit-transition: all .3s;
                -o-transition: all .3s;
                transition: all .3s;
            }

            .user-account-check .form-check-input {
                position: absolute;
                top: 50%;
                right: 18px;
                transform: translate(50%, -74%);
            }

            .user-account-check .form-check-input:checked~label i {
                color: #ff6347;
            }

            .user-account-check label {
                display: flex;
                align-items: center;
                background-color: #081828;
                border: 0;
                border-radius: 8px;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                -ms-border-radius: 8px;
                -o-border-radius: 8px;
                padding: 20px 14px;
                gap: 12px;
            }

            .user-account-check label i {
                font-size: 4.5rem;
                color: #ff6347;
            }

            .user-account-check label span {
                display: block;
                color: #fff
            }

            .payment-list {
                margin-top: 20px
            }

            .payment-list .payment-detail,
            .payment-methods {
                text-align: left;
                color: #fff;
                font-size: 0.85rem;
                margin-bottom: 1rem;
                display: inline-block;
                ;
                font-weight: bold;
                position: relative;
            }

            .payment-list .payment-detail::after,
            .payment-methods::after {
                content: "";
                display: block;
                height: 2px;
                position: absolute;
                bottom: 0;
                background: #fff;
                width: 60%;
                top: 96%;

            }

            .payment-methods {
                margin-top: 1rem
            }

            .payment-list table {
                width: 100%;
                color: #fff;
                text-align: left;
                font-weight: 500;
            }


            .payment-list table td {
                font-size: 14px;
                padding-bottom: 10px;
                min-width: 100px;
                vertical-align: top;
            }

            .payment-list table td.head {
                font-weight: 600;

            }


            .btn-next,
            .btn-next:hover {
                background: #081828;
                color: #fff;
                border-radius: 10px;
                border: 0;
                box-shadow: none;
                width: 100%;
                padding: 12px;
                margin-top: 0;
            }

            .btn-report,
            .btn-report:hover,
            .btn-report:focus {
                font-size: 14px;
                color: #fff;
                margin-top: 12px;
                box-shadow: none
            }

            .checkout-wrapper.checkout-wrapper--dark .form--control{
                background: #081828;
            }

            .powered, .powered a{
                color: #b9b6b6 !important
            }

            @media(max-width: 768px) {
                .user-account-check label {
                    padding: 16px 14px
                }

                .form-logo {
                    width: 200px !important
                }
            }

            @media(max-width: 480px) {
                .form-logo {
                    width: 140px !important
                }
            }

            
            .row strong{
                color: #ff6347;
                margin-bottom: 10px;
            }
            .user-account-check label {
                font-weight: 300;
                
    color: white !important;
    font-size: 1rem !important;

            }
        </style>
    
</head>
  <body id="page-top">

     <!-- Page Wrapper -->
     <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
          <div id="content">
            

    <div class="checkout-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div
                        class="checkout-wrapper checkout-wrapper--dark shake-card border-0">

                                                                                    <a class="p-close" href="deposit.php" class="text--base"><i
                                        class="fas fa-times"></i></a>
                            
                            <div class="shape-two">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="#000" fill-opacity="0.9"
                                        d="M0,320L48,288C96,256,192,192,288,165.3C384,139,480,149,576,154.7C672,160,768,160,864,170.7C960,181,1056,203,1152,181.3C1248,160,1344,96,1392,64L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                    </path>
                                </svg>
                            </div>

                            <div class="checkout-wrapper__header text-center">
                                <img src="../assets/images/logoIcon/logo.png" alt="image" class="form-logo mb-3">

                                <div class="payment-list">
                                    <div class="text-left">
                                        <span class="payment-detail">Purchase Details</span>
                                    </div>
                                        <table>
                                         <tbody>
                                            <tr>
                                                <td>Description</td>
                                                <td>
                                                    Deposit amount: <?php echo $amount . ' USD'; ?> by 
                                                    <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="head">Domain</td>
                                                <td>Investify.com</td> 
                                            </tr>
                                            <!-- <tr>
                                                <td class="head">Currency</td>
                                                <td>PKR</td>
                                            </tr>
                                            <tr>
                                                <td class="head">Amount</td>
                                                <td>
                                                    <?php echo number_format($pkr_amount, 2) . ' Rs'; ?> 
                                                </td>
                                            </tr> -->
                                     </tbody>
                                    </table>
                                </div>
                            </div>



                            <div class="text-left">
                                <span class="payment-methods">Payment Methods</span>
                            </div>
                           
                            


                      

                            <form action="" method="POST" class="check-mail" id="gateway_form">
    
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
    

    <div class="row mt-2 mb-4">
        <strong>Please send payment to one of these accounts below.</strong>
        
        <!-- Payment Method Options -->
        <div class="col-md-12 mb-md-3 mb-2">
            <div class="user-account-check text-center">
                <!-- <input type="radio" class="form-check-input" name="method_code" id="payment0" value="1" required> -->
                <label class="form-check-label" for="payment0">
                    <img src="https://www.beyond2015.org/wp-content/uploads/2020/02/perfect-money-logo.png" width="22px" />
                    Perfect Money <span>Account: U43311670</span>
    <input type="radio" name="method_code" value="1" required> 

                </label>
            </div>
        </div>

        <div class="col-md-12 mb-md-3 mb-2">
            <div class="user-account-check text-center">
                <!-- <input type="radio" class="form-check-input" name="method_code" id="payment1" value="2" required> -->
                <label class="form-check-label" for="payment1">
                <img src="https://tse2.mm.bing.net/th?id=OIP.sCUHvV1Zz8m_U6AZb9yXvgAAAA&pid=Api&P=0&h=220" width="22px" />
                    Binance <span>Account: TDxQFVBUZP3bz4fKM2jTC<br>8GQv1STYMDrsU</span>
    <input type="radio" name="method_code" value="2" required> 

                </label>
            </div>
        </div>

       
        <div class="col-md-12 mb-md-3 mb-2">
        <div class="user-account-check  text-center">
            <label class="form-check-label">Name:
            <input type="text" name="name" value="<?php echo $name; ?>" readonly>
            </label>
        </div>

            <br>
            <div class="user-account-check  text-center">
            <label class="form-check-label">Email:
            <input type="email" name="email" value="<?php echo $email; ?>" readonly>
            </label>
        </div>
            <br>
            <div class="user-account-check  text-center">
            <label class="form-check-label">Amount:
            <input type="number" name="amount" value="<?php echo $amount ;?>" readonly>
            </label>
        </div>
        </div>

         <!-- Transaction ID Input -->
         <div class="col-md-12 mb-md-3 mb-2">
            <div class="user-account-check trx text-center">
                <h5 style="color: #ff6347;">Please enter the Transection Id:</h5>
                <label class="form-check-label trxid" for="trx_id">
                    Enter trxId:
                    
                    <input type="number" name="trx_id" placeholder="Enter trxId:" required>

                </label>
            </div>
        </div>

    </div>

    <!-- Submit Button -->
    <div class="text-center">
    <button type="submit" class="btn btn-next next">Submit</button>
        
    <!-- <button type="submit" class="btn btn-next next" id="gatewayNextBtn">Submit</button> -->
    </div>
    </form>



                            
                                            </div>
                </div>

                <div class="col-md-12 my-3">
                    <p class="font-size--14px text-center powered">Powered by <a href="#"
                            class="text--dark font-size--14px"><strong>ABC</strong></a>
                    </p>
                </div>


            </div>
        </div>
    </div>




    <!-- bootstrap js -->
    <script src="https://www.onecashpk.com/assets/global/js/bootstrap.bundle.min.js"></script>
      
    <link rel="stylesheet" href="https://www.onecashpk.com/assets/global/css/iziToast.min.css">
<script src="https://www.onecashpk.com/assets/global/js/iziToast.min.js"></script>


  </body>
</html>