<!--
    This page (if the user is logged in) displays a list of the favorited movies. 
    The list should work and display the same as on the browse-movies.php page.
    Should display an error if user isn't logged in.
  -->
<?php
session_start();
$page_title ='Favorites';
include 'db-helpers.inc.php';
// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('meta.php'); ?>
    <?php include('header.php'); ?>

	<link rel="stylesheet" href="css/favorites.css">
	<script type="text/javascript" src="js/favorites.js"></script>
  </head>
  <body>
    <?php include('nav.php'); ?>
    <h2> Favorite movies </h2>
    <form action="" method="post">
      <input type='submit' id='removeFavBtn' value='Remove All Favorites' />
    </form>
    <?php 
// var_dump($_SESSION['fav_movies']);
if (isset($_SESSION["u_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
  if ($_POST["name"]){
    echo "hihihihi";
  }
  $_SESSION['fav_movies'] = array();
}

if (isset($_SESSION["u_id"]) && count($_SESSION['fav_movies']) > 0) {
  $hi = count($_SESSION['fav_movies']);
  if (isset($_SESSION['fav_movies'])) {
    $user_id = $_SESSION["u_id"];
    $fav_movies = $_SESSION['fav_movies'];
    // $result = favoriteMovie($user_id, $fav_movies);
    echo "<div id='movies'>";
    $keys = array_keys($fav_movies);
    for ($i = 0; $i < count($fav_movies); $i++) {
      // var_dump($fav_movies[$keys[$i]]['poster']);
      echo "<div class='fav_movie'>";
      echo "<h3>" . $fav_movies[$keys[$i]]['title'] . "</h3>". "<br>";
      echo "<img src='https://image.tmdb.org/t/p/w92". $fav_movies[$keys[$i]]['poster'] . "' />";
      echo "<form action='' method='post'>"; 
      echo "<input type='submit' value='Remove From Favorites' name='". $fav_movies[$keys[$i]]['poster']. "' />";
      echo "</form>";
      echo "</div>";
    }
    echo '</div>'; 
    }
  } else {
    echo "<p>No Favorite Movies</p>";
  }
  
?>

    <?php include('footer.php'); ?>
  </body>
</html>
