<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:login.php');
    exit;
}

// Fetch dashboard stats
$pending_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(total_price),0) AS total FROM orders WHERE payment_status='pending'"))['total'];
$completed_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(total_price),0) AS total FROM orders WHERE payment_status='completed'"))['total'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE user_type='user'"))['total'];
$admin_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE user_type='admin'"))['total'];
$total_accounts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$message_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM messages"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Custom Admin CSS -->
<link rel="stylesheet" href="css/admin_style.css">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f4f4;
}

.dashboard {
    padding: 2rem;
}

.dashboard .title {
    font-size: 2rem;
    color: #333;
    margin-bottom: 2rem;
    text-align: center;
}

.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.box {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
    transition: 0.3s ease;
    position: relative;
}

.box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.box i {
    font-size: 2.5rem;
    color: #ffcc00;
    margin-bottom: 0.5rem;
}

.box h3 {
    font-size: 1.8rem;
    margin: 0.5rem 0;
    color: #222;
}

.box p {
    font-size: 1.1rem;
    color: #555;
}
</style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="dashboard">
    <h1 class="title">Admin Dashboard</h1>

    <div class="box-container">

        <div class="box">
            <i class="fas fa-hourglass-half"></i>
            <h3>$<?php echo $pending_total; ?>/-</h3>
            <p>Pending Payments</p>
        </div>

        <div class="box">
            <i class="fas fa-check-circle"></i>
            <h3>$<?php echo $completed_total; ?>/-</h3>
            <p>Completed Payments</p>
        </div>

        <div class="box">
            <i class="fas fa-cart-shopping"></i>
            <h3><?php echo $order_count; ?></h3>
            <p>Orders Placed</p>
        </div>

        <div class="box">
            <i class="fas fa-box-open"></i>
            <h3><?php echo $product_count; ?></h3>
            <p>Products Added</p>
        </div>

        <div class="box">
            <i class="fas fa-user"></i>
            <h3><?php echo $user_count; ?></h3>
            <p>Normal Users</p>
        </div>

        <div class="box">
            <i class="fas fa-user-shield"></i>
            <h3><?php echo $admin_count; ?></h3>
            <p>Admin Users</p>
        </div>

        <div class="box">
            <i class="fas fa-users"></i>
            <h3><?php echo $total_accounts; ?></h3>
            <p>Total Accounts</p>
        </div>

        <div class="box">
            <i class="fas fa-envelope"></i>
            <h3><?php echo $message_count; ?></h3>
            <p>New Messages</p>
        </div>

    </div>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>
