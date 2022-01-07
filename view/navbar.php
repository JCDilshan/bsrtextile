<!doctype html>
<html lang="en">

<?php
include_once("../common/cartSession.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/icon" href="../image/logo/logo1.png">

    <title>BOSARA TEXTILE</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../css/custom.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.7/dist/sweetalert2.all.min.js"></script>

    <style>
        .sec-nav {
            min-height: 80px;
            height: auto;
            background-color: rgba(255, 255, 255, 0.8);
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body>
    <div style="background-color: #db9200; height:8px;"></div>

    <nav class="navbar navbar-expand-md navbar-light bg-light justify-content-md-around">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-none d-md-block">
            <a href="tel:+94763669100" class="font-weight-lighter" style="color:#808080"><i class="fas fa-phone-rotary mr-2"></i> +94 763669100</a>
            <a href="https://www.facebook.com" class="text-decoration-none" target="_blank" style="color:#808080"><i class="fab fa-facebook-f mr-3"></i></a>
            <a href="https://www.twitter.com" class="text-decoration-none" target="_blank" style="color:#808080"><i class="fab fa-twitter mr-3"></i></i></a>
            <a href="https://www.youtube.com" class="text-decoration-none" target="_blank" style="color:#808080"><i class="fab fa-youtube mr-3"></i></a>
        </div>

        <div class="collapse navbar-collapse order-1 order-md-0" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mr-2">
                    <a href="home.php" class="text-decoration-none" style="color:#808080">Home</a>
                </li>
                <li class="nav-item mr-2">
                    <a href="dashboard.php" class="text-decoration-none" style="color:#808080">My Profile</a>
                </li>
                <li class="nav-item mr-2">
                    <a href="contactus.php" class="text-decoration-none" style="color:#808080">Contact Us</a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="text-dark text-decoration-none" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Involve with us <i class="fas fa-caret-down"></i>
                    </a>
                    <div class="collapse pl-3" id="collapseExample">
                        <div>
                            <a href="tel:+94763669100" class="font-weight-lighter " style="color:#808080"><i class="fas fa-phone-rotary"></i> +94 763669100</a>
                        </div>
                        <div>
                            <a href="https://www.facebook.com" class="mr-2" target="_blank" style="color:#808080"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.twitter.com" class="mr-2" target="_blank" style="color:#808080"><i class="fab fa-twitter"></i></i></a>
                            <a href="https://www.youtube.com" class="mr-2" target="_blank" style="color:#808080"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div>
            <span class="pl-2" style="color:#808080;">
                <span style="font-size: larger"><i class="fas fa-user-circle"></i></span>

                <?php if (isset($_SESSION["customer"])) { ?>
                    <span>Hi...! <?php echo $_SESSION["customer"]["userFname"]; ?></span> &nbsp;
                    <a id="logoutBtn" href="../controller/login_controller.php?type=logout" class="button btn border-0 text-white text-uppercase text-decoration-none" style="color:#808080;">
                        <i class="fas fa-sign-out"></i> Logout </a>
            </span>&nbsp;&nbsp;
        <?php } else { ?>

            <span>Hi...! User</span> &nbsp;
            <a id="loginBtn" href="login.php" class="button btn border-0 text-white text-uppercase text-decoration-none" style="color:#808080;">
                <i class="fas fa-sign-in"></i> Login </a>
            </span>&nbsp;&nbsp;
        <?php } ?>
        </div>

    </nav>

    <!-- /////////////////////////////////// 2nd Navbar ///////////////////////////////////// -->
    <nav class="navbar sec-nav sticky-top navbar-expand-sm justify-content-center">

        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button> -->

        <div class="mid-logo mr-auto">
            <div class="navbar-brand">
                <img src="../image/logo/logo1.png" width="200px" height="100px" class="align-top" alt="logo">
            </div>
        </div>

        <ul class="navbar-nav text-uppercase font-weight-bolder">
            <li class="nav-item">
                <a class="nav-link navmenu" href="home.php#newIn">new in</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navmenu" href="home.php#collection">collections</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navmenu" href="aboutUs.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navmenu" href="cart.php" style="font-size: large">
                    <i class="fas fa-shopping-cart"></i>

                    <?php $count = isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "0"; ?>
                    <span class="badge badge-notify text-white">
                        <?php echo $count; ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>