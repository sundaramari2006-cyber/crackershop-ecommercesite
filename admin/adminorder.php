<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// DELIVER ORDER
if (isset($_GET['deliver'])) {
    $id = (int)$_GET['deliver'];
    mysqli_query($conn, "UPDATE orders SET order_status='Delivered' WHERE order_id=$id");
    echo "<script>alert('Order Delivered Successfully');window.location='adminorder.php';</script>";
    exit();
}

// DELETE ORDER
if (isset($_GET['delete_order'])) {
    $id = (int)$_GET['delete_order'];

    // Fetch the order to get orderpro_id (text list)
    $order = mysqli_query($conn, "SELECT orderpro_id FROM orders WHERE order_id=$id");
    $order_row = mysqli_fetch_assoc($order);

    if ($order_row) {
        // Convert text list "3,5,7" into array [3,5,7]
        $product_ids = explode(",", $order_row['orderpro_id']);

        // Delete each product from orderedpro table
        foreach ($product_ids as $pid) {
            $pid = trim($pid);
            if ($pid !== "") {
                mysqli_query($conn, "DELETE FROM orderedpro WHERE orderedpro_id = '$pid'");
            }
        }
    }

    // Finally delete the order
    mysqli_query($conn, "DELETE FROM orders WHERE order_id=$id");

    echo "<script>alert('Order Deleted Successfully');window.location='adminorder.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SkyBoom Admin - Orders</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/adminorder.css">
    <link rel="stylesheet" href="./css/nav.css">
</head>

<body class="sb-order-body">
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

    <div class="sb-order-container">
        <h1 class="sb-order-main-title">All Orders</h1>

        <?php
        // FETCH ALL ORDERS
        $order_query = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_id DESC");
        if (!$order_query) {
            die("Order SQL Error: " . mysqli_error($conn));
        }

        while ($order = mysqli_fetch_assoc($order_query)) {
        ?>

            <div class="sb-order-box">
                <h2 class="sb-order-id">Order ID: <?php echo $order['order_id']; ?></h2>

                <div class="sb-order-actions">
                    <?php if ($order['order_status'] == "Delivered") { ?>
                        <button class="sb-btn sb-delivered" disabled>Delivered ✔</button>
                    <?php } else { ?>
                        <a href="adminorder.php?deliver=<?= $order['order_id'] ?>"
                            class="sb-link sb-deliver"
                            onclick="return confirm('Mark this order as Delivered?')">
                            Deliver
                        </a>
                    <?php } ?>

                    <a href="adminorder.php?delete_order=<?= $order['order_id'] ?>"
                        class="sb-link sb-delete"
                        onclick="return confirm('Delete this order permanently?')">
                        Delete
                    </a>
                </div>

                <p class="sb-customer"><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                <p class="sb-phone"><strong>Phone:</strong> <?= htmlspecialchars($order['contact_no']) ?></p>
                <p class="sb-address"><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                <p class="sb-total"><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($order['total_amount']); ?></p>

                <div class="sb-section-title">Products in this Order</div>

                <table class="sb-table sb-table-order">
                    <tr>

                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Cost</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>

                    <?php
                    // FETCH ORDERED PRODUCTS FOR THIS ORDER
                    $order_id = (int)$order['order_id'];

                    $pro_query = mysqli_query(
                        $conn,
                        "SELECT * FROM orderedpro WHERE ordercus_id = $order_id"
                    );

                    if (!$pro_query) {
                        die("OrderedPro SQL Error: " . mysqli_error($conn));
                    }

                    while ($pro = mysqli_fetch_assoc($pro_query)) {
                    ?>

                        <tr class="sb-row">
                            <td><?php echo htmlspecialchars($pro['product_name']); ?></td>

                            <td>
                                <img src="<?php echo htmlspecialchars($pro['product_image_path']); ?>" class="zoom-img" alt="product">
                            </td>

                            <td>₹<?php echo htmlspecialchars($pro['cost']); ?></td>
                            <td><?php echo htmlspecialchars($pro['quantity']); ?></td>
                            <td>₹<?php echo htmlspecialchars($pro['total_cost']); ?></td>
                        </tr>

                    <?php } ?>
                </table>
            </div>
            <!-- Image Popup Modal -->
            <div id="imgModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="bigImg">
            </div>

        <?php } ?>

    </div>
    <script>
        var modal = document.getElementById("imgModal");
        var modalImg = document.getElementById("bigImg");
        var images = document.getElementsByClassName("zoom-img");

        for (let i = 0; i < images.length; i++) {
            images[i].onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
            }
        }

        document.querySelector(".close").onclick = function() {
            modal.style.display = "none";
        }
    </script>

</body>

</html>