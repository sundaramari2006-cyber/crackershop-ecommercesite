<?php
include "db.php";

$orders = [];
$order_products_map = [];
$error = "";
$success = [];

/* ---------- UPDATE ORDER ---------- */
if (isset($_POST['update_order'])) {
    $id = $_POST['order_id'];
    $name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mail = mysqli_real_escape_string($conn, $_POST['mail_id']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $status = mysqli_real_escape_string($conn, $_POST['order_status']);

    $sql = "
        UPDATE orders SET 
        customer_name='$name',
        contact_no='$mobile',
        address='$address',
        mail_id='$mail',
        state='$state',
        order_status='$status'
        WHERE order_id=$id
    ";

    if (mysqli_query($conn, $sql)) {
        header("Location: uservieworder.php?mobile=$mobile&view=1&updated=1");
        exit();
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
}

/* ---------- DELETE ORDER ---------- */
if (isset($_GET['delete'])) {
    $del_id = $_GET['delete'];
    $mobile = $_GET['mobile'];

    mysqli_query($conn, "DELETE FROM orders WHERE order_id=$del_id");

    header("Location: uservieworder.php?mobile=$mobile&view=1&deleted=1");
    exit();
}


/* ---------- LOAD ORDERS ONLY WHEN CLICKED VIEW BUTTON ---------- */
if (isset($_GET['view']) && isset($_GET['mobile'])) {

    $mobile = mysqli_real_escape_string($conn, $_GET['mobile']);

    $q = mysqli_query($conn, "SELECT * FROM orders WHERE contact_no='$mobile' ORDER BY order_id DESC");

    while ($row = mysqli_fetch_assoc($q)) {
        $orders[] = $row;

        /** Load order products automatically */
        $ids_raw = $row['orderpro_id'];
        $ids_array = array_filter(array_map('trim', explode(",", $ids_raw)));

        if (!empty($ids_array)) {
            $idlist = implode(",", array_map('intval', $ids_array));
            $pp = mysqli_query($conn, "SELECT * FROM orderedpro WHERE orderedpro_id IN ($idlist)");

            while ($p = mysqli_fetch_assoc($pp)) {
                $order_products_map[$row['order_id']][] = $p;
            }
        }
    }

    if (empty($orders)) {
        $error = "No orders found for this mobile number.";
    }
}


/* ---------- SUCCESS MESSAGES ---------- */
if (isset($_GET['updated'])) $success[] = "Order updated successfully!";
if (isset($_GET['deleted'])) $success[] = "Order deleted successfully!";
?>
<?php
$current_page = basename($_SERVER['PHP_SELF']); // gets current file name like 'uservieworder.php'
?>

<!DOCTYPE html>
<html>

<head>
    <title>SkyBoom - My Orders</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/uservieworder.css">
    <style>
        .view-prod-btn {
            background: #ffd900;
            color: #0a0202;
        }

        .view-prod-btn:hover {
            background: #fffb00;
        }
    </style>
</head>

<body>
    <header class="top-header">
        <div class="site-title">🔥 SkyBoom Cracker Shop</div>

        <div class="top-header-right">
            <!-- Navigation Buttons -->
            <nav class="main-nav">
                <a href="userproduct.php" class="nav-btn <?= $current_page == 'userproduct1.php' ? 'active' : '' ?>">Products</a>
                <a href="usertips.php" class="nav-btn <?= $current_page == 'usertips.php' ? 'active' : '' ?>">Safety Tips</a>
                <a href="uservieworder.php" class="nav-btn <?= $current_page == 'uservieworder.php' ? 'active' : '' ?>">My Orders</a>
                <a href="userabout.php" class="nav-btn <?= $current_page == 'userabout.php' ? 'active' : '' ?>">About Us</a>
            </nav>
        </div>
    </header>
    <div class="order-container">
        <h2>Check Your Orders</h2>

        <form method="GET">
            <input type="text" name="mobile" placeholder="Enter Mobile Number"
       value="<?= isset($_GET['mobile']) ? $_GET['mobile'] : '' ?>"
       maxlength="10" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g,'')"
       required>


            <button type="submit" name="view" value="1" class="view-prod-btn">
                View Orders
            </button>
        </form>

        <?php foreach ($success as $s) echo "<div class='msg'>$s</div>"; ?>
        <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    </div>


    <?php if (!empty($orders)) { ?>

        <h2 style="text-align:center; color:#f7d94c;">Your Orders</h2>

        <?php foreach ($orders as $order) { ?>

            <div class="order-box">

                <?php if (isset($_GET['edit']) && $_GET['edit'] == $order['order_id']) { ?>

                    <!-- EDIT FORM -->
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

                        <label>Name:</label>
                        <input type="text" name="customer_name" value="<?= $order['customer_name'] ?>" required>

                        <label>Mobile:</label>
                        <input type="text" name="contact_no" value="<?= $order['contact_no'] ?>" required>

                        <label>Address:</label>
                        <textarea name="address" required><?= $order['address'] ?></textarea>

                        <label>Email:</label>
                        <input type="email" name="mail_id" value="<?= $order['mail_id'] ?>" required>

                        <label>State:</label>
                        <input type="text" name="state" value="<?= $order['state'] ?>" required>

                        <label>Status:</label>
                        <select name="order_status">
                            <option <?= $order['order_status'] == "Pending" ? "selected" : "" ?>>Pending</option>
                            <option <?= $order['order_status'] == "Processing" ? "selected" : "" ?>>Processing</option>
                            <option <?= $order['order_status'] == "Shipped" ? "selected" : "" ?>>Shipped</option>
                            <option <?= $order['order_status'] == "Delivered" ? "selected" : "" ?>>Delivered</option>
                        </select>

                        <button type="submit" name="update_order" class="update-btn">Update</button>
                        <a class="cancel-btn" href="uservieworder.php?mobile=<?= $order['contact_no'] ?>&view=1">Cancel</a>
                    </form>

                <?php } else { ?>

                    <!-- ORDER DETAILS TABLE -->
                    <table>
                        <tr>
                            <th>Order ID</th>
                            <td><?= $order['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?= $order['customer_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td><?= $order['contact_no'] ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?= $order['address'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $order['mail_id'] ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?= $order['state'] ?></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>₹<?= $order['total'] ?></td>
                        </tr>
                        <tr>
                            <th>Packing Cost</th>
                            <td>₹<?= $order['packing_cost'] ?></td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td>₹<?= $order['total_amount'] ?></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><?= $order['order_date'] ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?= $order['order_status'] ?></td>
                        </tr>
                    </table>

                    <!-- ACTION BUTTONS -->
                    <div class="action-button">
                        <?php if ($order['order_status'] != "Delivered") { ?>
                            <a class="edit-btn"
                                href="uservieworder.php?edit=<?= $order['order_id'] ?>&mobile=<?= $order['contact_no'] ?>&view=1">
                                Edit
                            </a>

                            <a class="delete-btn"
                                href="uservieworder.php?delete=<?= $order['order_id'] ?>&mobile=<?= $order['contact_no'] ?>&view=1"
                                onclick="return confirm('Delete this order?')">
                                Cancel
                            </a>
                        <?php } ?>
                    </div>

                    <!-- PRODUCT LIST -->
                    <?php if (isset($order_products_map[$order['order_id']])) { ?>
                        <h2>Ordered Product</h2>
                        <table style="margin-top:15px;">
                            <tr>
                                <th>Product Name</th>
                                <th>Cost</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>

                            <?php foreach ($order_products_map[$order['order_id']] as $p) { ?>
                                <tr>
                                    <td><?= $p['product_name'] ?></td>
                                    <td>₹<?= $p['cost'] ?></td>
                                    <td><?= $p['quantity'] ?></td>
                                    <td>₹<?= $p['total_cost'] ?></td>
                                </tr>
                            <?php } ?>

                        </table>
                    <?php } ?>

                <?php } ?>

            </div>

    <?php }
    } ?>

</body>

</html>