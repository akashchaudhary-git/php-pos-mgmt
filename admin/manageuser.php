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
                    <h1 class="m-0"><small>Manage User</small></h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Manage Users</li>
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
            <div class="row">
                <div class="col">

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Registration</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body row d-flex justify-content-around">
                                <div class=" card p-4 col-md-4">
                                    <div class="form-group">
                                        <label for="user_name">Name</label>
                                        <input type="text" class="form-control" id="user_name" placeholder="Enter full name">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_email">Email address</label>
                                        <input type="email" class="form-control" id="user_email" placeholder="Enter email address">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_password">Password</label>
                                        <input type="password" class="form-control" id="user_password" placeholder="Enter password">
                                    </div>
                                    <div class="form-group">
                                        <label>Select role</label>
                                        <select class="custom-select">
                                            <option disabled selected value> -- select an option -- </option>
                                            <option>Admin</option>
                                            <option>User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Recently added</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px !important">#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $showUsersQuery = $con->prepare(
                                                        "SELECT user_id, user_name, user_email, user_role FROM table_users ORDER BY user_id DESC;"
                                                    );
                                                    $showUsersQuery->execute();

                                                    function user($user_id, $user_name, $user_email, $user_role)
                                                    {
                                                        echo "
                                                        <tr>
                                                        <td>{$user_id}</td>
                                                        <td>{$user_name}</td>
                                                        <td>{$user_email}</td>
                                                        <td>{$user_role}</td>
                                                    </tr>";
                                                    }


                                                    $row = $showUsersQuery->fetchAll(PDO::FETCH_FUNC, "user");
                                                    // echo ($row);

                                                    // echo '<pre>';
                                                    // print_r($row);


                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
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
