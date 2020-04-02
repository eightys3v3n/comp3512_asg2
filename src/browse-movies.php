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

$query = [
    'title'=>'',
    'year_after'=>'',
    'year_before'=>'',
    'rating_above'=>0,
    'rating_below'=>10,
];
$selected = [
    'year_after'=>false,
    'year_before'=>false,
    'year_between'=>false,
    'rating_above'=>false,
    'rating_below'=>false,
    'rating_between'=>false,
];

if (isset($_GET['title'])) {
    $query['title'] = $_GET['title'];
}
if (isset($_GET['year_after'])) {
    $query['year_after'] = $_GET['year_after'];
}
if (isset($_GET['year_before'])) {
    $query['year_before'] = $_GET['year_before'];
}
if (isset($_GET['rating_above'])) {
    $query['rating_above'] = (float)$_GET['rating_above'];
}
if (isset($_GET['rating_below'])) {
    $query['rating_below'] = (float)$_GET['rating_below'];
}

// figure out which year ratio should be filled
if (isset($_GET['year_after']) && ! isset($_GET['year_before'])) {
    $selected['year_after'] = true;
} else if (! isset($_GET['year_after']) && isset($_GET['year_before'])) {
    $selected['year_beforer'] = true;
} else if (isset($_GET['year_after']) && isset($_GET['year_before'])) {
    $selected['year_between'] = true;
}

// figure out which rating ratio should be filled
if (isset($_GET['rating_above']) && ! isset($_GET['rating_below'])) {
    $selected['rating_above'] = true;
} else if (! isset($_GET['rating_above']) && isset($_GET['rating_below'])) {
    $selected['rating_belowr'] = true;
} else if (isset($_GET['rating_above']) && isset($_GET['rating_below'])) {
    $selected['rating_between'] = true;
}

?>
<!-- <script type="text/javascript">
  let query = {
      title: "<?php echo $query['title']; ?>",
      year_after: "<?php echo $query['year_after']; ?>",
      year_before: "<?php echo $query['year_before']; ?>",
      rating_above: "<?php echo $query['rating_above']; ?>",
      rating_below: "<?php echo $query['rating_below']; ?>"
  };
</script> -->

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
			<input type="text" name="title" value="<?php echo $query['title']; ?>"/>
		  </fieldset>
		  
		  <fieldset id="year_filters">
			<legend><h2>Year</h2></legend>
			<div>
                 <input type="radio" name="year_selector" value="before" id="before" <?php if ($selected['year_before']) { echo 'checked'; } ?>/>
			  <label>Before</label>
			  <input type="number" id="before_year" min="1000" value="<?php echo $query['year_before']; ?>"/>
              
			  <input type="radio" name="year_selector" value="after" id="after" <?php if ($selected['year_after']) { echo 'checked'; } ?>/>
			  <label>After</label>
			  <input type="number" id="after_year" min="1000" value="<?php echo $query['year_after']; ?>"/>
              
			  <input type="radio" name="year_selector" value="between" id="between" <?php if ($selected['year_between']) { echo 'checked'; } ?>/>
			  <label>Between</label>
			  <input type="number" id="between_start" placeholder="1970" min="1000" value="<?php echo $query['year_after']; ?>"/>
			  <input type="number" id="between_end" placeholder="1975" min="1000" value="<?php echo $query['year_before']; ?>"/>
			</div>
		  </fieldset>
		  <fieldset id="rating_filters">
			<legend><h2>Rating</h2></legend>
			<div>
			  <input type="radio" name="rating_selector" id="below" <?php if ($selected['rating_below']) { echo 'checked'; } ?>/>
			  <label>Below</label>
			  <input type="range" id="below_rating" min="0" max="10" step="0.1" value="<?php echo $query['rating_below']; ?>"/>
			  <p id="below_range_value" class="range_value">10</p>
              
			  <input type="radio" name="rating_selector" id="above" <?php if ($selected['rating_above']) { echo 'checked'; } ?>/>
			  <label>Above</label>
			  <input type="range" id="above_rating" min="0" max="10" step="0.1" value="<?php echo $query['rating_above']; ?>"/>
			  <p id="above_range_value" class="range_value">0</p>
			  
			  <input type="radio" name="rating_selector" id="between" <?php if ($selected['rating_between']) { echo 'checked'; } ?>/>
			  <label>Between</label>
			  <input type="range" id="between_start" min="0" max="10" step="0.1" value="<?php echo $query['rating_above']; ?>"/>
			  <p id="between_start_value" class="range_value">0</p>
			  <input type="range" id="between_end" min="0" max="10" step="0.1" value="<?php echo $query['rating_below']; ?>"/>
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
		  <div id="title"><h2>Title</h2></div>
		  <h2>Year</h2>
		  <h2>Rating</h2>
		</div>
		<div id="loading">
		  <img src="https://media.giphy.com/media/WiIuC6fAOoXD2/giphy.gif" title="Loading">
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
