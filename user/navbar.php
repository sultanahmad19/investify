<?php
include('dbcon.php');


// Ensure the user is logged in
if (isset($_SESSION['user_id'])) {
    // Retrieve session variables for name and email
    $name = htmlspecialchars($_SESSION['name']); // Sanitize
    $email = htmlspecialchars($_SESSION['email']); // Sanitize
} else {
    // If not logged in, redirect to login page
    // header("Location: ../login.php");
    exit();
}

?>



<div class="overlay"></div>
        <a href="javascript::void(0)" class="scrollToTop"><i class="fas fa-chevron-up"></i></a>
    
        
    
        <div class="dashboard">
        <div class="dashboard-sidebar">
        <div class="inner-sidebar">
        <div class="sidebar-logo">
            <a href="dashboard.php">
                <img src="../images/logo.png" alt="logo img">
            </a>
        </div>
        <!-- Sidebar Remove Btn Start -->
        <div class="cross-btn d-lg-none d-block">
            <i class="fas fa-times"></i>
        </div>
        <!-- Sidebar Remove Btn End -->
        <div class="sidebar__menuWrapper">
            <!-- account blance start here -->
            <div class="dashboard-account">
                <div class="dashboard-account__icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h6 class="dashboard-account__title"><?php echo $name; ?></h6>
                <!-- <ul class="dashboard-account__wallet">
                    <li>
                        <span>
                        <?php if ($last_row): ?> 
                                <?php echo isset($last_row['tdeposit']) ? $last_row['tdeposit'] : 'No data'; ?> <?php else: ?> <p>0</p> <?php endif; ?> USD
                                     
                        </span>
                        (Deposit Wallet)
                    </li>
                    <li>
                        <span>
                        <?php echo $available_earnings; ?> USD
                        </span>
                        (Earning Wallet)
                    </li>
                </ul> -->

            </div>

            <div class="sidebar-menu">
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-list__item ">
                        <a href="dashboard.php" class="sidebar-menu-list__link">
                            <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="investment.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-cubes pr-1"></i>
                            </span>
                            <span class="text">Investment</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="deposit.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-coins"></i>
                            </span>
                            <span class="text">Add Deposit</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="deposit-history.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-coins"></i>
                            </span>
                            <span class="text">Deposit history</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-menu-list__item  ">
                        <a href="withdraw.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </span>
                            <span class="text">Withdraw</span>
                        </a>
                    </li> -->
                    <li class="sidebar-menu-list__item  ">
                        <a href="withdraw-history.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </span>
                            <span class="text">Withdraw Log</span>
                        </a>
                    </li>
                   

                   
                    
                                        <li class="sidebar-menu-list__item ">
                        <a href="transactions.php" class="sidebar-menu-list__link">
                            <span class="icon"><i class="fas fa-exchange-alt pr-1"></i></span>
                            <span class="text">Transaction</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item ">
                        <a href="referrals.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-handshake  pr-1"></i>
                            </span>
                            <span class="text">Referrals</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item ">
                        <a href="refer.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-handshake  pr-1"></i>
                            </span>
                            <span class="text">Referral Plans</span>
                        </a>
                    </li>


                    <li class="sidebar-menu-list__item ">
                        <a href="logout.php" class="sidebar-menu-list__link">
                            <span class="icon"><i class="fas fa-sign-out-alt"></i> </span>
                            <span class="text">Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>


<!-- ------------ rigth navbar-----  -->




<div class="dashboard-nav d-flex flex-wrap align-items-center justify-content-between">
        <!-- Hambarger Remove Btn Start -->
        <div class="nav-left d-lg-none d-block">
            <div class="hambarger-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="nav-left">
            <ul>
                <li>
                    <i class="fas fa-headset"></i>
                    Support            </li>
                    <li>
                                        <a href="mailto:officialinvestify@gmail.com">
                                        <i class="fa-solid fa-envelope"></i> officialinvestify@gmail.com
                                        </a>
                                    </li>
            </ul>
        </div>











    <div class="nav-right">

            <ul class="prfile-menu">
                <li>
                    <div class="user-profile d-flex gap-1 align-items-center">
                                            <div class="dropdown">
                            <button class="btn dashboard-dropdown-button dropdown-toggle d-flex align-items-center " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-profile-meta">
                                    <span class="name"><?php echo $name; ?></span>
                                    <span class="meta-email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></span>
                                </span>
                               
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>


<script>
   document.addEventListener("DOMContentLoaded", function() {
    // Get the dropdown button and trigger a click event to open the dropdown
    const dropdownButton = document.getElementById("dropdownMenuButton1");
    
    if (dropdownButton) {
        // Create a new MouseEvent to simulate a click
        const clickEvent = new MouseEvent("click", {
            bubbles: true,
            cancelable: true,
            view: window
        });

        // Dispatch the event to simulate the click
        dropdownButton.dispatchEvent(clickEvent);
    }
});


</script>