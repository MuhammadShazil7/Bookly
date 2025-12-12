<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('location:login.php');
    exit;
}

$message = [];

// REMOVE ITEM
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $remove_id, $user_id);
    $stmt->execute();
    $message[] = "Product removed from cart!";
}

// UPDATE QUANTITY
if (isset($_POST['update_cart'])) {
    $cart_id = (int)$_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
    $stmt->execute();
    $message[] = "Cart updated!";
}

// GET CART ITEMS
$cart_items = [];
$total = 0;
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart</title>
<link rel="stylesheet" href="css/style.css">

<style>
.cart-container { max-width: 900px; margin: 2rem auto; padding: 20px; }
.cart-title { text-align: center; font-size: 28px; margin-bottom: 25px; font-weight: bold; color: #444; }
.message { background: #27ae60; color: #fff; padding: 10px 15px; margin-bottom: 15px; border-radius: 8px; text-align: center; }
.cart-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
.cart-table th, .cart-table td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
.cart-table th { background-color: #f5f5f5; }
.cart-table img { border-radius: 8px; }
.cart-table input[type="number"] { width: 60px; padding: 5px; text-align: center; }
.cart-table input[type="submit"] { padding: 6px 12px; border: none; border-radius: 6px; background-color: #3498db; color: #fff; cursor: pointer; transition: 0.3s; }
.cart-table input[type="submit"]:hover { background-color: #2980b9; }
.cart-table a { color: #e74c3c; text-decoration: none; font-weight: bold; }
.cart-table a:hover { text-decoration: underline; }
.total-box { text-align: right; font-size: 20px; font-weight: bold; margin-bottom: 20px; }
.checkout-btn { display: inline-block; padding: 12px 25px; background: #3498db; color: #fff; border-radius: 8px; text-decoration: none; transition: 0.3s; }
.checkout-btn:hover { background: #2980b9; }
.empty-cart { text-align:center; font-size:20px; padding:30px; color:#444; }
@media (max-width:768px){
    .cart-table th, .cart-table td { font-size: 14px; padding: 8px; }
    .cart-table input[type="number"] { width: 50px; }
}
</style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="cart-container">
    <h1 class="cart-title">Your Cart</h1>

    <?php if (!empty($message)): ?>
        <?php foreach ($message as $msg): ?>
            <div class="message"><?= htmlspecialchars($msg) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($cart_items)): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><img src="uploaded_img/<?= $item['image'] ?>" width="60" alt=""></td>
                    <td><?= $item['name'] ?></td>
                    <td>$<?= number_format($item['price'],2) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                            <input type="submit" name="update_cart" value="Update">
                        </form>
                    </td>
                    <td>$<?= number_format($item['price'] * $item['quantity'],2) ?></td>
                    <td><a href="?remove=<?= $item['id'] ?>" onclick="return confirm('Remove this item?');">Remove</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="total-box">Total: $<?= number_format($total,2) ?></div>
        <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
    <?php else: ?>
        <div class="empty-cart">Your cart is empty!</div>
    <?php endif; ?>
</div>

</body>
</html>
