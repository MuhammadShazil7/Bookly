<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Still forcing login (optional)
if(!$user_id){
    header('location:login.php');
    exit;
}

if(isset($_POST['send'])){

    // Fetch and sanitize
    $name    = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email   = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $subject = trim(mysqli_real_escape_string($conn, $_POST['subject']));
    $msg     = trim(mysqli_real_escape_string($conn, $_POST['message']));

    // Server-side validation (VERY IMPORTANT)
    if(empty($name) || empty($email) || empty($subject) || empty($msg)){
        $message[] = "All fields are required.";
    } else {

        // Check duplicate
        $check = mysqli_query($conn, "
            SELECT id FROM messages 
            WHERE name='$name' 
            AND email='$email' 
            AND subject='$subject'
            AND message='$msg'
            LIMIT 1
        ");

        if(!$check){
            $message[] = "Check query failed: " . mysqli_error($conn);
        }
        elseif(mysqli_num_rows($check) > 0){
            $message[] = "You already sent this message!";
        }
        else {

            // Insert message
            $insert = mysqli_query($conn, "
                INSERT INTO messages(name, email, subject, message)
                VALUES('$name', '$email', '$subject', '$msg')
            ");

            if(!$insert){
                $message[] = "Insert failed: " . mysqli_error($conn);
            } else {
                $message[] = "Message sent successfully!";
            }
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <title>Contact</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>contact us</h3>
   <p> <a href="home.php">home</a> / contact </p>
</div>

<section class="contact">

    <?php
    if(isset($message)){
        foreach($message as $msg){
            echo '<p class="msg">'.$msg.'</p>';
        }
    }
    ?>

   <form action="" method="post">
      <h3>say something!</h3>

      <input type="text" name="name" required placeholder="enter your name" class="box">

      <input type="email" name="email" required placeholder="enter your email" class="box">

      <input type="text" name="subject" required placeholder="enter subject" class="box">

      <textarea name="message" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>

      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
