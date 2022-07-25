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
                    <div class="card card-outline card-pink">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title mr-auto">Add Product details</h3>
                            <a href="productlist.php" class="btn btn-sm bg-indigo" role="button">
                                <i class="fas fa-external-link-alt">&nbsp;</i>
                                Go to Product List
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post" name="formProduct" enctype="multipart/form-data">
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
                                            <label for="costPrice">Cost Price (<i class="fas fa-rupee-sign"></i>)</label>
                                            <input type="text" class="form-control" name="costPrice" id="costPrice" placeholder="Purchase price" required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="salePrice">Sale Price (<i class="fas fa-rupee-sign"></i>)</label>
                                            <input type="text" class="form-control" name="salePrice" id="salePrice" placeholder="Selling price" required>
                                        </div>
                                    </div>




                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="productDesc">Description</label>
                                        <textarea class="form-control" rows="4" name="productDesc" id="productDesc" placeholder="Enter product description..." required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile">Product Image</label>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="productImage">Upload image..</label>
                                            <input type="file" class="custom-file-input" id="productImage" name="productImage" required>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="btnAddProduct">
                                    <i class="fas fa-plus">&nbsp;</i>
                                    Add product</button>
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

<script>
    $('#productImage').on('change', function() {
        //get the file name
        var fileName = $(this).val().replace('C:\\fakepath\\', "");
        //replace the "Choose a file" label
        $(this).prev('.custom-file-label').html(fileName);
    });
</script>

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


if (isset($_POST['btnAddProduct'])) {

    $productName = htmlspecialchars(trim($_POST['productName']));
    $productCategory = str_replace(' ', '_', trim(strtolower(htmlspecialchars($_POST['productCategory']))));
    $costPrice = htmlspecialchars(trim($_POST['costPrice']));
    $salePrice = htmlspecialchars(trim($_POST['salePrice']));
    $productStock = htmlspecialchars(trim($_POST['productStock']));
    $productDesc = htmlspecialchars(trim($_POST['productDesc']));


    $checkProductQuery = $con->prepare("SELECT * FROM table_products WHERE product_name =:productName AND product_category=:productCategory");
    $checkProductQuery->bindValue(":productName", $productName);
    $checkProductQuery->bindValue(":productCategory", $productCategory);
    $checkProductQuery->execute();

    if ($checkProductQuery->rowCount()) {
        echo "<script>swal('{$productName} -> product already exist', {
                    title:'Warning ',
                    buttons: false,
                    icon: 'warning',
                    timer:3000,
                });</script>";
    } else {

        $filename = $_FILES['productImage']['name'];
        $file_tmp = $_FILES['productImage']['tmp_name'];

        $file_size = $_FILES['productImage']['size'];
        $file_extension = explode('.', $filename);
        $file_extension = strtolower(end($file_extension));
        $file_newFile = uniqid() . '.' . $file_extension;
        $saveFile = "../assets/images/products/" . $file_newFile;

        if ($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif') {
            if ($file_size >= 1000000) {
                echo "<script>swal('Max file size 1MB(1024KB) allowed!', {
                    title:'Failed!',
                    buttons: false,
                    timer: 2500,
                    icon: 'error',
                });</script>";
            } else {
                if (move_uploaded_file($file_tmp, $saveFile)) {
                    // echo "<script>swal('File uploaded!', {
                    //     title:'Success!',
                    //     buttons: true,
                    //     timer: 3500,
                    //     icon: 'success',
                    // });</script>";
                    $productImage = $file_newFile;
                }
                // $addProductQuery = $con->prepare("INSERT INTO table_products(product_name,product_category,product_costPrice,product_salePrice,product_stock,product_description,product_image)
                // values(:name,:category,:costPrice,:salePrice,:stock,:description,:image)");

                // $addProductQuery->bindValue(":name", $productName);
                // $addProductQuery->bindValue(":category", $productCategory);
                // $addProductQuery->bindValue(":costPrice", $costPrice);
                // $addProductQuery->bindValue(":salePrice", $salePrice);
                // $addProductQuery->bindValue(":stock", $productStock);
                // $addProductQuery->bindValue(":description", $productDesc);
            }
        } else {
            echo "<script type='text/javascript'>swal('Only \".jpg/jpeg\" \".png\" \".gif\" files are supported', {
                title:'Warning!',
                buttons: false,
                timer: 3500,
                icon: 'warning',
            });</script>";
        }


        if (isset($productImage)) {

            $addProductQuery = $con->prepare("INSERT INTO table_products(product_name,product_category,product_costPrice,product_salePrice,product_stock,product_description,product_image) values(:name,:category,:costPrice,:salePrice,:stock,:description,:image)");

            $addProductQuery->bindValue(":name", $productName);
            $addProductQuery->bindValue(":category", $productCategory);
            $addProductQuery->bindValue(":costPrice", $costPrice);
            $addProductQuery->bindValue(":salePrice", $salePrice);
            $addProductQuery->bindValue(":stock", $productStock);
            $addProductQuery->bindValue(":description", $productDesc);
            $addProductQuery->bindValue(":image", $productImage);


            if ($addProductQuery->execute()) {
                echo "<script>
                        swal('New product - {$productName} , created successfuly!', {
                            title:'Success',
                            buttons: false,
                            timer: 3500,
                            icon: 'success',
                        });
                        // setTimeout('window.location =\"category.php\"', 1000);
                        //window.location ='manageuser.php';
                        </script>";
            } else {
                echo "<script>swal('Product creation failed!', {
                            title:'Failed!',
                            buttons: true,
                            timer: 4500,
                            icon: 'error',
                        });</script>";
            }
        } else {
            echo 'productImage not set';
        }
    }
}
