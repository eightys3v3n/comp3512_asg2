document.addEventListener("DOMContentLoaded", main);

//const api_url = "http://www.randyconnolly.com/funwebdev/3rd/api/movie/movies-brief.php?id=ALL";
const api_url = "api/movies-brief.php";
const poster_url = "https://image.tmdb.org/t/p/";
const tmdb_url = "https://themoviedb.org/movie/";
const imdb_url = "https://imdb.com/title/";
let movies;

function Filter(title, year_between, rating_between) {
	if (title) {
		this.title = title.toLowerCase();
	} else {
		this.title = "";
	}

	if (year_between) {
		console.assert(year_between.length === 2, "year_between must be an array with two elements");
		if (year_between[0] && year_between[1]) {
			console.assert(year_between[0] <= year_between[1], "After year must be <= than Before year when specified");
		}
		this.year = {after: year_between[0], before: year_between[1]};
	}

	if (rating_between) {
		console.assert(rating_between.length === 2, "rating_between must be an array with two elements");
		if (rating_between[0] && rating_between[1]) {
			console.assert(rating_between[0] <= rating_between[1], "Above rating must be >= Below rating when specified");
		}
		this.rating = {above: rating_between[0], below: rating_between[1]};
	}
}

function get_movies() {
	try {
		movies = JSON.parse(window.localStorage.getItem("movies"));
		movies = movies.sort((a,b) => {
			if (a.title < b.title) {
				return -1;
			} else if (a.title > b.title) {
				return 1;
			} else {
				return 1;
			}
		});
		populate_movies(movies);
		hide_loading();
	} catch(e) {
		console.log("Failed to get movies from local storage.");
	}

	if (!movies) {
		console.log("Downloading movies...");
		show_loading();
		fetch(api_url)
			.then(response => response.json())
			.then(data => {
				window.localStorage.setItem("movies", JSON.stringify(data));
				populate_movies(data)
				hide_loading();
			});
	}
}

function show_loading() {
	document.querySelector("#search #matches #loading").style.display = "";
	document.querySelector("#matches").style.backgroundColor = "white";
	document.querySelector("#loading").style.backgroundColor = "white";
	document.querySelector("#matches-header").style.backgroundColor = "white";
	document.querySelector("#title").style.backgroundColor = "white";
	document.querySelector("#no_matches").style.display = "none";
	document.querySelector("#loading").style.cursor = "progress";
}

function hide_loading() {
	document.querySelector("#search #matches #loading").style.display = "none";
	document.querySelector("#search #matches").style.backgroundColor = "rgb(230, 230, 230)";
}

function main() {
	get_movies();
    refresh_filters();

	document.querySelector("#filters")
		.addEventListener("keyup", e => {
			if (e.keyCode === 13) {
				refresh_filters();
			}
		});

	document.querySelector("#search #filters_box #hide_filters")
		.addEventListener("click", toggle_filters);
	document.querySelector("#search #filters #buttons #update_filters")
		.addEventListener("click", refresh_filters);
	document.querySelector("#search #filters #year_filters #before_year")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #year_filters #before").checked = true;
		});
	document.querySelector("#search #filters #year_filters #after_year")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #year_filters #after").checked = true;
		});
	document.querySelector("#search #filters #year_filters #between_start")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #year_filters #between").checked = true;
		});
	document.querySelector("#search #filters #year_filters #between_end")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #year_filters #between").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #below_rating")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #below").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #above_rating")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #above").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #between_start")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #between").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #between_end")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #between").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #below_rating")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #below_range_value").textContent = e.target.value;
		});
	document.querySelector("#search #filters #rating_filters #above_rating")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #above_range_value").textContent = e.target.value;
		});
	document.querySelector("#search #filters #rating_filters #between_start")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #between_start_value").textContent = e.target.value;
		});
	document.querySelector("#search #filters #rating_filters #between_end")
		.addEventListener("click", e => {
			document.querySelector("#search #filters #rating_filters #between_end_value").textContent = e.target.value;
		});
}

function toggle_filters() {
	let filters_box = document.querySelector("#search #filters");
	let hide_btn = document.querySelector("#search #filters_box #hide_filters p");
	let section = document.querySelector("#search");

	if (filters_box.style.display == "none") {
		filters_box.style.display = "";
		hide_btn.textContent = "<";
		section.style.gridTemplateColumns = "1fr 2fr";
	} else {
		filters_box.style.display = "none";
		hide_btn.textContent = ">";
		section.style.gridTemplateColumns = "2em auto";
	}
}

function refresh_filters() {
	let title = document.querySelector("#search #filters input[name='title']").value;
	let year_between = get_year_between_filter();
	let rating_between = get_rating_between_filter();

	filter = new Filter(title, year_between, rating_between);
	filtered_movies = filter_movies(filter);
	populate_movies(filtered_movies);
}

