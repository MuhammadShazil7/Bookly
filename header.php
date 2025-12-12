<?php
// Display messages if any
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . htmlspecialchars($msg) . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">

    <!-- Top Header -->
    <div class="header-1">
        <div class="flex space-between">
            <div class="share">
                <a href="#" class="fab fa-facebook-f" aria-label="Facebook"></a>
                <a href="#" class="fab fa-twitter" aria-label="Twitter"></a>
                <a href="#" class="fab fa-instagram" aria-label="Instagram"></a>
                <a href="#" class="fab fa-linkedin" aria-label="LinkedIn"></a>
            </div>
            <p>
                <?php if(isset($_SESSION['user_name'])): ?>
                    Welcome, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
                <?php else: ?>
                    New? <a href="login.php">Login</a> | <a href="register.php">Register</a>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Main Header -->
    <div class="header-2">
        <div class="flex space-between align-center">

            <!-- Logo -->
            <a href="home.php" class="logo">Bookly.</a>

            <!-- Navbar -->
            <nav class="navbar">
                <a href="home.php">Home</a>
                <a href="about.php">About</a>
                <a href="shop.php">Shop</a>
                <a href="contact.php">Contact</a>
                <a href="orders.php">Orders</a>
            </nav>

            <!-- Icons -->
            <div class="icons">
                <div id="menu-btn" class="fas fa-bars" aria-label="Menu"></div>
                <a href="search_page.php" class="fas fa-search" aria-label="Search"></a>
                <div id="user-btn" class="fas fa-user" aria-label="User"></div>

                <?php
                $cart_rows_number = 0;
                if (isset($conn) && isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query Failed');
                    $cart_rows_number = mysqli_num_rows($select_cart_number);
                }
                ?>
                <a href="cart.php" aria-label="Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span>(<?= $cart_rows_number ?>)</span>
                </a>
            </div>

            <!-- User Box -->
            <div class="user-box" id="user-box">
                <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])): ?>
                    <p>Username: <span><?= htmlspecialchars($_SESSION['user_name']); ?></span></p>
                    <p>Email: <span><?= htmlspecialchars($_SESSION['user_email']); ?></span></p>
                    <a href="logout.php" class="delete-btn">Logout</a>
                <?php else: ?>
                    <p><a href="login.php">Login</a> to access your account</p>
                <?php endif; ?>
            </div>

        </div>
    </div>

</header>

<!-- Toggle Script -->
<script>
    const userBtn = document.getElementById('user-btn');
    const userBox = document.getElementById('user-box');
    if (userBtn && userBox) {
        userBtn.addEventListener('click', () => {
            userBox.classList.toggle('active');
        });
    }
</script>

<!-- Optional CSS -->
<style>
    .user-box {
        display: none;
        position: absolute;
        top: 100%;
        right: 10px;
        background: white;
        padding: 1em;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 8px;
        z-index: 1000;
    }
    .user-box.active {
        display: block;
    }
    .message {
        background: #f9f9f9;
        padding: 10px;
        margin: 5px;
        border-left: 4px solid #007bff;
    }
</style>
