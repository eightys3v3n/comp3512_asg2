<!--
    This page lets the user login with an email and password. What happens if they are already logged in?
  -->
<?php
// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');

$page_title ='Login'; 

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('meta.php'); ?>

    <link rel="stylesheet" href="css/login.css">
    <script type="text/javascript" src="js/login.js"></script>
  </head>
  <body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
    
    <div class = "box">
      <form action = "" method = "post">
      <label>Username  </label><input type = "text" name = "username" required /><br /><br />
      <label>Password  </label><input type = "password" name = "password" required /><br/><br />
      <input type = "submit" value = " Submit "/><br />
    </form>
</div>
    <!-- The login page! :D -->
    
    <?php include('footer.php'); ?>
  </body>
</html>
