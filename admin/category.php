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
    }
    // elseif ($action == "edit" && $id != '') {








    //     // Edit category name
    //     // $editCategoryQuery = $con->prepare("UPDATE INTO table_categories SET category_name=:category_name WHERE category_id=:category_id");
    //     // $editCategoryQuery->bindValue(":categoty_id", $category_id);
    //     // $editCategoryQuery->bindValue(":categoty_name", $category_name);

    //     // if ($editCategoryQuery->execute()) {
    //     //     echo "
    //     //     <script>
    //     //         swal({
    //     //             title: 'Updated!',
    //     //             text: '{$category_id} - category updated.',
    //     //             icon: 'success',
    //     //             buttons: true,
    //     //             dangerMode: true,
    //     //         })
    //     //         .then((logout) => {
    //     //             if (logout) {
    //     //                 window.location = 'category.php';
    //     //             }
    //     //         });
    //     //     </script>
    //     //     ";
    //     // } else {
    //     // }
    // } 

    else {
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
                    <div class="card card-outline card-info">
                        <div class="card-header ">
                            <h3 class="card-title">Enter category details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body row">
                            <div class="col-sm-4 ">
                                <?php
                                if (isset($_POST['editBtn'])) {
                                    $editID = htmlspecialchars($_POST['editBtn']);
                                    $query = $con->prepare("SELECT * FROM table_categories WHERE category_id=$editID");
                                    $query->execute();

                                    if ($query->rowCount() == 1) {
                                        $row = $query->fetch(PDO::FETCH_OBJ);
                                        echo '
                                                <div class="card card-warning">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Edit category ID# ' . $editID . '</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="" method="post">
                                                            <div class="form-container row">
                                                                <div class="form-group">
                                                                    <input type="text" readonly  class="form-control-plaintext" name="catID" value="' . $editID . '" hidden >
                                                                </div>
                                                                <div class="form-group col-sm-8">
                                                                    <input name="editedCatName" type="text" value="' . $row->category_name . '" class="form-control" placeholder="Category new name">
                                                                </div> 
                                                                <div class="form-group col-sm-4">
                                                                    <button name="submitEdit" class="form-control btn btn-info" type="submit">Edit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                ';
                                    } else {
                                        echo '
                                    <form action="" method="POST">
                                    <div id="addCategoryForm">
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
                                </form>
                                <!-- Form end -->
                                    
                                    ';
                                    }
                                } else {
                                    echo '
                                    <form action="" method="POST">
                                    <div id="addCategoryForm">
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
                                </form>
                                <!-- Form end -->
                                    
                                    ';
                                }

                                ?>



                            </div>
                            <div class="col-sm-6 mx-auto">
                                <form action="" method="post">
                                    <table id="categoryTable" class="table table-bordered table-striped table-white table-hover text-center">
                                        <thead class="bg-olive">
                                            <tr>
                                                <th style="width: 100px !important;">ID</th>
                                                <th>Category</th>
                                                <th style="min-width: 114px !important;width: 25%;">Action</th>
                                            </tr>


                                        </thead>
                                        <tbody>

                                            <?php
                                            $showCategoryQuery = $con->prepare(
                                                "SELECT category_id, category_name FROM table_categories ORDER BY category_id DESC"
                                            );
                                            $showCategoryQuery->execute();

                                            function category($category_id, $category_name)
                                            {
                                                echo "
                                                <tr>
                                                    <td>{$category_id}</td>
                                                    <td>{$category_name}</td>
                                                    <td>
                                                        <button type='submit' name='editBtn' value='{$category_id}'  class='btn btn-sm btn-info mx-1' data-toggle='tooltip' data-placement='left' title='Edit {$category_name}'>
                                                            <i class='fas fa-edit'></i>
                                                        </button>

                                                        <a href='?action=del&id={$category_id}' class='btn btn-sm btn-danger mx-1' data-toggle='tooltip' data-placement='right' title='Remove {$category_name}'>
                                                            <i class='fas fa-trash-alt'></i>
                                                        </a>

                                                    </td>
                                                    
                                                </tr>";
                                            }


                                            $row = $showCategoryQuery->fetchAll(PDO::FETCH_FUNC, "category");
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">

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

<!-- Assign DataTable plugin to a table -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 75, 100]
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

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

        $category = str_replace(' ', '_', trim(strtolower(htmlspecialchars($_POST['category_name']))));

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

if (isset($_POST['submitEdit'])) {

    $catId = htmlspecialchars($_POST['catID']);
    $catChangedName =  str_replace(' ', '_', trim(strtolower(htmlspecialchars($_POST['editedCatName']))));

    $checkCategoryQuery = $con->prepare("SELECT * FROM table_categories WHERE category_name =:categoryName");
    $checkCategoryQuery->bindValue(":categoryName", $catChangedName);
    $checkCategoryQuery->execute();

    if ($checkCategoryQuery->rowCount()) {
        echo "<script>swal('{$catChangedName} -> category already exist', {
                    title:'Warning ',
                    buttons: false,
                    icon: 'warning',
                    timer:3000,
                });</script>";
    } else {
        // UPDATE table_users SET user_password=:new_pass WHERE user_email=:email
        $updateCategoryQuery = $con->prepare("UPDATE table_categories SET category_name=:categoryName WHERE category_id=:categoryId");
        $updateCategoryQuery->bindValue(":categoryName", $catChangedName);
        $updateCategoryQuery->bindValue(":categoryId", $catId);

        if ($updateCategoryQuery->execute()) {
            echo '<script>swal("Category updated Successfuly!", {
                title:"Success",
                buttons: false,
                timer: 2500,
                icon: "success",
              });
              setTimeout("window.location =\'category.php\'", 1000);
              </script>';
        } else {
            echo '<script>swal("Category not updated!", {
                title:"Failed!",
                buttons: false,
                timer: 2500,
                icon: "error",
              });</script>';
        }
    }
}
