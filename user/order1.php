<?php
session_start();
include "db.php";

// ------------------- FETCH CART ITEMS -------------------
$cart_items = mysqli_query($conn, "SELECT * FROM cart");
$cart_total = 0;
$all_cart_items = [];

while ($r = mysqli_fetch_assoc($cart_items)) {
    $cart_total += floatval($r['total_cost']);
    $all_cart_items[] = $r;
}

$packing_cost = 50;
$final_total = $cart_total + $packing_cost;
$msg = "";

// ------------------- PLACE ORDER -------------------
if (isset($_POST['place_order'])) {
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $addr   = mysqli_real_escape_string($conn, $_POST['address']);
    $mail   = mysqli_real_escape_string($conn, $_POST['mail']);
    $state  = mysqli_real_escape_string($conn, $_POST['state']);

    $insert = mysqli_query($conn, "
        INSERT INTO orders(
            customer_name, contact_no, address, mail_id, state,
            total, packing_cost, total_amount, order_date, orderpro_id
        )
        VALUES(
            '$name', '$mobile', '$addr', '$mail', '$state',
            $cart_total, $packing_cost, $final_total, NOW(), ''
        )
    ");

    if ($insert) {
        $order_id = mysqli_insert_id($conn);
        $orderedpro_ids = [];

        foreach ($all_cart_items as $item) {
            $p_name = mysqli_real_escape_string($conn, $item['product_name']);
            $cost   = $item['cost'];
            $qty    = $item['quantity'];
            $tot    = $item['total_cost'];
            $img    = mysqli_real_escape_string($conn, $item['product_image_path']);

            $q = "
                INSERT INTO orderedpro(
                    ordercus_id, product_name, cost, quantity, total_cost, product_image_path
                )
                VALUES(
                    $order_id, '$p_name', $cost, $qty, $tot, '$img'
                )
            ";
            mysqli_query($conn, $q);
            $orderedpro_ids[] = mysqli_insert_id($conn);
        }

        $orderedpro_id_string = implode(",", $orderedpro_ids);
        mysqli_query($conn, "UPDATE orders SET orderpro_id='$orderedpro_id_string' WHERE order_id=$order_id");

        mysqli_query($conn, "DELETE FROM cart"); // Clear cart after order

        $msg = "🎉 Order placed successfully! <br> Your Order ID is <b>$order_id</b>";
    } else {
        $msg = "❌ Order failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Place Order</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/order1.css">
</head>

<body>
    <header class="order-header">
        <h1 class="app-title">🔥 SkyBoom Cracker Shop</h1>
        <h2 class="page-title">Your Orders</h2>
    </header>

    <div class="order-container">
        <div class="ordertable">
            <h2>Your Items</h2>

            <table class="cart-table">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>

                <?php foreach ($all_cart_items as $r) { ?>
                    <tr>
                        <td><img src="<?= $r['product_image_path'] ?>" width="60"></td>
                        <td><?= $r['product_name'] ?></td>
                        <td>₹<?= number_format($r['cost'], 2) ?></td>
                        <td><?= $r['quantity'] ?></td>
                        <td>₹<?= number_format($r['total_cost'], 2) ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <br>
        <h2>Enter Delivery Details</h2>

        <?php if ($msg != "") { ?>
            <div class="msg"><?= $msg ?></div>
        <?php } ?>

        <form method="POST" class="order-form">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Mobile Number:</label>
            <input type="text" name="mobile" required>

            <label>Address:</label>
            <textarea name="address" required></textarea>

            <label>Email:</label>
            <input type="email" name="mail" required>

            <label>State:</label>
            <input type="text" name="state" required>

            <div class="summary">
                <p>Cart Total: <b>₹<?= number_format($cart_total, 2) ?></b></p>
                <p>Packing Cost: <b>₹<?= number_format($packing_cost, 2) ?></b></p>
                <p>Final Total: <b class="final">₹<?= number_format($final_total, 2) ?></b></p>
            </div>

            <button type="submit" name="place_order" class="btn">Confirm Order</button>
        </form>
        <div class="continue-shopping">
            <a href="userproduct.php" class="btn">⬅ Continue Shopping</a>
        </div>

    </div>

</body>

</html>