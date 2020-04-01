<!--
    This is the single movie details page.
    It should be the same as assignment 1 but with a favorites button.
    It should also get everything using the db_helper functions, not an API.

    This contains the stuff from Terrence's assignment 1. It hasn't been checked, it's just a
    starting point.
  -->
<?php
session_start();

// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <?php $page_title = 'Movie Details'; ?>
    <?php include('meta.php'); ?>
    <?php include('db-helpers.inc.php'); ?>
    
    <link rel="stylesheet" href="css/single-movie.css">
    <script type="text/javascript" src="js/single-movie.js"></script>
  </head>
  <body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
    <?php include('output-movie.php'); ?>
    
<!--   	<section id="details">
	  <input type="button" name="close" value="Close">
	  <div id="info">
		<div id="text">
		  <h1></h1>
		  <input type="button" value="Speak">
		  <div id="movie_stats">
			<p>
			  <b>Release date:</b> <div id="release_date"></div><br/>
			  <b>Revenue:</b> <div id="revenue"></div><br/>
			  <b>Runtime:</b> <div id="runtime"></div> minutes<br/>
			  <b>Tagline:</b> <div id="tagline"></div><br/>
			  <b>Links:</b> <a href="" id="imdb">IMDB</a>, <a href="" id="tmdb">TMDB</a><br/>
			  <b>Popularity:</b> <div id="popularity"></div><br/>-->
			  <!--<b>Average rating:</b> <div id="average_rating"></div><br/>-->
			  <!--<b>Ratings:</b> <div id="ratings"></div><br/>-->
<!--              
			  <h2>Overview</h2>
			  <div id="overview"></div>
			</p>
		  </div>
		</div>-->
		<div id="companies" class="border">
		  <h2>Companies</h2>
		  <p>name, name, name</p>
		</div>
		<div id="countries" class="border">
		  <h2>Countries</h2>
		  <p>Canada!, United States :(</p>
		</div>
		<div id="keywords" class="border">
		  <h2>Keywords</h2>
		  <p>Keyword 1, Keyword 2</p>
		</div>
		<div id="genres" class="border">
		  <h2>Genres</h2>
		  <p>Action, Other stuff...</p>
		</div>
	  </div>
	  <div id="images">
		<img src="https://marmelab.com/images/blog/ascii-art-converter/homer.png">
	  </div>
	  <div>
		<div id="cast-crew-buttons">
		  <input type="button" value="Cast" class="active">
		  <input type="button" value="Crew">
		</div>
		<div id="castcrew">
		  <div id="cast">
			<p>Character</p>
			<p>Name</p>
			<p>Character</p>
			<p>Name</p>
			<p>Character</p>
			<p>Name</p>
			<p>Character</p>
			<p>Name</p>
		  </div>
		  <div id="crew">
			<p>Department</p><p>Job</p><p>name</p>
			<p>Department</p><p>Job</p><p>name</p>
			<p>Department</p><p>Job</p><p>name</p>
		  </div>
		</div>
	  </div>
	</section>
    <?php include('footer.php'); ?>
  </body>
</html>

