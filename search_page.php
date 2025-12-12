<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('location:login.php');
    exit;
}

$message = [];

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $stmt = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $stmt->bind_param("si", $product_name, $user_id);
   $stmt->execute();
   $check_cart_numbers = $stmt->get_result();
   
   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Already added to cart!';
   }else{
      $stmt_insert = $conn->prepare("INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES(?,?,?,?,?)");
      $stmt_insert->bind_param("isdis", $user_id, $product_name, $product_price, $product_quantity, $product_image);
      $stmt_insert->execute();
      $message[] = 'Product added to cart!';
      $stmt_insert->close();
   }
   $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      /* Improved product cards */
      .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
         gap: 1.5rem;
      }
      .box {
         border: 1px solid #ddd;
         border-radius: 12px;
         padding: 1rem;
         text-align: center;
         box-shadow: 0 4px 12px rgba(0,0,0,0.05);
         transition: transform 0.2s, box-shadow 0.2s;
      }
      .box:hover {
         transform: translateY(-5px);
         box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      }
      .box img.image {
         width: 100%;
         max-height: 200px;
         object-fit: cover;
         border-radius: 8px;
      }
      .box .name {
         font-size: 1.1rem;
         font-weight: 600;
         margin: 0.5rem 0;
      }
      .box .price {
         color: #007bff;
         font-weight: 700;
         margin-bottom: 0.5rem;
      }
      .box .qty {
         width: 60px;
         margin-bottom: 0.5rem;
      }
      .empty {
         text-align: center;
         font-size: 1.2rem;
         color: #555;
         padding: 2rem;
      }
   </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>Search Page</h3>
   <p> <a href="home.php">home</a> / search </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Search products..." class="box" required>
      <input type="submit" name="submit" value="Search" class="btn">
   </form>
</section>

<section class="products" style="padding-top: 0;">

   <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = "%".$_POST['search']."%";
         $stmt = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ?");
         $stmt->bind_param("s", $search_item);
         $stmt->execute();
         $select_products = $stmt->get_result();

         if(mysqli_num_rows($select_products) > 0){
            while($fetch_product = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
      <img src="uploaded_img/<?= $fetch_product['image'] ?>" alt="" class="image">
      <div class="name"><?= $fetch_product['name'] ?></div>
      <div class="price">$<?= $fetch_product['price'] ?>/-</div>
      <input type="number" class="qty" name="product_quantity" min="1" value="1">
      <input type="hidden" name="product_name" value="<?= $fetch_product['name'] ?>">
      <input type="hidden" name="product_price" value="<?= $fetch_product['price'] ?>">
      <input type="hidden" name="product_image" value="<?= $fetch_product['image'] ?>">
      <input type="submit" class="btn" value="Add to Cart" name="add_to_cart">
   </form>
   <?php
            }
         }else{
            echo '<p class="empty">No results found!</p>';
         }
         $stmt->close();
      }else{
         echo '<p class="empty">Search something!</p>';
      }
   ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
