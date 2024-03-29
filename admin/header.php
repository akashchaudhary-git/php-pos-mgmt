<?php
session_start();
include_once('../config/connectdb.php');

// check current dashboard page set active to sidebar links
$filename = basename($_SERVER["SCRIPT_FILENAME"], '.php'); //for eg- dashboard.php
$$filename = true; //$dashboard = true

// if $_SESSION is empty/ User has not logged in redirect to main 
if (isset($_SESSION['user_email'])) {
    // allow only admin to access dashboard else redirect
    if (!($_SESSION['user_role'] === 'Admin')) {
        if ($_SESSION['user_role'] === 'User') {
            header("Location:../user/index.php");
        } else {
            header("Location:../index.php");
        }
    } else {
        // if loggeduser is admin do nothing
    }
} else {
    header("Location:../index.php");
}

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Admin - <?= ucwords($filename) ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css" />

    <link rel="stylesheet" href="../plugins/ion-rangeslider/css/ion.rangeSlider.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css" />

    <!-- jsGrid theme -->
    <link rel="stylesheet" href="../plugins/jsgrid/jsgrid.css" />
    <link rel="stylesheet" href="../plugins/jsgrid/jsgrid-theme.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <!-- Sweetalert JS v2.1.2 -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'></script>
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>

    <!-- Custom Script -->
    <script type="text/javascript">
        // Sweet alert script function

        function logOut() {
            swal({
                    title: "Attention!",
                    text: "You'll be logged out from your account",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((logout) => {
                    if (logout) {
                        window.location = "logout.php";
                    }
                });
        }
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-orange navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="dashboard.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link"><?php echo $filename; ?></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <li class="nav-item dropdown show">
                    <!-- Account Settings -->
                    <a class="nav-link dropdown-toggle" title="Account Settings" href="#" id="settingDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users-cog"> </i>
                        <?php echo $_SESSION['user_name']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" aria-labelledby="settingDropdown">
                        <a class="dropdown-item" href="#">
                            <small class="text-muted mb-4">
                                <i class="fas fa-envelope"></i>
                                &nbsp;<?php echo $_SESSION['user_email']; ?></small>
                        </a>
                        <a class="dropdown-item" href="changepassword.php">
                            <i class="fas fa-key"></i>
                            &nbsp;Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick="logOut();" id="logtOut" href="#">
                            <i class="fas fa-sign-out-alt"></i>
                            &nbsp;Log Out
                        </a>

                    </div>
                </li>
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- Fullscreen -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" title="Fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-teal elevation-4">
            <!-- Brand Logo -->
            <a href="dashboard.php" class="brand-link">
                <img src="../dist/img/AdminLTELogo.png" alt="POS Management" class="brand-image img-circle elevation-3" style="opacity: 0.6" />
                <span class="brand-text font-weight-light">POS Management</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-2 mb-3  d-flex">
                    <div class="image">
                        <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['user_name']; ?></a>
                    </div>
                </div>


                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <!-- Dashboard link -->
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link <?php echo '' . ($dashboard) ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <!-- Manage User Registration link -->
                        <li class="nav-item">
                            <a href="manageuser.php" class="nav-link <?php echo '' . ($manageuser) ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Manage Users
                                    <!-- <span class="right badge badge-danger">New</span> -->
                                </p>
                            </a>
                        </li>
                        <!-- Category link -->
                        <li class="nav-item">
                            <a href="category.php" class="nav-link <?php echo '' . ($category) ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>
                                    Category
                                </p>
                            </a>
                        </li>
                        <!-- Product link -->
                        <li class="nav-item">
                            <a href="product.php" class="nav-link <?php echo '' . ($product) ? 'active' : ''; ?>">
                                <!-- <i class="nav-icon fas fa-qrcode"></i> -->
                                <!-- <i class="nav-icon fas fa-apple-alt"></i> -->
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>