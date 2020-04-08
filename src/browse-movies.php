<!--
    This page lets a user search for movies. Each movie also has a link to the details page for that movie
    and a favorite button. The movies need to be intuatively sortable by all the columns.
  -->
<?php
// start or resume a session with a user
session_start();

// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');

$page_title ='Browse Movies';
 
?>
<script type="text/javascript">
<?php
//   if (isset($_SESSION['fav_movies'])) {
//       foreach ($movie in $_SESSION['fav_movies']) {
//           echo $movie."<br>";
//       }
//   }
// ?>
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('meta.php'); ?>
    
	<link rel="stylesheet" href="css/browse-movies.css">
	<script type="text/javascript" src="js/browse-movies.js"></script>
  </head>
  <body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
    
	<section id="search">
	  <div id="filters_box">
		<form id="filters" title="Movie Filters">
		  <h1><center>Movie Filters</center></h1>
		  <fieldset>
			<legend><h2>Title</h2></legend>	
			<input id="title" type="text" name="title"/>
		  </fieldset>
		  
		  <fieldset id="year_filters">
			<legend><h2>Year</h2></legend>
			<div>
                 <input type="radio" name="year_selector" value="before" id="before"/>
			  <label>Before</label>
			  <input type="number" id="before_year" min="1000" value=""/>
              
			  <input type="radio" name="year_selector" value="after" id="after"/>
			  <label>After</label>
			  <input type="number" id="after_year" min="1000" value=""/>
              
			  <input type="radio" name="year_selector" value="between" id="between"/>
			  <label>Between</label>
			  <input type="number" id="between_start" placeholder="1970" min="1000" value=""/>
			  <input type="number" id="between_end" placeholder="1975" min="1000" value=""/>
			</div>
		  </fieldset>
		  <fieldset id="rating_filters">
			<legend><h2>Rating</h2></legend>
			<div>
			  <input type="radio" name="rating_selector" id="below"/>
			  <label>Below</label>
			  <input type="range" id="below_rating" min="0" max="10" step="0.1" value="10"/>
			  <p id="below_range_value" class="range_value">10</p>
              
			  <input type="radio" name="rating_selector" id="above"/>
			  <label>Above</label>
			  <input type="range" id="above_rating" min="0" max="10" step="0.1" value="0"/>
			  <p id="above_range_value" class="range_value">0</p>
			  
			  <input type="radio" name="rating_selector" id="between"/>
			  <label>Between</label>
			  <input type="range" id="between_start" min="0" max="10" step="0.1" value="0"/>
			  <p id="between_start_value" class="range_value">0</p>
			  <input type="range" id="between_end" min="0" max="10" step="0.1" value="10"/>
			  <p id="between_end_value" class="range_value">10</p>
			</div>
		  </fieldset>
		  <div id="buttons">
			<input type="button" id="update_filters" value="Filter"/>
			<input type="reset" value="Clear"/>
		  </div>
		</form>
		<div id="hide_filters">
		  <p>&lt</p>
		</div>
	  </div>
	  <div id="matches">
		<h1><center>List / Matches<center></h1>
		<div id="matches-header">
		  <span id="title"><h2>Title</h2></span>
		  <span id="year"><h2>Year</h2></span>
		  <span id="rating"><h2>Rating</h2></span>
		</div>
		<div id="loading">
		  <img src="public\ping.gif" title="Loading">
		  <p>Loading...</p>
		</div>
		<p id="no_matches">No matches found</p>
		<ul>
          <!--
              This is filled with the matched movie titles.
            -->
		</ul>
	  </div>
	</section>

    <?php include('footer.php'); ?>
  </body>
</html>
