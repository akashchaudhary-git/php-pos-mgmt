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

                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="product.php">Products</a></li>
                        <li class="breadcrumb-item active">Product List</li>
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
                <div class="col-sm-12 mx-auto">
                    <div class="card card-outline card-warning">
                        <div class="card-header ">
                            <h3 class="card-title">Product List</h3>
                            <a href="product.php" class="btn btn-sm bg-indigo float-sm-right" role="button">
                                <i class="fas fa-external-link-alt">&nbsp;</i>
                                Go back to Products
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post" name="formProductList" enctype="multipart/form-data">
                            <div class="card-body row">
                                <table id="productTable" class="table table-bordered  text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px !important">#</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Cost Price</th>
                                            <th>Sale Price</th>
                                            <th>Stock</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th style="min-width: 250px !important">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        try {
                                            $showProductsQuery = $con->prepare(
                                                "SELECT * FROM table_products ORDER BY product_id DESC"
                                            );
                                            $showProductsQuery->execute();

                                            function products($product_id, $product_name, $product_category, $product_costPrice, $product_salePrice, $product_stock, $product_description, $product_image)
                                            {
                                                echo "
                                                    <tr>
                                                        <td>{$product_id}</td>
                                                        <td>{$product_name}</td>
                                                        <td>{$product_category}</td>
                                                        <td>{$product_costPrice}</td>
                                                        <td>{$product_salePrice}</td>
                                                        <td>{$product_stock}</td>
                                                        <td>{$product_description}</td>
                                                        <td>
                                                        <img src='../assets/images/products/{$product_image}' class='img-rounded' alt='{$product_name}' width='100' height='100'> 
                                                        </td>
                                                        <td>
                                                            <a href='#' class='btn btn-sm btn-info' data-toggle='tooltip' title='View Product'>
                                                            <i class='far fa-eye'>&nbsp;</i>
                                                                View
                                                            </a>
                                                            <a href='#' class='btn btn-sm btn-primary' data-toggle='tooltip' data-placement='bottom' title='Edit product'>
                                                            <i class='far fa-edit'>&nbsp;</i>
                                                                Edit
                                                            </a>
                                                            <a href='#' class='btn btn-sm btn-danger' data-toggle='tooltip' title='Delete product'>
                                                            <i class='far fa-trash-alt'>&nbsp;</i>
                                                                Delete
                                                            </a>
    
    
                                                        </td>
                                                    </tr>";
                                            }

                                            $row = $showProductsQuery->fetchAll(PDO::FETCH_FUNC, "products");
                                        } catch (Exception $e) {
                                            echo $e->getMessage();
                                        }
                                        ?>
                                    </tbody>
                                </table>


                            </div>
                        </form>
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
        $('#productTable').DataTable({

            "order": [
                [0, "desc"]
            ]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<?php

include_once('footer.php');
