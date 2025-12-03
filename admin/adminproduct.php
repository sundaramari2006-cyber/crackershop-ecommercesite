<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

/* ADD PRODUCT */
if (isset($_POST['add_product'])) {

    $pname = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $cost = (float)$_POST['cost'];
    $stock = mysqli_real_escape_string($conn, $_POST['stock_status']);
    $pcs_details = mysqli_real_escape_string($conn, $_POST['pcs_details']);

    if (!is_dir("uploads")) {
        mkdir("uploads", 0755);
    }

    $image_name = $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];

    $path = "../uploads/" . time() . "_" . basename($image_name);
    move_uploaded_file($tmp_name, $path);

    mysqli_query(
        $conn,
        "INSERT INTO product(product_name, category, product_image_path, cost, stock_status, pcs_details)
         VALUES('$pname', '$category', '$path', '$cost', '$stock', '$pcs_details')"
    );
    header("Location: adminproduct.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM product WHERE product_id=$id");
    header("Location: adminproduct.php");
    exit();
}

/* EDIT MODE */
$edit_mode = false;
$edit_data = null;

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = (int)$_GET['edit'];
    $fetch = mysqli_query($conn, "SELECT * FROM product WHERE product_id=$id");
    $edit_data = mysqli_fetch_assoc($fetch);
}

/* UPDATE */
if (isset($_POST['update_product'])) {

    $id = (int)$_POST['id'];
    $pname = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $cost = (float)$_POST['cost'];
    $stock = mysqli_real_escape_string($conn, $_POST['stock_status']);
    $pcs_details = mysqli_real_escape_string($conn, $_POST['pcs_details']);

    if (!empty($_FILES['product_image']['name'])) {
        if (!is_dir("uploads")) {
            mkdir("uploads", 0755);
        }
        $image_name = $_FILES['product_image']['name'];
        $tmp_name = $_FILES['product_image']['tmp_name'];
        $path = "../uploads" . time() . "_" . basename($image_name);
        move_uploaded_file($tmp_name, $path);
    } else {
        $path = mysqli_real_escape_string($conn, $_POST['old_image']);
    }

    mysqli_query(
        $conn,
        "UPDATE product SET
            product_name='$pname',
            category='$category',
            product_image_path='$path',
            cost='$cost',
            stock_status='$stock',
            pcs_details='$pcs_details'
         WHERE product_id=$id"
    );

    header("Location: adminproduct.php");
    exit();
}

/* FETCH CATEGORY */
$categories = mysqli_query($conn, "SELECT * FROM category");

/* FETCH PRODUCT LIST */
$productList = mysqli_query($conn, "SELECT * FROM product ORDER BY product_id DESC");

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SkyBoom Admin - Products</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/adminpro.css">
    <style>
        /* Style the file upload browse button */
        .sb-file::file-selector-button {
            background-color: #fbff00ff;
            /* Button color */
            color: #050503ff;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s ease;
        }

        /* Hover effect */
        .sb-file::file-selector-button:hover {
            background-color: #fbff00ff;
        }

        /* Full input styling */
        .sb-file {
            padding: 6px;
            border: 1px solid #ffee00ff;
            border-radius: 6px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="sb-product-container">
        <header class="sb-header">
            <h1 class="sb-title">🔥 SkyBoom Cracker Shop – Admin Panel</h1>
        </header>

        <nav class="sb-navbar">
            <a href="admincategory.php" class="sb-nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'admincategory.php') echo 'active'; ?>">Category</a>
            <a href="adminproduct.php" class="sb-nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'adminproduct.php') echo 'active'; ?>">Product</a>
            <a href="admindiscount.php" class="sb-nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'admindiscount.php') echo 'active'; ?>">Discount</a>
            <a href="adminorder.php" class="sb-nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'adminorder.php') echo 'active'; ?>">Orders</a>
            <a href="index.php" class="sb-nav-item ">logout</a>
        </nav>
        <h2 class="sb-product-title"><?= $edit_mode ? "Edit Product" : "Add Product" ?></h2>

        <form method="POST" enctype="multipart/form-data" class="sb-product-form">

            <?php if ($edit_mode) { ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($edit_data['product_id']) ?>">
                <input type="hidden" name="old_image" value="<?= htmlspecialchars($edit_data['product_image_path']) ?>">
            <?php } ?>

            <input type="text" name="product_name" class="sb-input sb-input-product"
                value="<?= $edit_mode ? htmlspecialchars($edit_data['product_name']) : '' ?>"
                placeholder="Product Name" required>

            <select name="category" class="sb-select sb-select-product" required>
                <option value="">Select Category</option>
                <?php
                mysqli_data_seek($categories, 0);
                while ($c = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= htmlspecialchars($c['category_name']) ?>"
                        <?= ($edit_mode && $edit_data['category'] == $c['category_name']) ? "selected" : "" ?>>
                        <?= htmlspecialchars($c['category_name']) ?>
                    </option>
                <?php } ?>
            </select>

            <?php if ($edit_mode) { ?>
                <img src="<?= htmlspecialchars($edit_data['product_image_path']) ?>" class="sb-thumb" alt=""><br><br>
            <?php } ?>

            <input type="file" name="product_image" accept="image/*" class="sb-file" <?= $edit_mode ? "" : "required" ?>>

            <input type="number" name="cost" class="sb-input sb-input-cost"
                value="<?= $edit_mode ? htmlspecialchars($edit_data['cost']) : '' ?>"
                placeholder="Cost" required step="0.01" min="0">

            <select name="stock_status" class="sb-select sb-select-stock" required>
                <option value="Available" <?= ($edit_mode && $edit_data['stock_status'] == "Available") ? "selected" : "" ?>>Available</option>
                <option value="Not Available" <?= ($edit_mode && $edit_data['stock_status'] == "Not Available") ? "selected" : "" ?>>Not Available</option>
            </select>

            <!-- NEW PCS DETAILS FIELD -->
            <input type="text" name="pcs_details" class="sb-input"
                value="<?= $edit_mode ? htmlspecialchars($edit_data['pcs_details']) : '' ?>"
                placeholder="Number of Pieces / Pack Details" required>

            <button type="submit" name="<?= $edit_mode ? 'update_product' : 'add_product' ?>" class="sb-btn sb-btn-product">
                <?= $edit_mode ? "Update Product" : "Add Product" ?>
            </button>

        </form>

        <h2 class="sb-product-title">Product List</h2>

        <table class="sb-table sb-table-product">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Cost</th>
                <th>Stock</th>
                <th>Pcs Details</th>
                <th>Action</th>
            </tr>

            <?php while ($p = mysqli_fetch_assoc($productList)) { ?>
                <tr class="sb-row">
                    <td><img src="<?= htmlspecialchars($p['product_image_path']) ?>" class="sb-prod-img" alt=""></td>
                    <td><?= htmlspecialchars($p['product_name']) ?></td>
                    <td><?= htmlspecialchars($p['category']) ?></td>
                    <td>₹<?= htmlspecialchars($p['cost']) ?></td>
                    <td><?= htmlspecialchars($p['stock_status']) ?></td>
                    <td><?= htmlspecialchars($p['pcs_details']) ?></td>
                    <td>
                        <a href="adminproduct.php?edit=<?= $p['product_id'] ?>" class="sb-link sb-edit">Edit</a>
                        <a href="adminproduct.php?delete=<?= $p['product_id'] ?>" class="sb-link sb-delete" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </div>

</body>

</html>