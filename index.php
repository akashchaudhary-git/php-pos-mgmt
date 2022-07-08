<?php
include_once('./config/connectdb.php');
// session_start();
$login_err = 'Sign in to start your session';
if (isset($_POST['submit'])) {
    $useremail = htmlspecialchars($_POST['email']);
    $userpassword = htmlspecialchars($_POST['password']);

    // Check User Validation
    $query = $con->prepare("SELECT * FROM table_users WHERE user_email=:email AND user_password=:password");
    $query->bindValue(":email", $useremail);
    $query->bindValue(":password", $userpassword);
    $query->execute();



    if ($query->rowCount() == 1) {
        header("Refresh:1; ./admin/dashboard.php");
    } else {
        $login_err = "<span class='bg-maroon rounded shadow p-1'>Please enter correct login details</span>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS Management | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="hold-transition bg-warning login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="./index.php"><b>POS</b>Management</a>
        </div>
        <!-- /.login-logo -->
        <div class="card shadow rounded">
            <div class="card-body login-card-body">

                <?php echo '<p class="login-box-msg ">' . $login_err . '</p>'; ?>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>



                <p class="mb-1 mt-3">
                    <a href="#">I forgot my password</a>
                </p>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
</body>

</html>