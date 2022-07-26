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
                            <a href="product.php" class="btn btn-sm bg-indigo float-right" role="button">
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
                                        // try {
                                        $showProductsQuery = $con->prepare(
                                            "SELECT table_products.product_id, table_products.product_name, table_categories.category_name, table_products.product_costPrice, table_products.product_salePrice, table_products.product_stock, table_products.product_description, table_products.product_image
                                            FROM table_products
                                            INNER JOIN table_categories ON table_categories.category_id=table_products.product_categoryId"
                                            // "SELECT * FROM table_products ORDER BY product_id DESC"
                                        );
                                        $showProductsQuery->execute();

                                        function products($product_id, $product_name, $category_name, $product_costPrice, $product_salePrice, $product_stock, $product_description, $product_image)
                                        {
                                            echo "
                                                    <tr>
                                                        <td>{$product_id}</td>
                                                        <td>{$product_name}</td>
                                                        <td>{$category_name}</td>
                                                        <td>{$product_costPrice}</td>
                                                        <td>{$product_salePrice}</td>
                                                        <td>{$product_stock}</td>
                                                        <td>{$product_description}</td>
                                                        <td>
                                                        <img src='../assets/images/products/{$product_image}' class='img-rounded' alt='{$product_name}' width='70' height='70'> 
                                                        </td>
                                                        <td class='pt-4 '>
                                                            <a href='#' class='btn btn-sm btn-info mx-2' data-toggle='tooltip' title='View Product'>
                                                                <i class='far fa-eye'></i> View
                                                            </a>
                                                            <a href='#' class='btn btn-sm btn-primary mx-2' data-toggle='tooltip' data-placement='bottom' title='Edit product'>
                                                                <i class='far fa-edit'></i> Edit
                                                            </a>
                                                            <a href='#' class='btn btn-sm btn-danger mx-2' data-toggle='tooltip' title='Delete product'>
                                                                <i class='far fa-trash-alt'></i> Delete
                                                            </a>
    
    
                                                        </td>
                                                    </tr>";
                                        }

                                        $row = $showProductsQuery->fetchAll(PDO::FETCH_FUNC, "products");
                                        // } catch (Exception $e) {
                                        //     echo $e->getMessage();
                                        // }
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
            ],
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50, 75, 100]
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
