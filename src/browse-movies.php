<?php include('header.php'); ?>
<style>
<?php include('browse-movies.css'); ?>
</style>

<section id="search">
			<div id="filters_box">
				<form id="filters" title="Movie Filters">
					<h4>Movie Filters</h3>
					<fieldset>
						<legend><h5>Title</h5></legend>	
						<input type="text" name="title"/>
					</fieldset>
					
					<fieldset id="year_filters">
						<legend><h5>Year</h5></legend>
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
						<legend><h5>Rating</h5></legend>
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
			</div>
			<div id="matches">
				<h4>List / Matches</h4>
				<div id="matches-header">
					<div id="title"><h5>Title</h5></div>
					<h5>Year</h5>
					<h5>Rating</h5>
				</div>
				<ul>
					<li></li>

				</ul>
			</div>
		</section>
<?php include('footer.php'); ?>