<!--
    This is the sign-up page.
  -->
<?php
// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');
    
$page_title = 'Sign-Up';

$signup_attempt = ['fName'   =>'',
                   'lName'   =>'',
                   'city'    =>'',
                   'country' =>'',
                   'email'   =>'',
                   'password'=>'',
                   'statuss' =>'',
];

require_once('db-helpers.inc.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // should probably check to make sure all these values exist.
    $signup_attempt['fName'] = $_POST['firstName'];
    $signup_attempt['lName'] = $_POST['lastName'];
    $signup_attempt['city'] = $_POST['city'];
    $signup_attempt['country'] = $_POST['country'];
    $signup_attempt['email'] = $_POST['email'];
    $signup_attempt['password'] = $_POST['password'];

    // attempt to register the user.
    if (registerUser($signup_attempt['fName'],
                     $signup_attempt['lName'],
                     $signup_attempt['city'],
                     $signup_attempt['country'],
                     $signup_attempt['email'],
                     $signup_attempt['password'])) {
        
        $signup_attempt['status'] = 'success';

        // auto-login the user because they just signed up
        login($signup_attempt['email'], $signup_attempt['password']);

        // redirect to home page
        header("location: index.php");
    } else {
        $signup_attempt['status'] = 'failure';
    }

    // save signup attempt status to the JavaScript so the client can show/hide the messages.
    ?>
    <script type="text/javascript">
      let signup_attempt_status = "<?php echo $signup_attempt['status']; ?>";
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
      let signup_attempt_status;
    </script>
    <?php
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
      <span id="success">Signed up. Redirecting to home page...</span>
      <form method="POST" action="sign-up.php" id="signupForm" name="myForm" onSubmit="return validateForm()">
        <ul class="form-list">
          <li>
            <label for="firstName">First Name</label>
            <input type="text" id="fname" name="firstName" placeholder="First Name" value="<?php echo $signup_attempt['fName']; ?>" required>
          </li>
          <li>
            <label for="lastName">Last Name</label>
            <input type="text" id="lname" name="lastName" placeholder="Last Name" value="<?php echo $signup_attempt['lName']; ?>" required>
          </li>
          <li>
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="City" value="<?php echo $signup_attempt['city']; ?>" required>
          </li>
          <li>
            <label for="country">Country</label>
            <input type="text" id="country" name="country" placeholder="Country" value="<?php echo $signup_attempt['country']; ?>" required>
          </li>
          <li>
            <label for="email">E-Mail</label>
            <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php echo $signup_attempt['email']; ?>" >
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
          <span id="failure">Email already in use</span>
        </ul>
      </form>  
    </div>
    
    <?php include('footer.php'); ?>
  </body>
</html
