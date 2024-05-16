<?php
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit;
}

// Fetch the logged-in user's name and email from session variables
$name = $_SESSION['name'] ?? '';
$email = $_SESSION['email'] ?? '';
?>






<div class="overlay"></div>
        <a href="javascript::void(0)" class="scrollToTop"><i class="las la-chevron-up"></i></a>
    
        
    
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
                <h6 class="dashboard-account__title fs-3">Hi Admin! <br><?php echo $name; ?></h6>
                

            </div>

            <div class="sidebar-menu">
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-list__item  ">
                        <a href="dashboard.php" class="sidebar-menu-list__link">
                            <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="users.php" class="sidebar-menu-list__link">
                            <span class="icon">
                                <i class="fas fa-users pr-1"></i>
                            </span>
                            <span class="text">Users</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item  ">
                        <a href="deposits.php" class="sidebar-menu-list__link">
                            <span class="icon">
                            <i class="fas fa-coins"></i>
                            </span>
                            <span class="text">Deposits</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item  ">
                        <a href="withdraws.php" class="sidebar-menu-list__link">
                            <span class="icon">
                            <i class="fa-solid fa-money-bill"></i>

                            </span>
                            <span class="text">Withdraws</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-list__item  ">
                        <a href="notification.php" class="sidebar-menu-list__link">
                            <span class="icon">
                            <i class="fa-regular fa-bell"></i>

                            </span>
                            <span class="text">Notification</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-list__item  ">
                        <a href="transection.php" class="sidebar-menu-list__link">
                            <span class="icon">
                            <i class="fa-solid fa-id-card"></i>
                            </span>
                            <span class="text">Tarnsections</span>
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
                    <a href="/cdn-cgi/l/email-protection#c7b4b2b7b7a8b5b387b5b3b4a0a8aba3e9a4a8aa">
                        <i class="fas fa-envelope"></i>
                        <span class="__cf_email__" data-cfemail="f2818782829d8086b2808681959d9e96dc919d9f">abc@gmail.com</span>
                    </a>
                </li>
            </ul>
        </div>






<!-- ------------ rigth navbar-----  -->




    <div class="nav-right">
            <ul class="prfile-menu">
                <li>
                    <div class="user-profile d-flex gap-1 align-items-center">
                                            <div class="dropdown">
                            <button class="btn dashboard-dropdown-button dropdown-toggle d-flex align-items-center " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-profile-meta">
                            <span class="name"><?php echo $name; ?></span>
                            <span class="meta-email"><a href="mailto:<?php echo $email; ?>" class="__cf_email__" data-cfemail="b5c2c4d3c4dcd8cfc3c2d5c3d3dd8bc2ced7"><?php echo $email; ?></a></span>
                        </span>
                                <span class="ms-2 fs-4 text-white">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </button>
                            <ul class="dashboard-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="profile-setting.php">
                                        <i class="fas fa-user"></i>
                                        Profile                                </a>
                                </li>
                                <!-- <li>
                                    <a class="dropdown-item" href="change-password.php">
                                        <i class="fas fa-key"></i>
                                        Password                                </a>
                                </li> -->
                                <li>
                                    <a class="dropdown-item" href="logout.php">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout                                </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>


