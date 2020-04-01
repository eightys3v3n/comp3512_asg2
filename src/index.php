<!--
    This is the home page. For non-logged in users it has a search box,
    login button, and logout button.
    For logged in users it has a bunch of stuff. See TODO.md
  -->
<?php
session_start();

// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');

$page_title ='Home - Movies';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include('meta.php'); ?>
    <?php include('header.php'); ?>

    <link rel="stylesheet" href="css/index.css">
    <script type="text/javascript" src="js/index.js"></script>
  </head>
  <body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>

    <?php
       if (isset($_SESSION['u_id'])) {
           ?>You are logged in :D<?php
       } else {
           ?>You are not logged in :(<?php
       }
    ?>
    
    <?php include('footer.php'); ?>
  </body>
</html>
