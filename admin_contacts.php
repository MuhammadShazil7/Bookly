<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit();
}

// DELETE message
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `messages` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title">Customer Messages</h1>

   <div class="box-container">
   <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `messages` ORDER BY id DESC") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){
   ?>
   <div class="box">
      <p> <strong>Name:</strong> <span><?php echo $fetch_message['name']; ?></span> </p>
      <p> <strong>Email:</strong> <span><?php echo $fetch_message['email']; ?></span> </p>
      <p> <strong>Subject:</strong> <span><?php echo $fetch_message['subject']; ?></span> </p>
      <p> <strong>Message:</strong> <span><?php echo $fetch_message['message']; ?></span> </p>
      <p class="date"> <i class="fas fa-clock"></i> <?php echo $fetch_message['created_at']; ?> </p>

      <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" 
         onclick="return confirm('Delete this message?');" 
         class="delete-btn">Delete Message</a>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">No messages found!</p>';
      }
   ?>
   </div>

</section>

<script src="js/admin_script.js"></script>
</body>
</html>
