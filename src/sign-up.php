<!--
    This is the sign-up page.
  -->
<?php
// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');
    
$page_title = 'Sign-Up';

require_once('db-helpers.inc.php');

if(isset($_POST['submit'])) {
    
    $fName = $_POST['firstName'];  // if (isset($_POST['firstName'])) {$fName = $_POST['firstName'];}
    $lName = $_POST['lastName'];   // if (isset($_POST['lastName']))  {$lName = $_POST['lastName'];}
    $city = $_POST['city'];  // if (isset($_POST['city']))      {$city = $_POST['city'];}
    $country = $_POST['country'];  // if (isset($_POST['country']))   {$country = $_POST['country'];}
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    echo "hello ".$_POST['firstName']; 
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include('meta.php'); ?>
    <?php include('header.php'); ?>

    <link rel="stylesheet" href="css/sign-up.css">
    <script type="text/javascript" src="js/sign-up.js"></script>
  </head>
  <body>
    <?php include('nav.php'); ?>
    <div id="signupContent">

    <h1>Sign Up</h1>
    <!-- onSubmit="return validateForm(this);" did not work with preventDefault -->
    <form  method="POST" action="sign-up.php" id="signupForm" name="myForm" onSubmit="return validateForm()">
    <ul class="form-list">
    <li>
      <label for="firstName">First Name</label>
      <input type="text" id="fname" name="firstName" placeholder="First Name" value="<?php echo isset($_POST['firstName']) ? $fName : ''; ?>" required>
    </li>
      <li>
      <label for="lastName">Last Name</label>
      <input type="text" id="lname" name="lastName" placeholder="Last Name" value="<?php echo isset($_POST['lastName']) ? $lName : ''; ?>" required>
    </li>
      <li>
      <label for="city">City</label>
      <input type="text" id="city" name="city" placeholder="City" value="<?php echo isset($_POST['city']) ? $city : ''; ?> " required>
    </li>
      <li>
      <label for="country">Country</label>
      <input type="text" id="country" name="country" placeholder="Country" value="<?php echo isset($_POST['country']) ? $country : ''; ?>" required>
    </li>
    <li>
      <label for="email">E-Mail</label>
      <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" >
    </li>
    <li>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" minlength="8" placeholder="Password" autocomplete="on" value="" >
    </li>
    <li>
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="passwordconfirm" name="confirmPassword" minlength="8" placeholder="Confirm Password" autocomplete="on" value="" >
    </li>

      <input type="submit" name="submit" class="submit-btn" value="Submit">
    </ul>
    </form>

    </div>
    <?php include('footer.php'); ?>
  </body>
</html
