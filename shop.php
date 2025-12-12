<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) 
      VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Product added to cart!';
   }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- your existing style -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      /* ---------------------- Improved Minimal Elegant Card Styling ---------------------- */

      .products .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
         gap: 25px;
         padding: 0 20px;
      }

      .products .box {
         background: #fff;
         border-radius: 14px;
         padding: 18px;
         text-align: center;
         border: 1px solid #e5e5e5;
         transition: all .3s ease;
         box-shadow: 0 2px 6px rgba(0,0,0,0.06);
      }

      .products .box:hover {
         transform: translateY(-7px);
         box-shadow: 0 6px 20px rgba(0,0,0,0.12);
      }

      .products .box .image {
         width: 100%;
         height: 250px;
         object-fit: cover;
         border-radius: 12px;
         margin-bottom: 12px;
         transition: .3s ease;
      }

      .products .box:hover .image {
         transform: scale(1.04);
      }

      .products .box .name {
         font-size: 1.15rem;
         font-weight: 600;
         margin: 8px 0;
         color: #333;
      }

      .products .box .price {
         font-size: 1.1rem;
         font-weight: bold;
         color: #503CEB;
         margin-bottom: 12px;
      }

      .products .box .qty {
         width: 60px;
         padding: 8px;
         border-radius: 8px;
         border: 1px solid #ccc;
         text-align: center;
         margin-bottom: 12px;
      }

      /* Add to cart button */
      .products .box .btn {
         display: block;
         width: 100%;
         border-radius: 8px;
         padding: 10px 0;
         background: #503CEB;
         color: #fff;
         cursor: pointer;
         transition: .3s ease;
         border: none;
      }

      .products .box .btn:hover {
         background: #3928b8;
      }

   </style>

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>Our Shop</h3>
   <p> <a href="home.php">Home</a> / Shop </p>
</div>

<section class="products">

   <h1 class="title">Latest Products</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
      
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      
      <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
     </form>

      <?php
         }
      }else{
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
