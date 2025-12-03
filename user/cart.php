<?php
session_start();
include "db.php";
$action = isset($_GET['action']) ? $_GET['action'] : null;

// read JSON helper
function read_json()
{
    $raw = file_get_contents('php://input');
    return json_decode($raw, true);
}

/* ---------- ADD / UPDATE ---------- */
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $data = read_json();
    $pid = intval($data['product_id'] ?? 0);
    $qty = max(0, intval($data['quantity'] ?? 0));

    // product
    $p_res = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $pid LIMIT 1");
    if (!$p_res || mysqli_num_rows($p_res) == 0) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit();
    }
    $p = mysqli_fetch_assoc($p_res);

    // discount
    $dres = mysqli_query($conn, "SELECT discount_range FROM discount LIMIT 1");
    $drow = mysqli_fetch_assoc($dres);
    $discount = $drow ? floatval($drow['discount_range']) : 0;

    $orig = floatval($p['cost']);
    $price = $orig;
    if ($discount > 0) $price = round($orig * (1 - $discount / 100), 2);
    $total = $price * $qty;

    $ex = mysqli_query($conn, "SELECT * FROM cart WHERE product_id = $pid LIMIT 1");
    if ($ex && mysqli_num_rows($ex) > 0) {
        if ($qty > 0) {
            mysqli_query($conn, "UPDATE cart SET quantity = $qty, cost = $price, total_cost = $total WHERE product_id = $pid");
        } else {
            mysqli_query($conn, "DELETE FROM cart WHERE product_id = $pid");
        }
    } else {
        if ($qty > 0) {
            $pname = mysqli_real_escape_string($conn, $p['product_name']);
            $img = mysqli_real_escape_string($conn, $p['product_image_path']);
            mysqli_query($conn, "INSERT INTO cart (product_id, product_name, cost, quantity, total_cost, product_image_path)
                                 VALUES ($pid, '$pname', $price, $qty, $total, '$img')");
        }
    }
    echo json_encode(['success' => true]);
    exit();
}

/* ---------- REMOVE ---------- */
if ($action === 'remove' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $data = read_json();
    $pid = intval($data['product_id'] ?? 0);
    mysqli_query($conn, "DELETE FROM cart WHERE product_id = $pid");
    echo json_encode(['success' => true]);
    exit();
}

/* ---------- SUMMARY ---------- */
if ($action === 'summary') {
    header('Content-Type: application/json; charset=utf-8');
    $res = mysqli_query(
        $conn,
        "SELECT
            SUM(p.cost * c.quantity) AS original_total,
            SUM(c.total_cost) AS discounted_total,
            SUM(c.quantity) AS count
         FROM cart c
         INNER JOIN product p ON p.product_id = c.product_id"
    );
    $row = mysqli_fetch_assoc($res);
    $count = intval($row['count'] ?? 0);
    $discounted = floatval($row['discounted_total'] ?? 0);
    $original = floatval($row['original_total'] ?? 0);
    $saved = max(0, $original - $discounted);
    echo json_encode(['count' => $count, 'total' => $discounted, 'saved' => $saved]);
    exit();
}

/* ---------- LIST (HTML fragment for side panel) ---------- */
if ($action === 'list') {
    header('Content-Type: text/html; charset=utf-8');
    $res = mysqli_query($conn, "SELECT * FROM cart ORDER BY order_id ASC");
    $html = '';
    if (!$res || mysqli_num_rows($res) == 0) {
        $html .= '<div class="empty-cart">Your cart is empty.</div>';
    } else {
        while ($r = mysqli_fetch_assoc($res)) {
            $pid = intval($r['product_id']);
            $pname = htmlspecialchars($r['product_name']);
            $cost = number_format(floatval($r['cost']), 2);
            $qty = intval($r['quantity']);
            $total = number_format(floatval($r['total_cost']), 2);
            $img = htmlspecialchars($r['product_image_path']) ?: 'placeholder.png';

            $html .= "
                <div class='cart-row' data-pid='{$pid}'>
                    <img class='cart-item-img' src='{$img}' alt='{$pname}'>
                    <div class='cart-item-info'>
                        <div class='cart-item-name'>{$pname}</div>
                        <div class='cart-item-price'>₹ {$cost}</div>
                        <div class='cart-item-qty'>
                            <button class='qty-minus'>-</button>
                            <input class='qty-input-panel' type='number' min='0' value='{$qty}'>
                            <button class='qty-plus'>+</button>
                        </div>
                        <div class='cart-item-sub'>Subtotal: ₹ <span class='cart-sub-val'>{$total}</span></div>
                        <button class='remove-from-cart'>Remove</button>
                    </div>
                </div>
            ";
        }
    }
    echo $html;
    exit();
}

/* unknown */
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit();
