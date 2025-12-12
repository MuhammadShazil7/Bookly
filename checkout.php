<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('location:login.php');
    exit;
}

$message = [];

// GET CART ITEMS
$cart_items = [];
$total = 0;
$total_products = 0;

$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
    $total_products += $row['quantity'];
}
$stmt->close();

// PLACE ORDER
if (isset($_POST['place_order']) && !empty($cart_items)) {

    $customer_name = $_POST['name'] ?? '';
    $customer_email = $_POST['email'] ?? '';
    $customer_number = $_POST['number'] ?? '';
    $customer_address = $_POST['address'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $payment_status = "pending";

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders(user_id, customer_name, customer_email, customer_number, customer_address, total_price, total_products, payment_method, payment_status) VALUES(?,?,?,?,?,?,?,?,?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isssdisis", $user_id, $customer_name, $customer_email, $customer_number, $customer_address, $total, $total_products, $payment_method, $payment_status);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert order items
    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items(order_id, product_name, price, quantity) VALUES(?,?,?,?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("isdi", $order_id, $item['name'], $item['price'], $item['quantity']);
        $stmt->execute();
        $stmt->close();
    }

    // Clear cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    $message[] = "Order placed successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link rel="stylesheet" href="css/style.css">

<style>
.checkout-container { max-width: 700px; margin: 2rem auto; padding: 20px; }
.checkout-container h1 { text-align: center; margin-bottom: 25px; font-size: 28px; font-weight: bold; color: #444; }
.message { background: #27ae60; color: #fff; padding: 10px 15px; margin-bottom: 15px; border-radius: 8px; text-align: center; }
.checkout-form { display: flex; flex-direction: column; gap: 15px; margin-top: 20px; }
.checkout-form input, .checkout-form select { padding: 10px; border-radius: 6px; border: 1px solid #ccc; width: 100%; }
.checkout-form input[type="submit"] { background: #3498db; color: #fff; border: none; cursor: pointer; transition: 0.3s; }
.checkout-form input[type="submit"]:hover { background: #2980b9; }
.order-summary { background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
.order-summary h3 { margin-bottom: 10px; }
.order-summary ul { list-style: none; padding-left: 0; }
.order-summary li { padding: 5px 0; border-bottom: 1px solid #ddd; }
.total-box { text-align: right; font-weight: bold; margin-top: 10px; font-size: 18px; }
.empty-cart { text-align:center; font-size:20px; padding:30px; color:#444; }
@media(max-width:768px){ .checkout-container{ padding:15px; } }
</style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="checkout-container">
    <h1>Checkout</h1>

    <?php if(!empty($message)): ?>
        <?php foreach($message as $msg): ?>
            <div class="message"><?= htmlspecialchars($msg) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if(!empty($cart_items)): ?>
        <div class="order-summary">
            <h3>Order Summary</h3>
            <ul>
                <?php foreach($cart_items as $item): ?>
                    <li><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?> = $<?= number_format($item['price'] * $item['quantity'],2) ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="total-box">Total: $<?= number_format($total,2) ?></div>
        </div>

        <form method="post" class="checkout-form">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="number" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Address" required>
            <select name="payment_method" required>
                <option value="">Select Payment Method</option>
                <option value="COD">Cash on Delivery</option>
                <option value="JazzCash">JazzCash</option>
            </select>
            <input type="submit" name="place_order" value="Place Order">
        </form>

    <?php else: ?>
        <div class="empty-cart">Your cart is empty!</div>
    <?php endif; ?>
</div>

</body>
</html>
