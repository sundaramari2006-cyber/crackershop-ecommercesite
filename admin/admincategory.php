<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$update_mode = false;
$edit_id = "";
$edit_name = "";

// INSERT CATEGORY
if (isset($_POST['add_category'])) {
    $cat = mysqli_real_escape_string($conn, $_POST['category_name']);
    mysqli_query($conn, "INSERT INTO category(category_name) VALUES('$cat')");
    header("Location: admincategory.php");
    exit();
}

// DELETE CATEGORY
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM category WHERE id=$id");
    header("Location: admincategory.php");
    exit();
}

// EDIT MODE - FETCH CURRENT CATEGORY
if (isset($_GET['edit'])) {
    $update_mode = true;
    $edit_id = (int)$_GET['edit'];

    $q = mysqli_query($conn, "SELECT * FROM category WHERE id=$edit_id");
    $row = mysqli_fetch_assoc($q);
    $edit_name = $row['category_name'];
}

// UPDATE CATEGORY
if (isset($_POST['update_category'])) {
    $id = (int)$_POST['edit_id'];
    $cat = mysqli_real_escape_string($conn, $_POST['category_name']);

    mysqli_query($conn, "UPDATE category SET category_name='$cat' WHERE id=$id");
    header("Location: admincategory.php");
    exit();
}

// FETCH ALL CATEGORIES
$categories = mysqli_query($conn, "SELECT * FROM category ORDER BY id DESC");

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SkyBoom Admin - Category</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/admincategory.css">
    <link rel="stylesheet" href="./css/nav.css">
</head>

<body class="sb-home-body">
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
    <div class="sb-home-container">

        <!-- Input Box -->
        <div class="sb-form-box">
            <h2 class="sb-home-title"><?= $update_mode ? "Edit Category" : "Add New Category" ?></h2>

            <form method="POST">
                <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
                <input type="text" name="category_name" class="sb-input"
                    placeholder="Enter Category Name"
                    value="<?= $update_mode ? $edit_name : "" ?>" required>
                <br><br>
                <?php if ($update_mode) { ?>
                    <button type="submit" name="update_category" class="sb-btn">Update</button>
                <?php } else { ?>
                    <button type="submit" name="add_category" class="sb-btn">Add</button>
                <?php } ?>
            </form>
        </div>

        <!-- Table Box -->
        <div class="sb-table-box">
            <center>
                <h2 class="sb-home-title">Category List</h2>
            </center>

            <table class="sb-table">
                <tr>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($categories)) { ?>
                    <tr>
                        <td><?= $row['category_name'] ?></td>
                        <td>
                            <div class="sb-action-buttons">
                                <a href="admincategory.php?edit=<?= $row['id'] ?>" class="sb-edit">Edit</a>
                                <a href="admincategory.php?delete=<?= $row['id'] ?>" class="sb-delete"
                                    onclick="return confirm('Delete this category?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>


</body>

</html>