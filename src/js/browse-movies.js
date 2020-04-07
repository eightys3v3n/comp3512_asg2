document.addEventListener("DOMContentLoaded", main);


// MAIN STUFF - Variables
const api_url = "api/movies-brief.php";
const poster_url = "https://image.tmdb.org/t/p/";
const tmdb_url = "https://themoviedb.org/movie/";
const imdb_url = "https://imdb.com/title/";
let movies;
let filtered_movies;
let filter;

// FILTERS - Variables
function Filter(title, year_between, rating_between) {
	if (title) {
		this.title = title.toLowerCase();
	} else {
		this.title = "";
	}

	if (year_between) {
		console.assert(year_between.length === 2,
                       "year_between must be an array with two elements");
		if (year_between[0] && year_between[1]) {
			console.assert(year_between[0] <= year_between[1],
                           "After year must be <= than Before year when specified");
		}
		this.year = {after: year_between[0], before: year_between[1]};
	}

	if (rating_between) {
		console.assert(rating_between.length === 2,
                       "rating_between must be an array with two elements");
		if (rating_between[0] && rating_between[1]) {
			console.assert(rating_between[0] <= rating_between[1],
                           "Above rating must be >= Below rating when specified");
		}
		this.rating = {above: rating_between[0], below: rating_between[1]};
	}
}


// MOVIE SORTING - Variables
let SORT_MODES = { // how to sort the matched movies
    ALPHA: "alphabetical",
    REV_ALPHA: "reverse_alphabetical",
    ASC_YEAR: "ascending year",
    DESC_YEAR: "descending year",
    ASC_RATING: "ascending rating",
    DESC_RATING: "descending rating",
};
let sort_mode = SORT_MODES.ALPHA; // alpha, rev-alpha, year, rev-year, rating, rev-rating


// MAIN STUFF - Code

function main() {
    get_movies(); // get all the movies and populate `movies`
    display_movies(); // display all the movies after updating the filters and sorting.

    // can use the enter key to submit filters
	document.querySelector("#filters")
		.addEventListener("keyup", e => {
			if (e.keyCode === 13) {
				refresh_filters();
			}
		});

    // show/hide filters
	document.querySelector("#search #filters_box #hide_filters")
		.addEventListener("click", toggle_filters);

    // when submitting filters, re-display movies
	document.querySelector("#search #filters #buttons #update_filters")
		.addEventListener("click", e => {
            display_movies();
        });

    // check the associated ratio whenever a filter is clicked on (YEARS)
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

    // check the associated ratio whenever a filter is clicked on (RATINGS)
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

    // update the value text when a filter value is changed
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

    // change the sort mode when a heading title is clicked
    document.querySelector("#search #matches-header #title")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ALPHA)
        });
    document.querySelector("#search #matches-header #year")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ASC_YEAR)
        });
    document.querySelector("#search #matches-header #rating")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ASC_RATING)
        });
}

/**
   Tries to populate the `movies` global variable using local storage, or the `api_url`.
   Also populated `filtered_movies` with a sorted version of `movies`.
  */
function get_movies() {
	try {
		movies = JSON.parse(window.localStorage.getItem("movies"));

        display_movies();
	} catch(e) {
		console.log("Failed to get movies from local storage.");
	}

	if (! movies) {
		console.log("Downloading movies...");
		fetch(api_url)
			.then(response => response.json())
			.then(data => {
				window.localStorage.setItem("movies", JSON.stringify(data));
                movies = data;

                display_movies();
			});
	}
}

/**
   Shows a loading image/text and hides the movies list.
  */
function show_loading() {
    // display the loading stuff
	document.querySelector("#search #matches #loading").style.display = "block";
    document.querySelector("#search #matches ul").style.display = "none";
}

/**
   Hides the loading image/text and shows the movie list.
  */
function hide_loading() {
	document.querySelector("#search #matches #loading").style.display = "none";
    document.querySelector("#search #matches ul").style.display = "block";
}

function favorite_movie(e, movie) {
    e.stopPropagation();

	fetch(`api/favorite-movie.php?movie_id=${movie.id}`,{
		method: 'post'
	})
	.then((res) => {
		console.log('hi')
		return res.json()
	})
	.then(data => console.log(data))
	.catch((err) => {
		console.log(err);
	})
}

/**
   Returns the year portion of a date string
  */
function year_of(date_str) {
	return date_str.split("-")[0];
}



// DISPLAY
/**
   Sorts, filters, and displays the movies list. A very intensive function.
  */
