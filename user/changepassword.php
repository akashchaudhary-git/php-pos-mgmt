<?php
include_once('header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Change Password</small></h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row ">

                <div class="col">
                    <!-- general form elements -->
                    <div class="card card-outline card-primary py-2 px-3">
                        <div class="card-header">
                            <h3 class="card-title">Please enter your details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="emailInput">Email address</label>
                                    <input type="email" class="form-control" id="emailInput" value="<?php echo $_SESSION['user_email']; ?>" readonly disabled>
                                </div>
                                <div class="form-group">
                                    <label for="passwordOld">Old Password</label>
                                    <input type="password" class="form-control" id="passwordOld" name="passwordOld" value="<?php echo isset($_POST['change-password']) ? $_POST['passwordOld'] : ""; ?>" placeholder="Old Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="passwordNew">New Password</label>
                                    <input type="password" class="form-control" id="passwordNew" name="passwordNew" value="<?php echo isset($_POST['change-password']) ? $_POST['passwordNew'] : ""; ?>" placeholder="Enter new Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="passwordConfirm">Confirm Password</label>
                                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" value="<?php echo isset($_POST['change-password']) ? $_POST['passwordConfirm'] : ""; ?>" placeholder="Confirm Password" required>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" name="change-password" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->


<?php

include_once('footer.php');
if (isset($_POST['change-password'])) {
    $useremail = $_SESSION['user_email'];
    $old_pass = htmlspecialchars($_POST['passwordOld']);
    $new_pass = htmlspecialchars($_POST['passwordNew']);
    $confirm_pass = htmlspecialchars($_POST['passwordConfirm']);

    $query = $con->prepare("SELECT * FROM table_users WHERE user_email=:email");
    $query->bindValue(":email", $useremail);
    $query->execute();

    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row['user_password'] === $old_pass) {

        // Check both new passwords match
        if ($new_pass === $confirm_pass) {
            // echo '<script>alert("Old Password match");</script>';
            // insert the updated password for current user

            // check if old password matches the new password otherwise update the entry
            if ($old_pass === $confirm_pass) {
                echo '<script>swal("Try using other than your current password!", {
                    title:"Matches old password!",
                    buttons: false,
                    timer: 3000,
                    icon: "warning",
                  });</script>';
            } else {

                $updateQuery = $con->prepare("UPDATE table_users SET user_password=:new_pass WHERE user_email=:email");
                $updateQuery->bindValue(":new_pass", $confirm_pass);
                $updateQuery->bindValue(":email", $useremail);

                // if update query executed or not alert user
                if ($updateQuery->execute()) {
                    echo '<script>swal("Password updated Successfuly!", {
                        title:"Success",
                        buttons: false,
                        timer: 2500,
                        icon: "success",
                      });</script>';
                } else {
                    echo '<script>swal("Password not updated!", {
                        title:"Failed!",
                        buttons: false,
                        timer: 2500,
                        icon: "error",
                      });</script>';
                }
            }
        } else {
            echo '<script>swal("New Password and Confirm Password does not match!", {
                buttons: false,
                timer: 3000,
                icon: "error",
              });
              
            document.getElementById("passwordNew").value = "";
            document.getElementById("passwordConfirm").value = "";
            document.getElementById("passwordNew").focus();
              </script>';
        }
    } else {
        // echo '<script>alert("Old Password does not mathc");</script>';
        echo '<script>swal("Old Password is incorrect!", {
            buttons: false,
            timer: 3000,
            icon: "error",
          });
          
          document.getElementById("passwordOld").value = "";
          document.getElementById("passwordOld").focus();
          </script>';
    }
}
