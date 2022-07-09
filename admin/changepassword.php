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
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
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

                <div class="col-lg-8">
                    <!-- general form elements -->
                    <div class="card card-outline card-success py-2 px-3">
                        <div class="card-header">
                            <h3 class="card-title">Please enter your details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="emailInput">Email address</label>
                                    <input type="email" class="form-control" id="emailInput" value="<?php echo $_SESSION['user_email']; ?>" readonly disabled>
                                </div>
                                <div class="form-group">
                                    <label for="passwordOld">Old Password</label>
                                    <input type="password" class="form-control" id="passwordOld" name="passwordOld" placeholder="Old Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="passwordNew">New Password</label>
                                    <input type="password" class="form-control" id="passwordNew" name="passwordNew" placeholder="Enter new Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="passwordConfirm">Confirm Password</label>
                                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Confirm Password" required>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
