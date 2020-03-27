<?php //include('header.php'); ?>
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
		<header>
			<h2>COMP 3512 Assignment 1</h2>
			<h3>Terrence Plunkett</h3>
		</header>
		<section id="home">
			<div id="home_box">
				<h1>Movie Browser</h1>
				<div id="form">
					<label for="search_query"><b>Title</b></label>
					<input type="text" id="search_query">
					<input type="button" value="Show Matching Movies" name="search">
					<input type="button" value="Show All Movies" name="all_movies">
				</div>
			</div>
		</section>
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
						<input type="range" id="below_rating" min="0" max="10" value="10"/>
						<p id="below_range_value" class="range_value">10</p>

						<input type="radio" name="rating_selector" id="above"/>
						<label>Above</label>
						<input type="range" id="above_rating" min="0" max="10" value="0"/>
						<p id="above_range_value" class="range_value">0</p>
						
						<input type="radio" name="rating_selector" id="between"/>
						<label>Between</label>
						<input type="range" id="between_start" min="0" max="10" value="0"/>
						<p id="between_start_value" class="range_value">0</p>
						<input type="range" id="between_end" min="0" max="10" value="10"/>
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
		<section id="details">
			<input type="button" name="close" value="Close">
			<div id="info">
				<div id="text">
					<h1>Movie Title!</h1>
					<input type="button" value="Speak">
					<div id="movie_stats">
						<p>
							<b>Release date:</b> <div id="release_date"></div><br/>
							<b>Revenue:</b> <div id="revenue"></div><br/>
							<b>Runtime:</b> <div id="runtime"></div> minutes<br/>
							<b>Tagline:</b> <div id="tagline"></div><br/>
							<b>Links:</b> <a href="" id="imdb">IMDB</a>, <a href="" id="tmdb">TMDB</a><br/>
							<b>Popularity:</b> <div id="popularity"></div><br/>
							<b>Average rating:</b> <div id="average_rating"></div><br/>
							<b>Ratings:</b> <div id="ratings"></div><br/>

							<h2>Overview</h2>
							<div id="overview"></div>
						</p>
					</div>
				</div>
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
	</body>
</html>

<?php //include('footer.php'); ?>
