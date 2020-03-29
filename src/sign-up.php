<!--
    This is the sign-up page.
  -->
<?php

include('../db_helpers.inc.php');
// require_once '/db_helpers.inc.php';


if(isset($_POST)){
  echo "hello ".$_POST['firstName'];
  echo "<br>your password is:  ".$_POST['password'];
  }



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('header.php'); ?>

    <link rel="stylesheet" href="css/sign-up.css">
    <!-- <script type="text/javascript" src="js/sign-up.js"></script> -->
  </head>
  <body>
    <?php include('nav.php'); ?>
    <div id="signupContent">
    <h1>Sign Up</h1>
    <form  method="POST" action="sign-up.php">
    <ul class="form-list">
    <li>
      <label for="firstName">First Name</label>
      <input type="text" name="firstName" placeholder="First Name" value="" required>
    </li>
      <li>
      <label for="lastName">Last Name</label>
      <input type="text" name="lastName" placeholder="Last Name" value="" required>
    </li>
      <li>
      <label for="city">City</label>
      <input type="text" name="city" placeholder="City" value="" required>
    </li>
      <li>
      <label for="country">Country</label>
      <input type="text" name="country" placeholder="Country" value="" required>
    </li>
    <li>
      <label for="email">E-Mail</label>
      <input type="email" name="email" placeholder="E-Mail" value="" >
    </li>
    <li>
      <label for="password">Password</label>
      <input type="password" name="password" minlength="8" placeholder="Password" value="" >
    </li>
    <li>
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" name="confirmPassword" minlength="8" placeholder="Confirm Password" value="" >
    </li>

      <input type="submit" name="submit" class="submit-btn" value="Submit">
    </ul>
    </form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html
