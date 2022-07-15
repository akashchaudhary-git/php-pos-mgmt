<?php
include_once('header.php');
error_reporting(0);

if (isset($_GET)) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    // delete user 
    if ($action == "del" && $id != '') {
        $delCategory = $con->prepare("DELETE FROM table_categories WHERE category_id=:category_id");
        $delCategory->bindParam(":category_id", $id);
        if ($delCategory->execute()) {

            echo "
            <script>
            swal({
                title: 'Deleted!',
                text: 'User has been deleted',
                icon: 'success',
                buttons: false,
                timer:1500,
            });
            setTimeout('window.location =\"category.php\"', 1000);
            </script>";
        }
    } elseif ($action == "edit" && $id != '') {


        // Edit category name
        // $editCategoryQuery = $con->prepare("UPDATE INTO table_categories SET category_name=:category_name WHERE category_id=:category_id");
        // $editCategoryQuery->bindValue(":categoty_id", $category_id);
        // $editCategoryQuery->bindValue(":categoty_name", $category_name);

        // if ($editCategoryQuery->execute()) {
        //     echo "
        //     <script>
        //         swal({
        //             title: 'Updated!',
        //             text: '{$category_id} - category updated.',
        //             icon: 'success',
        //             buttons: true,
        //             dangerMode: true,
        //         })
        //         .then((logout) => {
        //             if (logout) {
        //                 window.location = 'category.php';
        //             }
        //         });
        //     </script>
        //     ";
        // } else {
        // }
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
                    <h1 class="m-0"><small>Categories</small></h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                <div class="col">
                    <div class="card card- card-primary">
                        <div class="card-header ">
                            <h3 class="card-title">Enter category details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body row">
                            <div class="col-sm-4 ">
                                <form action="" method="POST">

                                    <div class="form-group">
                                        <label for="category_name">Name</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add-category" class=" btn btn-md btn-danger">
                                            <i class="fas fa-plus"></i>
                                            &nbsp; Add category</button>
                                    </div>

                            </div>
                            <div class="col-sm-6 mx-auto">
                                <table class="table table-bordered table-striped table-white table-hover text-center">
                                    <thead class="bg-olive">
                                        <tr>
                                            <th scope="col" rowspan="2" style="width: 65px !important;">ID</th>
                                            <th scope="col" rowspan="2">Category</th>
                                            <th scope="col" colspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <td colspan="1">Edit</td>
                                            <td colspan="1">Delete</td>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        <?php
                                        $showUsersQuery = $con->prepare(
                                            "SELECT category_id, category_name FROM table_categories ORDER BY category_id DESC"
                                        );
                                        $showUsersQuery->execute();

                                        function category($category_id, $category_name)
                                        {
                                            echo "
                                                <tr>
                                                    <td>{$category_id}</td>
                                                    <td>{$category_name}</td>
                                                    <td>
                                                        <a href='?action=edit&id={$category_id}' class=' btn-sm btn-outline-info' title='Edit {$category_name}'>
                                                        <i class='fas fa-edit'></i>

                                                        </a>

                                                    </td>
                                                    <td>
                                                        <a href='?action=del&id={$category_id}' class=' btn-sm btn-outline-danger' title='Remove {$category_name}'>
                                                        <i class='fas fa-minus-circle'></i>

                                                    </a>
                                                    </td>
                                                </tr>";
                                        }


                                        $row = $showUsersQuery->fetchAll(PDO::FETCH_FUNC, "category");
                                        ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            </form>
                            <!-- Form end -->
                        </div>
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


if (isset($_POST['add-category'])) {

    if (empty(htmlspecialchars($_POST['category_name']))) {
        echo "<script>swal('Field cannot be left blank', {
                title:'Error! ',
                buttons: false,
                icon: 'error',
                timer:3000,
            });</script>";
    } else {

        $category = strtolower(htmlspecialchars($_POST['category_name']));
        $checkCategoryQuery = $con->prepare("SELECT * FROM table_categories WHERE category_name =:category");
        $checkCategoryQuery->bindValue(":category", $category);
        $checkCategoryQuery->execute();

        if ($checkCategoryQuery->rowCount()) {
            echo "<script>swal('{$category} -> category already exist', {
                    title:'Warning ',
                    buttons: false,
                    icon: 'warning',
                    timer:3000,
                });</script>";
        } else {
            $addCategoryQuery = $con->prepare("INSERT INTO table_categories(category_name)values(:category)");
            $addCategoryQuery->bindValue(":category", $category);

            if ($addCategoryQuery->execute()) {
                echo "<script>
                    swal('New category => {$category} , created successfuly!', {
                        title:'Success',
                        buttons: false,
                        timer: 3500,
                        icon: 'success',
                    });
                    setTimeout('window.location =\"category.php\"', 1000);
                    //window.location ='manageuser.php';
                    </script>";
            } else {
                echo "<script>swal('Category creation failed!', {
                        title:'Failed!',
                        buttons: true,
                        timer: 4500,
                        icon: 'error',
                    });</script>";
            }
        }
    }
}
