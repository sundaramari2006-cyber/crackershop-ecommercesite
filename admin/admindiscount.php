<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// FETCH DISCOUNT
$discountQuery = mysqli_query($conn, "SELECT * FROM discount");
$discountCount = mysqli_num_rows($discountQuery);
$discountData = ($discountCount > 0) ? mysqli_fetch_assoc($discountQuery) : null;

// ADD DISCOUNT
if (isset($_POST['add_discount'])) {
    $discount = (int)$_POST['discount_range'];
    mysqli_query($conn, "INSERT INTO discount(discount_range) VALUES('$discount')");
    header("Location: admindiscount.php");
    exit();
}

// DELETE DISCOUNT
if (isset($_GET['delete'])) {
    mysqli_query($conn, "DELETE FROM discount");
    header("Location: admindiscount.php");
    exit();
}

// EDIT MODE
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_mode = true;
}

// UPDATE DISCOUNT
if (isset($_POST['update_discount'])) {
    $discount = (int)$_POST['discount_range'];
    mysqli_query($conn, "UPDATE discount SET discount_range='$discount'");
    header("Location: admindiscount.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SkyBoom Admin - Discount</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/admindiscount.css">
    <link rel="stylesheet" href="./css/nav.css">
</head>

<body class="sb-discount-body">
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

    <div class="sb-discount-container">

        <h2 class="sb-discount-title"><?= $edit_mode ? "Edit Discount" : "Add Discount" ?></h2>

        <form method="POST" class="sb-discount-form">

            <input type="number" min="1" max="99" name="discount_range" class="sb-input sb-input-discount"
                placeholder="Enter Discount %"
                value="<?= $edit_mode ? htmlspecialchars($discountData['discount_range']) : '' ?>"
                required>

            <?php if ($edit_mode) { ?>
                <button type="submit" name="update_discount" class="sb-btn sb-btn-update">Update Discount</button>
            <?php } else { ?>
                <button type="submit" name="add_discount"
                    <?= ($discountCount > 0) ? "disabled" : "" ?>
                    class="sb-btn sb-btn-add <?= ($discountCount > 0) ? 'sb-disabled' : '' ?>">
                    Add Discount
                </button>
            <?php } ?>

        </form>

        <h2 class="sb-discount-title">Discount List</h2>

        <table class="sb-table sb-table-discount">
            <tr>
                <th>Discount %</th>
                <th>Action</th>
            </tr>

            <?php if ($discountCount > 0) { ?>
                <tr class="sb-row">
                    <td><?= htmlspecialchars($discountData['discount_range']) ?>%</td>
                    <td>
                        <a href="admindiscount.php?edit=1" class="sb-link sb-edit">Edit</a>
                        <a href="admindiscount.php?delete=1" class="sb-link sb-delete" onclick="return confirm('Delete discount?')">Delete</a>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="2" class="sb-empty">No discount added</td>
                </tr>
            <?php } ?>

        </table>

    </div>

</body>

</html>