function get_year_between_filter() {
	let year = [undefined, undefined];
	let before = document.querySelector("#search #filters #year_filters #before");
	let after = document.querySelector("#search #filters #year_filters #after");
	let between = document.querySelector("#search #filters #year_filters #between");

	if (before.checked) {
		year[1] = document.querySelector("#search #filters #year_filters #before_year").value;
		year[1] = parseInt(year[1]);
	} else if (after.checked) {
		year[0] = document.querySelector("#search #filters #year_filters #after_year").value;
		year[0] = parseInt(year[0]);
	} else if (between.checked) {
		year[0] = document.querySelector("#search #filters #year_filters #between_start").value;
		year[1] = document.querySelector("#search #filters #year_filters #between_end").value;
		year = [parseInt(year[0]), parseInt(year[1])];
		year[1] += 1;
	}

	if (year[0] === "")
		year[0] = undefined;
	if (year[1] === "")
		year[1] = undefined;

	return year;
}

function get_rating_between_filter() {
	let rating = [undefined, undefined];
	let below = document.querySelector("#search #filters #rating_filters #below");
	let above = document.querySelector("#search #filters #rating_filters #above");
	let between = document.querySelector("#search #filters #rating_filters #between");

	if (below.checked) {
		rating[1] = document.querySelector("#search #filters #rating_filters #below_rating").value;
		rating[1] = parseFloat(rating[1]);
	} else if (above.checked) {
		rating[0] = document.querySelector("#search #filters #rating_filters #above_rating").value;
		rating[0] = parseFloat(rating[0]);
	} else if (between.checked) {
		rating[0] = document.querySelector("#search #filters #rating_filters #between_start").value;
		rating[1] = document.querySelector("#search #filters #rating_filters #between_end").value;
		rating = [parseFloat(rating[0]), parseFloat(rating[1])];
	}

	if (rating[0] === "") {
		rating[0] = undefined;
	}
	if (rating[1] === "") {
		rating[1] = undefined;
	}

	return rating;
}

function populate_movies(movies_list) {
	let matches = document.querySelector("#search #matches ul");

	matches.innerHTML = "";

	if (movies_list.length === 0) {
		document.querySelector("#search #matches #no_matches").style.display = "";
	} else {
		document.querySelector("#search #matches #no_matches").style.display = "none";
		for (let movie of movies_list) {
			add_movie(matches, movie);
		}
	}
}

function add_movie(element, movie) {
	let li = document.createElement("li");
	li.classList.add("match");

	let img = document.createElement("img");
	img.classList.add("icon");
	img.src = poster_url + "w92" + movie.poster;
	img.alt = "Movie Poster";
	li.appendChild(img);

	let h3 = document.createElement("h3");
	h3.classList.add("title");
	h3.textContent = movie.title;
	li.appendChild(h3);

	let year = document.createElement("p");
	year.classList.add("year");
	year.textContent = year_of(movie.release_date);
	li.appendChild(year);

	let rating = document.createElement("p");
	rating.classList.add("rating");
	rating.textContent = movie.ratings.average.toFixed(1);
	li.appendChild(rating);

	//Create Favorite Movie Button
    let fav_a = document.createElement("a");
	fav_a.textContent = "Favorite";
	fav_a.href = `favorite-movie.php?mov_id=${movie.id}`;
	li.appendChild(fav_a);
    // fav_a.addEventListener("click", e=> {
    //     favorite_movie(e, movie);
    // });

    // let fav_a = document.createElement("a");
    // fav_a.textContent = "Favorite";
	// li.appendChild(fav_a);
    // fav_a.addEventListener("click", e=> {
    //     favorite_movie(e, movie);
    // });
    
	let view_a = document.createElement("a");
    view_a.href = `single-movie.php?id=${movie.id}`;
	view_a.textContent = "View";
	li.appendChild(view_a);
    
	element.appendChild(li);
	li.addEventListener("click", e => { window.location = view_a.href; });
}

function favorite_movie(e, movie) {
    e.stopPropagation();

    fetch(`api/favorite-movie.php?movie_id=${movie.id}`)
        .then(res => {
            console.log(res.json());
            console.log(Object.getOwnPropertyNames(res));
			// e.target.textContent = data;
			return res.json();
		})
		.then(data => {
			// e.target.textContent = data;
			console.log('hu')
			console.log(data);
		})
		.catch(error => {
			console.log(error);
		});
    
    // if (e.target.textContent == "Favorite") {
        // e.target.textContent = "NOT IMPLEMENTED"; // change this to Unfavorite if successful.
    // } else {
        // e.target.textContent = "Favorite";
    // }
}

function year_of(date_str) {
	return date_str.split("-")[0];
}

function filter_movies(filter) {
	if (!movies) {
		console.warn("Movies attempted to be populated but they haven't been fetched yet.");
		return [];
	}

	let filtered_movies = [];
	for (let movie of movies) {
		if (!movie.title.toLowerCase().includes(filter.title)) // in production this would be a fuzzy search rather than includes.
			continue;

		let date = new Date(movie.release_date);
		if (filter.year.before && filter.year.before <= date.getFullYear())
			continue;
		if (filter.year.after && filter.year.after > date.getFullYear())
			continue;
        
        // console.log(movie);
		let rating = movie.ratings.average;
		if (filter.rating.below && rating > filter.rating.below)
			continue;
		if (filter.rating.above && rating < filter.rating.above)
			continue;

		filtered_movies.push(movie);
	}

	return filtered_movies;
}

