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

	<link rel="stylesheet" href="css/browse-movies.css">
	<script type="text/javascript" src="js/browse-movies.js"></script>
  </head>
  <body>
    <?php include('nav.php'); ?>
    <?php 


if (isset($_SESSION["u_id"])) {
  $name = $_SESSION["u_id"];
  echo "<h2> Favorite movies </h2>";
  if (isset($_SESSION['fav_movies']) && count($_SESSION['fav_movies']) > 0) {
    echo "<input type='submit' value='Remove All Favorites'></input>";
    $movs = $_SESSION['fav_movies'];
    $fav_movies = join(",", $movs);
    $conn = getDatabaseConnection();
    $sql = "SELECT * FROM movie WHERE id IN ($fav_movies)";
    $result = runQuery($conn, $sql);
    while ($row = $result->fetch()) {
      echo "<div class='fav_movie'>";
      echo "<h3>" . $row['title'] . "</h3>". "<br>";
      echo "<img src='https://image.tmdb.org/t/p/w92". $row['poster_path'] . "' />";
    }
  } else {
    echo "<p>No Favorite Movies</p>";
  }
  }
?>

    <?php include('footer.php'); ?>
  </body>
</html>
