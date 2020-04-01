<!--
    This page lets the user login with an email and password. What happens if they are already logged in?
  -->
<?php
session_start();
        
// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');

include 'db-helpers.inc.php';

$page_title ='Login';

// used only if this page is POSTED to.
$login_attempt = ['username'=>'',
                  'password'=>'',
                  'status'  =>''];

// If this is a login attempt (after clicking submit) then test the password and username,
// save the result into the clients JavaScript so they can display failure and success messages.
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $login_attempt['username'] = $_POST["username"];
    $login_attempt['password'] = $_POST["password"];
    
    if (login($_POST["username"], $_POST["password"])) {
        $login_attempt['status'] = "success";

        // redirect to home page on sucessful login
        header("location: index.php");
    } else {
        $login_attempt['status'] = "failure";
    }

    // save the login_attempt to the JavaScript so the client can show/hide the messages.
    ?>
    <script type="text/javascript">
      let login_attempt = {status:"<?php echo $login_attempt["status"]; ?>",
                       username:"<?php echo $_POST["username"]; ?>"};
    </script>
    <?php
} else {
    // if this isn't a login attempt, just set login_attempt to nothing so the JavaScript knows.
    ?>
    <script type="text/javascript">
      let login_attempt;
    </script>
    <?php
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
    
    <span id="success">Logged in. Redirecting to home page...</span>
    
    <div class = "box">
      <form action = "login.php" method = "post">
        <label>Username  </label><input type = "text" name = "username" required value = "<?php echo $login_attempt["username"]; ?>" /><br /><br />
        <label>Password  </label><input type = "password" name = "password" required /><br/><br />
        <input type="submit" value=" Submit "/><br />
        <span id="failure">Invalid login details</span>
      </form>
    </div>
    <!-- The login page! :D -->
    
    <?php include('footer.php'); ?>
  </body>
</html>
