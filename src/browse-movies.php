
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title>COMP 3512 Assign 1</title>

		<link rel="stylesheet" href="browse-movies.css">
		<script src="browse-movies.js"></script>
	</head>
	<body>
      <?php include('header.php'); ?>
		<section id="search">
			<div id="filters_box">
				<form id="filters" title="Movie Filters">
					<h1><center>Movie Filters</center></h1>
					<fieldset>
						<legend><h2>Title</h2></legend>	
						<input type="text" name="title"/>
					</fieldset>
					
					<fieldset id="year_filters">
						<legend><h2>Year</h2></legend>
						<div>
						<input type="radio" name="year_selector" value="before" id="before"/>
						<label>Before</label>
						<input type="number" id="before_year" min="1000"/>

						<input type="radio" name="year_selector" value="after" id="after"/>
						<label>After</label>
						<input type="number" id="after_year" min="1000"/>

						<input type="radio" name="year_selector" value="between" id="between"/>
						<label>Between</label>
						<input type="number" id="between_start" placeholder="1970" min="1000"/>
						<input type="number" id="between_end" placeholder="1975" min="1000"/>
						</div>
					</fieldset>
					<fieldset id="rating_filters">
						<legend><h2>Rating</h2></legend>
						<div>
						<input type="radio" name="rating_selector" id="below"/>
						<label>Below</label>
						<input type="range" id="below_rating" min="0" max="10" value="10" step="0.5"/>
						<p id="below_range_value" class="range_value">10</p>

						<input type="radio" name="rating_selector" id="above"/>
						<label>Above</label>
						<input type="range" id="above_rating" min="0" max="10" value="0" step="0.5"/>
						<p id="above_range_value" class="range_value">0</p>
						
						<input type="radio" name="rating_selector" id="between"/>
						<label>Between</label>
						<input type="range" id="between_start" min="0" max="10" value="0" step="0.5"/>
						<p id="between_start_value" class="range_value">0</p>
						<input type="range" id="between_end" min="0" max="10" value="10" step="0.5"/>
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
					<li>
						<img class="icon" src="https://assets.fireside.fm/file/fireside-images/podcasts/images/b/bc7f1faf-8aad-4135-bb12-83a8af679756/cover.jpg?v=3"></img>
						<h3 class="title">This is a movie title</h3>
						<p class="year">1999</p>
						<p class="rating">1.1</p>
						<input type="button" name="view" value="View"/>
					</li>
					<li>
						<img class="icon" src="https://assets.fireside.fm/file/fireside-images/podcasts/images/b/bc7f1faf-8aad-4135-bb12-83a8af679756/cover.jpg?v=3"></img>
						<h3 class="title">This is a movie title</h3>
						<p class="year">1999</p>
						<p class="rating">1.1</p>
						<input type="button" name="view" value="View"/>
					</li>

				</ul>
			</div>
		</section>
        <?php include('footer.php'); ?>
	</body>
</html>
