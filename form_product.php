<?php
// Start the session
session_start();
require_once 'models/ProductModel.php';
$productModel = new ProductModel();

$name = NULL; //Add new user
$quantity = NULL;
$price = NULL;
$price_sale = NULL;

if (!empty($_GET['id'])) {
    $_id = $_GET['id'];
    $product = $productModel->findProductById($_id);//Update existing user
}


if (!empty($_POST['submit'])) {

    if (!empty($_id)) {
        $productModel->updateProduct($_POST);
    } else {
        $productModel->insertProduct($_POST);
    }
    header('location: list_users.php');
}

// if (!empty($_POST['submit'])) {
//     if (!empty($_id)) {
//         // Sửa sản phẩm
//         $result = $productModel->updateProduct($_POST);
//         if ($result) {
//             // Sửa thành công, chuyển hướng đến trang list_users.php
//             header('location: list_users.php');
//             exit(); // Chắc chắn dừng tất cả các xử lý khác và chuyển hướng ngay lập tức
//         } else {
//             // Có lỗi khi sửa, ở lại trang form_product.php và hiển thị thông báo lỗi
//             echo '<script type="text/javascript">alert("Có lỗi khi sửa sản phẩm. Vui lòng thử lại.");</script>';
//         }
//     } else {
//         // Thêm sản phẩm mới
//         $result = $productModel->insertProduct($_POST);
//         if ($result) {
//             // Thêm thành công, chuyển hướng đến trang list_users.php
//             header('location: list_users.php');
//             exit(); // Chắc chắn dừng tất cả các xử lý khác và chuyển hướng ngay lập tức
//         } else {
//             // Có lỗi khi thêm, ở lại trang form_product.php và hiển thị thông báo lỗi
//             echo '<script type="text/javascript">alert("Có lỗi khi thêm sản phẩm mới. Vui lòng thử lại.");</script>';
//         }
//     }
// }

?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">

            <?php if ($product || !isset($_id)) { ?>
                <div class="alert alert-warning" role="alert">
                    Product form
                </div>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php if (!empty($product[0]['id'])) echo $product[0]['id'] ?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" name="name" placeholder="Name" value='<?php if (!empty($product[0]['name'])) echo $product[0]['name'] ?>'>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity" value='<?php if (!empty($product[0]['quantity'])) echo $product[0]['quantity'] ?>'>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" value='<?php if (!empty($product[0]['price'])) echo $product[0]['price'] ?>'>
                    </div>

                    <div class="form-group">
                        <label for="price">Price Sale</label>
                        <input type="number" name="price_sale" class="form-control" placeholder="Price Sale" value='<?php if (!empty($product[0]['price_sale'])) echo $product[0]['price_sale'] ?>'>
                    </div>

                    <input style="display: none;" type="text" name="updated_at" class="form-control"value='<?php if (!empty($product[0]['updated_at'])) echo $product[0]['updated_at'] ?>'>

                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">
                    User not found!
                </div>
            <?php } ?>
    </div>
</body>
</html>