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
                    <h1 class="m-0"><small>Product's Dashboard</small></h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Product Page</li>
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
                <div class="col-sm-10 mx-auto">
                    <div class="card card-outline card-success">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mr-auto">Add Product details</h3>
                            <a href="#" class="btn btn-info" role="button">
                                Go to Product List
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post" name="formProduct">
                            <div class="card-body row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="productName">Product Name</label>
                                        <input type="text" class="form-control" name="productName" id="productName" placeholder="Enter product name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="productCategory">Category</label>
                                        <select class="custom-select" name="productCategory" id="productCategory" required>
                                            <option value="" selected disabled>Select category</option>
                                            <?php
                                            showCategoryOption($con);
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="productStock">Stock</label>
                                        <input type="number" min="1" step="1" class="form-control" name="productStock" id="productStock" required>
                                    </div>
                                    <div class="form-group-container row">

                                        <div class="form-group col-6">
                                            <!-- <label for="purchasePrice">Product price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                                </div>
                                                <input type="number" class="form-control" name="purchasePrice" id="purchasePrice" placeholder="Enter amount">
                                            </div> -->
                                            <label for="purchasePrice">Purchase Price</label>
                                            <input type="number" class="form-control" name="purchasePrice" id="purchasePrice" placeholder="Purchased price" required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="salePrice">Sale Price</label>
                                            <input type="number" class="form-control" name="salePrice" id="salePrice" placeholder="Selling price" required>
                                        </div>
                                    </div>




                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="productDesc">Description</label>
                                        <textarea class="form-control" rows="4" name="productDesc" id="productDesc" placeholder="Enter product description..." required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Image</label>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="productImage">Upload image..</label>
                                            <input type="file" class="custom-file-input" id="productImage" name="productImage" required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="btnAddProduct">Add product</button>
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



<?php

include_once('footer.php');

function showCategoryOption($con)
{
    $showCategoryQuery = $con->prepare(
        "SELECT category_name FROM table_categories ORDER BY category_id DESC"
    );
    $showCategoryQuery->execute();

    function category($category_name)
    {
        echo "
            <option name='{$category_name}'>" . ucwords(str_replace("_", " ", $category_name)) . " </option>
            ";
    }

    return $row = $showCategoryQuery->fetchAll(PDO::FETCH_FUNC, "category");
}
