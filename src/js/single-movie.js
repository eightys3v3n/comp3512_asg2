document.addEventListener("DOMContentLoaded", main);



function main() {
    // Put your stuff here. This runs after DOMContentLoaded.

}

// Example function from asg1
function switch_movie(movie) {
	/// This is just some example content so you know what fields to create. Don't do the query
    /// selector thing I did; bad practice. Use document.createElement and create the stuff.

	let title = document.querySelector("#details #info #text h1");
	title.textContent = movie.title;

	let release = document.querySelector("#details #info #text #movie_stats #release_date");
	release.textContent = movie.release_date;

	let revenue = document.querySelector("#details #info #text #movie_stats #revenue");
	revenue.textContent = movie.revenue.toLocaleString('en-US', {
		style: 'currency',
		currency: 'USD',
	});

	let runtime = document.querySelector("#details #info #text #movie_stats #runtime");
	runtime.textContent = movie.runtime;

	let tagline = document.querySelector("#details #info #text #movie_stats #tagline");
	tagline.textContent = movie.tagline;

	let imdb = document.querySelector("#details #info #text #movie_stats #imdb");
	imdb.href = imdb_url + movie.imdb_id;
	
	let tmdb = document.querySelector("#details #info #text #movie_stats #tmdb");
	tmdb.href = tmdb_url + movie.tmdb_id;
	
	let popularity = document.querySelector("#details #info #text #movie_stats #popularity");
	popularity.textContent = movie.ratings.popularity;

	let average_rating = document.querySelector("#details #info #text #movie_stats #average_rating");
	average_rating.textContent = movie.ratings.average;

	let ratings = document.querySelector("#details #info #text #movie_stats #ratings");
	ratings.textContent = movie.ratings.count;
	
	let overview = document.querySelector("#details #info #text #movie_stats #overview");
	overview.textContent = movie.overview;

	let poster = document.querySelector("#details #images img");
	poster.src = poster_url + "w500" + movie.poster;
}
