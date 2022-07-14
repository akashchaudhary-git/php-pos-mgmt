<!-- Manage user code -->
<?php
include_once('header.php');
error_reporting(0);

if (isset($_GET)) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    // delete user 
    if ($action == "del" && $id != '') {
        $delUser = $con->prepare("DELETE FROM table_users WHERE user_id=:user_id");
        $delUser->bindParam(":user_id", $id);
        if ($delUser->execute()) {

            echo "
            <script>
            swal({
                title: 'Deleted!',
                text: 'User has been deleted',
                icon: 'success',
                buttons: false,
                timer:3500,
            });
            </script>";
        }
    } elseif ($action == "edit" && $id != '') {
        echo "
        <script>
        swal({
            title: \"Edited!\",
            text: \"Editing user\",
            icon: \"info\",
            buttons: true,
            dangerMode: true,
        })
        .then((logout) => {
            if (logout) {
                window.location = \"manageuser.php\";
            }
        });
        </script>
        ";
    } else {
        // do nothing
    }
}

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
                <!-- User Registration form -->
                <div class="col-sm-6">
                    <div class="card card-red">
                        <div class="card-header">
                            <h3 class="card-title">Registration</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="POST">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="user_name">Name</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter full name" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_email">Email address</label>
                                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter email address" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_password">Password</label>
                                    <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter password" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="user_confirmPass">Confirm Password</label>
                                    <input type="password" class="form-control" id="user_confirmPass" name="user_confirmPass" placeholder="Confirm password" required>
                                </div> -->
                                <div class="form-group">
                                    <label>Select role</label>
                                    <select class="custom-select" name="role_option" required>
                                        <option disabled selected value> -- select an option -- </option>
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option>
                                    </select>

                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <div class="form-group">
                                    <button type="submit" name="add-user" class="form-control btn btn-md btn-dark">Add user</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Display Table -->
                <div class="col-sm-6">
                    <div class="card card-olive">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $showUsersQuery = $con->prepare(
                                        "SELECT user_id, user_name, user_email, user_role FROM table_users ORDER BY user_id DESC"
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
                                                    <td>
                                                        <a href='?action=edit&id={$user_id}' class=' btn-sm btn-outline-info' title='Edit {$user_name}'>
                                                        <i class='fas fa-edit'></i>
                                                        </a>
                                                        <a href='?action=del&id={$user_id}' class=' btn-sm btn-outline-danger' title='Remove {$user_name}'>
                                                        <i class='fas fa-user-minus'></i>
                                                        </a>
                                                    </td>
                                                </tr>";
                                    }


                                    $row = $showUsersQuery->fetchAll(PDO::FETCH_FUNC, "user");
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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




<?php

include_once('footer.php');

if (isset($_POST['add-user'])) {

    $username = ucwords(htmlspecialchars($_POST['user_name']));
    $email = strtolower(htmlspecialchars($_POST['user_email']));
    $password = htmlspecialchars($_POST['user_password']);
    $role = htmlspecialchars($_POST['role_option']);

    $checkEmailQuery = $con->prepare("SELECT * FROM table_users WHERE user_email =:email");
    $checkEmailQuery->bindValue(":email", $email);
    $checkEmailQuery->execute();

    // Check if email already exists then insert query
    if ($checkEmailQuery->rowCount()) {
        echo "<script>swal('{$email} -> already in use, try different email address', {
            title:'Warning ',
            buttons: false,
            icon: 'warning',
            timer:4000,
          });</script>";
    } else {

        $insertQuery = $con->prepare("INSERT INTO table_users(user_name,user_email,user_password,user_role)values(:name,:email,:password,:role)");
        $insertQuery->bindValue(':name', $username);
        $insertQuery->bindValue(':email', $email);
        $insertQuery->bindValue(':password', $password);
        $insertQuery->bindValue(':role', $role);

        if ($insertQuery->execute()) {
            echo "<script>swal('New \"{$role}\", named {$username} created successfuly!', {
                title:'Success - {$role} added',
                buttons: true,
                timer: 4500,
                icon: 'success',
              });
              window.location = \"manageuser.php\";
              </script>";
        } else {
            echo "<script>swal('User creation failed!', {
                title:'Failed!',
                buttons: true,
                timer: 4500,
                icon: 'error',
              });</script>";
        }
    }
}
