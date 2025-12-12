<?php
// include 'config.php';
// session_start();
// $user_id = $_SESSION['user_id'];
// if (!isset($user_id)) {
//    header('location:login.php');
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us | BookVerse</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .heading {
         background: #f4f4f4;
         text-align: center;
         padding: 2rem;
         margin-bottom: 2rem;
      }

      .heading h3 {
         font-size: 2.5rem;
         color: #333;
      }

      .heading p a {
         color: #555;
         text-decoration: none;
      }

      .about {
         padding: 3rem 2rem;
         display: flex;
         flex-wrap: wrap;
         gap: 2rem;
         align-items: center;
         justify-content: center;
         background: #fff;
      }

      .about .image img {
         width: 100%;
         max-width: 500px;
         border-radius: 10px;
         box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }

      .about .content {
         flex: 1;
         max-width: 600px;
      }

      .about .content h3 {
         font-size: 2rem;
         color: #222;
         margin-bottom: 1rem;
      }

      .about .content p {
         font-size: 1.1rem;
         color: #555;
         margin-bottom: 1rem;
         line-height: 1.6;
      }

      .about .btn {
         display: inline-block;
         background: #ffcc00;
         color: #000;
         padding: 0.7rem 2rem;
         border-radius: 5px;
         font-weight: bold;
         text-decoration: none;
         transition: 0.3s ease;
      }

      .about .btn:hover {
         background: #e6b800;
      }

      .mission-vision {
         background: #f9f9f9;
         padding: 4rem 2rem;
         text-align: center;
      }

      .mission-vision h2 {
         font-size: 2rem;
         margin-bottom: 1rem;
         color: #333;
      }

      .mission-vision p {
         max-width: 900px;
         margin: 0 auto 2rem;
         color: #555;
         font-size: 1.1rem;
         line-height: 1.6;
      }

      .counters {
         display: flex;
         flex-wrap: wrap;
         justify-content: center;
         gap: 2rem;
         background: #222;
         color: #fff;
         padding: 3rem 1rem;
         text-align: center;
      }

      .counter-box {
         flex: 1 1 200px;
      }

      .counter-box h3 {
         font-size: 3rem;
         color: #ffcc00;
         margin-bottom: 0.5rem;
      }

      .counter-box p {
         font-size: 1.1rem;
      }

      .reviews, .authors {
         padding: 4rem 2rem;
         background: #f4f4f4;
         text-align: center;
      }

      .title {
         font-size: 2.2rem;
         margin-bottom: 2rem;
         color: #333;
      }

      .box-container {
         display: flex;
         flex-wrap: wrap;
         gap: 2rem;
         justify-content: center;
      }

      .box {
         background: #fff;
         padding: 2rem;
         border-radius: 10px;
         box-shadow: 0 2px 10px rgba(0,0,0,0.1);
         max-width: 300px;
      }

      .box img {
         width: 70px;
         height: 70px;
         border-radius: 50%;
         margin-bottom: 1rem;
      }

      .stars i {
         color: #ffcc00;
         margin-right: 2px;
      }

      .authors .box img {
         width: 100%;
         height: 280px;
         object-fit: cover;
         border-radius: 10px;
      }

      .authors .share a {
         margin: 0 5px;
         color: #555;
         font-size: 1.2rem;
         transition: 0.3s;
      }

      .authors .share a:hover {
         color: #ffcc00;
      }
   </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>About Us</h3>
   <p><a href="home.php">Home</a> / About</p>
</div>

<section class="about">
   <div class="image">
      <img src="images/about-img.jpg" alt="About BookVerse">
   </div>
   <div class="content">
      <h3>Why Choose BookVerse?</h3>
      <p>BookVerse isn’t just a bookstore — it’s a world crafted for readers. Whether you're seeking your next adventure, inspiration, or knowledge, we connect you with the perfect book. Every page matters to us, and every reader is family.</p>
      <p>With handpicked titles, fast shipping, and personal support, we make discovering great reads easier and more enjoyable than ever.</p>
      <a href="contact.php" class="btn">Contact Us</a>
   </div>
</section>

<section class="mission-vision">
   <h2>Our Mission</h2>
   <p>To build a global community of readers by delivering powerful stories and insightful knowledge — one book at a time.</p>
   <h2>Our Vision</h2>
   <p>To become the world’s most loved bookstore — where discovery, diversity, and passion for reading thrive.</p>
</section>

<section class="counters">
   <div class="counter-box">
      <h3>10K+</h3>
      <p>Books Sold</p>
   </div>
   <div class="counter-box">
      <h3>4.9★</h3>
      <p>Average Rating</p>
   </div>
   <div class="counter-box">
      <h3>5K+</h3>
      <p>Happy Readers</p>
   </div>
   <div class="counter-box">
      <h3>300+</h3>
      <p>Authors Featured</p>
   </div>
</section>

<section class="reviews">
   <h1 class="title">Client Reviews</h1>
   <div class="box-container">
      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>BookVerse is my go-to bookstore! Found rare books I couldn’t find elsewhere.</p>
         <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
         <h3>Emily Carter</h3>
      </div>
      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>Amazing service! Books arrived in perfect condition and eco-friendly packaging.</p>
         <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
         <h3>Michael Thompson</h3>
      </div>
      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>BookVerse made discovering new authors a joy. Highly recommended!</p>
         <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
         <h3>Sophia Nguyen</h3>
      </div>
   </div>
</section>

<section class="authors">
   <h1 class="title">Featured Authors</h1>
   <div class="box-container">
      <div class="box">
         <img src="images/author-1.jpg" alt="">
         <div class="share"><a href="#" class="fab fa-facebook-f"></a><a href="#" class="fab fa-twitter"></a><a href="#" class="fab fa-instagram"></a></div>
         <h3>Margaret Atwood</h3>
      </div>
      <div class="box">
         <img src="images/author-2.jpg" alt="">
         <div class="share"><a href="#" class="fab fa-facebook-f"></a><a href="#" class="fab fa-twitter"></a><a href="#" class="fab fa-instagram"></a></div>
         <h3>Neil Gaiman</h3>
      </div>
      <div class="box">
         <img src="images/author-3.jpg" alt="">
         <div class="share"><a href="#" class="fab fa-facebook-f"></a><a href="#" class="fab fa-twitter"></a><a href="#" class="fab fa-instagram"></a></div>
         <h3>Chimamanda Adichie</h3>
      </div>
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- Custom JS -->
<script src="js/script.js"></script>

</body>
</html>