function display_movies() {
    refresh_filters();

    if (! movies) {
        console.warn("Tried to display movies before they were fetched");
    } else {
        filtered_movies = filter_movies(movies, filter);
        filtered_movies = sort_movies(filtered_movies);
        populate_movies(filtered_movies);
    
        hide_loading();
    }
}

/**
   Adds all the given movies to the CSS:`#search #matches #ul` element.
   Also shows a "No Matches" element if no movies are given, or hides
   the "No Matches" element if movies are given.
  */
function populate_movies(movies_list) {        
	let matches = document.querySelector("#search #matches ul");

	matches.innerHTML = "";

	if (movies_list.length === 0) {
		document.querySelector("#search #matches #no_matches").style.display = "block";
	} else {
		document.querySelector("#search #matches #no_matches").style.display = "none";
		for (let movie of movies_list) {
			add_movie(matches, movie);
		}
	}
}

/**
   Builds the HTML for a `movie` in the list and adds it to the `element`.
  */
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
	// fav_a.href = `favorite-movie.php?mov_id=${movie.id}`;
	li.appendChild(fav_a);
    fav_a.addEventListener("click", e=> {
        favorite_movie(e, movie);
    });

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




// FILTERS
/**
   Gets the filter information from the form, creates a Filter object and saves it to `filer` global variable.
  */
function refresh_filters() {
	let title = document.querySelector("#search #filters input[name='title']").value;
	let year_between = get_year_between_filter();
	let rating_between = get_rating_between_filter();

	filter = new Filter(title, year_between, rating_between);
}

/**
   Creates an array of filtered movies based on the global `filter` and `movies` variables.
  */
function filter_movies(movies, filter) {
	if (!movies) {
		console.warn("Movies attempted to be sorted filtered but they haven't been fetched yet.");
		return [];
	}

	let filtered_movies = [];
    
	for (let movie of movies) {
		if ( ! movie.title.toLowerCase().includes(filter.title)) // in production this would be a fuzzy search rather than includes.
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

/**
   Hides and shows the filters side bar.
  */
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

/**
   Gets the after and before year from the selected year filter and returns
   `[after, before]`.
  */
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

/**
   Gets the above and below rating from the selected rating filter and returns
   `[above, below]`.
  */
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



// MOVIE SORTING

/**
   Figures out how the movies should be sorted given the desired mode.
   If the desired mode is alphabetical, but that's already in effect, it reverses it.
  */
function switch_sort_mode(new_mode) {
    sort_mode = get_sort_mode(new_mode, sort_mode);
    
    filtered_movies = sort_movies(filtered_movies);
    populate_movies(filtered_movies);
}

/**
   Sorts a given movie list using the global `sort_mode` variable.
  */
function sort_movies(movies) {
    if (sort_mode == SORT_MODES.ALPHA) {
        movies = sort_by_title(movies);
    } else if (sort_mode == SORT_MODES.REV_ALPHA) {
        movies = sort_by_title(movies).reverse();
    }

    return movies;
}

/**
   Sorts the input list by the title in alphabetical order.
  */
function sort_by_title(movies) {
    movies = movies.sort((a,b) => {
		if (a.title < b.title) {
			return -1;
		} else if (a.title > b.title) {
			return 1;
		} else {
			return 1;
		}
	});
    return movies;
}

/**
   Deduces the sort mode given which sort mode button was clicked. This is used to toggle
   the various sort modes between normal and reverse.

   If you desire title sorting (alphabetical) but that's already selected, this returns
   reverse alphabetical sorting.
  */
function get_sort_mode(desired_mode, previous_mode) {
    let sort_mode;
    
    if (desired_mode == SORT_MODES.ALPHA) {
        if (previous_mode == SORT_MODES.ALPHA) {
            sort_mode = SORT_MODES.REV_ALPHA;
        } else {
            sort_mode = SORT_MODES.ALPHA;
        }
    } else if (desired_mode == SORT_MODES.ASC_YEAR) {
        if (previous_mode == SORT_MODES.ASC_YEAR) {
            sort_mode = SORT_MODES.DESC_YEAR;
        } else {
            sort_mode = SORT_MODES.ASC_YEAR;
        }
    } else if (desired_mode == SORT_MODES.ASC_RATING) {
        if (previous_mode == SORT_MODES.ASC_RATING) {
            sort_mode = SORT_MODES.DESC_RATING;
        } else {
            sort_mode = SORT_MODES.ASC_RATING;
        }
    } else {
        console.error("Invalid sort mode: "+sort_mode);
    }

    return sort_mode;
}
