<!--
    This page (if the user is logged in) displays a list of the favorited movies. 
    The list should work and display the same as on the browse-movies.php page.
    Should display an error if user isn't logged in.
  -->
<?php
// start or resume a session with a user
session_start();

// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');

$page_title ='Favorite Movies'; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('meta.php'); ?>
    
	<link rel="stylesheet" href="css/favorites.css">
	<script type="text/javascript" src="js/favorites.js"></script>
  <?php include('header.php'); ?>
  </head>
  <body>
    <?php include('nav.php'); ?>

    <?php
      if (isset($_SESSION['u_id'])) {
    ?>
	<section id="favorites">
	  <div id="matches">
		<h1><center>Favorites<center></h1>
		<div id="list-header">
		  <span id="title"><h2>Title</h2></span>
		  <span id="year"><h2>Year</h2></span>
		  <span id="rating"><h2>Rating</h2></span>
          <span id="unfavorite-all"><input type="button" value="Unfavorite All"></span>
		</div>
		<div id="loading">
		  <img src="public\ping.gif" title="Loading">
		  <p>Loading...</p>
		</div>
		<p id="no_favorites">No favorites</p>
		<ul>
          <!--
              This is filled with the favorite movie titles.
            -->
		</ul>
	  </div>
	</section>
    <?php
      } else {
    ?>
    <p>User not logged in</p>
    <?php
      }
    ?>

    <?php include('footer.php'); ?>
  </body>
</html>
