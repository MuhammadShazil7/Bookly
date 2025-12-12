<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('location:login.php');
    exit;
}

// FETCH ORDERS
$orders = [];
$order_query = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
$order_query->bind_param("i", $user_id);
$order_query->execute();
$result = $order_query->get_result();

while ($row = $result->fetch_assoc()) {
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $row['id']);
    $stmt->execute();
    $items_res = $stmt->get_result();
    $items = [];
    while ($i = $items_res->fetch_assoc()) $items[] = $i;
    $row['items'] = $items;
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Orders</title>
<link rel="stylesheet" href="css/style.css">

<style>
.orders-container { width: 90%; margin: 40px auto; }
.order-card { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 25px; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-left:5px solid #3498db; }
.order-card h3 { margin-bottom: 10px; }
.order-card p, .order-card ul { margin:5px 0; }
.order-card ul { list-style: disc; padding-left: 20px; }
.total-price { font-size: 18px; font-weight:bold; color:#27ae60; margin-top:10px; }
.empty { text-align:center; font-size:20px; padding:30px; color:#444; }
</style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>Your Orders</h3>
   <p><a href="home.php">Home</a> / Orders</p>
</div>

<div class="orders-container">
<?php if(count($orders) > 0): ?>
    <?php foreach($orders as $order): ?>
        <div class="order-card">
            <h3>Order #<?= $order['id'] ?></h3>
            <p><strong>Placed On:</strong> <?= $order['created_at'] ?? "N/A" ?></p>
            <h4>Customer Info</h4>
            <p><strong>Name:</strong> <?= $order['customer_name'] ?></p>
            <p><strong>Email:</strong> <?= $order['customer_email'] ?></p>
            <p><strong>Phone:</strong> <?= $order['customer_number'] ?></p>
            <p><strong>Address:</strong> <?= $order['customer_address'] ?></p>
            <h4>Payment</h4>
            <p><strong>Method:</strong> <?= $order['payment_method'] ?></p>
            <p><strong>Status:</strong> 
               <span style="color:<?= $order['payment_status']=='pending'?'red':'green' ?>"><?= $order['payment_status'] ?></span>
            </p>
            <h4>Items:</h4>
            <ul>
                <?php foreach($order['items'] as $item): ?>
                    <li><?= $item['product_name'] ?> × <?= $item['quantity'] ?> — $<?= number_format($item['price']*$item['quantity'],2) ?></li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total Products:</strong> <?= $order['total_products'] ?></p>
            <p class="total-price"><strong>Total Price:</strong> $<?= $order['total_price'] ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="empty">No orders placed yet!</p>
<?php endif; ?>
</div>

</body>
</html>
