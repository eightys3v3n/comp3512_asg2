document.addEventListener("DOMContentLoaded", main);

// MAIN STUFF - Variables
const api_url = "api/movies-brief.php";
const poster_url = "https://image.tmdb.org/t/p/";
const tmdb_url = "https://themoviedb.org/movie/";
const imdb_url = "https://imdb.com/title/";
const up_arrow = "&#8679;";
const down_arrow = "&#8681;";
let movies;
let favorited_movies;
const q_string = new URLSearchParams(window.location.search); // the query string parameters

// FILTERS - Variables
let filtered_movies;
let filter;

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
let sort_mode; // default set in main
let undo_sort_indicator;


// MAIN STUFF - Code

function main() {
    // set the values of the filters using the URL query string values.
    query_to_filters();
    
    // Expects an event as second argument. So we fake an event.
    switch_sort_mode(SORT_MODES.ALPHA, {'target': document.querySelector("#search #matches #matches-header #title")});

    get_movies(); // get all the movies and favorited movies and populate `movies` and `favorited_movies`

    // add event listeners for static page elements (IE stuff that is displayed even when no movies have been fetched)
    // can use the enter key to submit filters
	document.querySelector("#filters")
		.addEventListener("keyup", e => {
			if (e.keyCode === 13) {
				display_movies();
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

    // make sure to also reset the range values
    document.querySelector("#search #filters #buttons #reset_filters")
		.addEventListener("click", e => {
            reset_filters();
        });


    // check the associated ratio whenever a filter is changed on (YEARS)
	document.querySelector("#search #filters #year_filters #before_year")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #year_filters #before").checked = true;
		});
	document.querySelector("#search #filters #year_filters #after_year")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #year_filters #after").checked = true;
		});
	document.querySelector("#search #filters #year_filters #between_start")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #year_filters #between").checked = true;
		});
	document.querySelector("#search #filters #year_filters #between_end")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #year_filters #between").checked = true;
		});

    // check the associated ratio whenever a filter is changed on (RATINGS)
	document.querySelector("#search #filters #rating_filters #below_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #below").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #above_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #above").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #between_start_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #between").checked = true;
		});
	document.querySelector("#search #filters #rating_filters #between_end_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #between").checked = true;
		});

    // update the value text when a filter value is changed
	document.querySelector("#search #filters #rating_filters #below_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #below_range_value").textContent = e.target.value;
		});
	document.querySelector("#search #filters #rating_filters #above_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #above_range_value").textContent = e.target.value;
		});
	document.querySelector("#search #filters #rating_filters #between_start_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #between_start_value").textContent = e.target.value;
		});
	document.querySelector("#search #filters #rating_filters #between_end_rating")
		.addEventListener("change", e => {
			document.querySelector("#search #filters #rating_filters #between_end_value").textContent = e.target.value;
		});

    // change the sort mode when a heading title is clicked
    document.querySelector("#search #matches-header #title")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ALPHA, e);
        });
    document.querySelector("#search #matches-header #year")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ASC_YEAR, e);
        });
    document.querySelector("#search #matches-header #rating")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ASC_RATING, e);
        });
}

/**
   Interprets the query string in the URL into the filters panel.
  */
function query_to_filters() {
    let title = document.querySelector('#search #filters_box #filters #title');
    
    if (q_string.has('title')) {
        title.value = q_string.get('title');
    }
}

/**
   Tries to populate the `movies` global variable using local storage, or the `api_url`.
   Also populated `filtered_movies` with a sorted version of `movies`.
  */
function get_movies() {
    let promises = [];
    // a list of things that need to be retrieved before the movies can be displayed.
    // the fetched stuff must return a json dictionary where the keys are the fetch
    // result identifier. see the fetches below for examples.
    
	try {
		movies = JSON.parse(window.localStorage.getItem("movies"));

        display_movies();
	} catch(e) {
		console.log("Failed to get movies from local storage.");
	}

	if (! movies) {
        console.log("Downloading movies...");
        promises.push(fetch(api_url));
        // will return the json {'movies': [all the data]}
    }
    if (! favorited_movies) {
        console.log("Downloading favorites...");
        promises.push(fetch('api/favorites.php'));
        // will return the json {'favorites': [all the data]}
    }

    // only do the .then once all the promises have completed (all stuff received)
    Promise.all(promises)
		.then(resps => { // get the json of every response
            let jsons = [];
            for (resp of resps) {
                jsons.push(resp.json());
            }
            return Promise.all(jsons);
        })
		.then(jsons => {
            let json = {}; // a dictionary of all the retrieved data
            for (j of jsons) {
                Object.assign(json, j);
            }

            if ('movies' in json) {
                movies = json['movies'];
			    window.localStorage.setItem("movies", JSON.stringify(movies));
            }

            if ('favorites' in json) {
                favorited_movies = json['favorites'];
            }

            console.log("Retrieved all initialization data");
            display_movies();
		});
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

/**
   Adds a movie to the users favorites and changes the button text to Favorited if successful.
  */
function favorite_movie(e, movie) { 
	fetch(`api/favorite-movie.php?movie_id=${movie.id}&poster=${movie.poster}&title=${movie.title}`)
        .then(resp => {
            resp.text().then(body => {
                body = body.trim();
                if (body == "" || body == "Already favorited") {
                    e.target.value = "Favorited";
                    console.log(`Favorited movie "${movie.title}"`);
                } else {
                    console.warn(`Failed to favorite movie "${movie.title}"`);
                    console.warn(body);
                }
            })
        })
	    .catch((err) => {
		    console.warn("Failed to favorite movie: "+err);
	    });
}

/**
   Resets the filters and their values
  */
function reset_filters()
{
    document.querySelector("#title").value = "";
    document.querySelector("#before_year").value = "";
    document.querySelector("#after_year").value = "";
    document.querySelector("#between_start").value = "";
    document.querySelector("#between_end").value = "";

    document.querySelector("#below_rating").value = 10;
    document.querySelector("#below_range_value").textContent = 10;

    document.querySelector("#above_rating").value = 0;
    document.querySelector("#above_range_value").textContent = 0;

    document.querySelector("#rating_filters #between_start_rating").value = 0;
    document.querySelector("#rating_filters #between_start_value").textContent = 0;

    document.querySelector("#rating_filters #between_end_rating").value = 10;
    document.querySelector("#rating_filters #between_end_value").textContent = 10;
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

    if (logged_in) {
	    //Create Favorite Movie Button
        let fav = document.createElement("input");
        fav.type = "button";
	    fav.classList.add("linkStyle");
        if (is_favorited(movie['id'])) {
            fav.value = "Favorited";
            fav.disabled = true;
        } else {
            fav.value = "Favorite";
            fav.addEventListener("click", e=> {
                favorite_movie(e, movie);
            });
        }
	    li.appendChild(fav);
    }
    
	let view = document.createElement("a");
    view.href = `single-movie.php?id=${movie.id}`;
	view.textContent = "View";
	li.appendChild(view);
	view.classList.add("linkStyle");
    
	element.appendChild(li);
	li.addEventListener("click", e => { window.location = view.href; });
}

/**
   Adds a movie to the user's favorites. If successful, set the button to "Unfavorite"
  */
function favorite_movie(e, movie) { 
	fetch(`api/favorite-movie.php?movie_id=${movie.id}&poster=${movie.poster}&title=${movie.title}`)
        .then(resp => {
            resp.text().then(body => {
                body = body.trim();
                if (body == "" || body == "Already favorited") {
                    e.target.value = "Favorited";
                    e.target.disabled = true;
                    console.log(`Favorited movie "${movie.title}"`);
                } else {
                    console.warn(`Failed to favorite movie "${movie.title}"`);
                    console.warn(body);
                }
            })
        })
	    .catch((err) => {
		    console.warn("Failed to favorite movie: "+err);
	    })
    
    e.stopPropagation();
}

/**
   Returns true if a movie is already favorited, false otherwise
*/
function is_favorited(movie_id) {
    for (movie of favorited_movies) {
        if (movie['id'] == movie_id) {
            return true;
        }
    }
    return false;
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
function switch_sort_mode(new_mode, event) {
    if (! sort_mode) {
        sort_mode = new_mode;
    } else {
        sort_mode = get_sort_mode(new_mode, sort_mode);
    }

    switch_sort_indicator(sort_mode);

    if (movies) {    
        filtered_movies = sort_movies(filtered_movies);
        populate_movies(filtered_movies);
    }
}

/**
   Handles moving the arrow (sort indicator) between headings when sort mode is switched.
  */
function switch_sort_indicator(sort_mode) {
    // Tried just feeding in the event as an argument to this function.
    // However event.target was changing in an unexpected way and I couldn't get it to work.
    // This is inefficient because the event Should have been giving the required elements.
    let title = document.querySelector("#search #matches #matches-header #title h2");
    let year = document.querySelector("#search #matches #matches-header #year h2");
    let rating = document.querySelector("#search #matches #matches-header #rating h2");

    title.textContent = "Title";
    year.textContent = "Year";
    rating.textContent = "Rating";
    
    if (sort_mode == SORT_MODES.ALPHA) {
        title.innerHTML = "Title "+down_arrow;
    } else if (sort_mode == SORT_MODES.REV_ALPHA) {
        title.innerHTML = "Title "+up_arrow;
    } else if (sort_mode == SORT_MODES.ASC_YEAR) {
        year.innerHTML = "Year "+down_arrow;
    } else if (sort_mode == SORT_MODES.DESC_YEAR) {
        year.innerHTML = "Year "+up_arrow;
    } else if (sort_mode == SORT_MODES.ASC_RATING) {
        rating.innerHTML = "Rating "+down_arrow;
    } else if (sort_mode == SORT_MODES.DESC_RATING) {
        rating.innerHTML = "Rating "+up_arrow;
    }
}

/**
   Sorts a given movie list using the global `sort_mode` variable.
  */
function sort_movies(movies) {
    if (sort_mode == SORT_MODES.ALPHA) {
        movies = sort_by_title(movies);
    } else if (sort_mode == SORT_MODES.REV_ALPHA) {
        movies = sort_by_title(movies).reverse();
    } else if (sort_mode == SORT_MODES.ASC_YEAR) {
        movies = sort_by_year(movies);
    } else if (sort_mode == SORT_MODES.DESC_YEAR) {
        movies = sort_by_year(movies).reverse();
    } else if (sort_mode == SORT_MODES.ASC_RATING) {
        movies = sort_by_rating(movies);
    } else if (sort_mode == SORT_MODES.DESC_RATING) {
        movies = sort_by_rating(movies).reverse();
    }

    return movies;
}

/**
   Sorts input list by .ratings.average in ascending order.
  */
function sort_by_rating(movies) {
    movies = movies.sort((a, b) => {
        if (a.ratings.average < b.ratings.average) {
            return -1;
        } else if (a.ratings.average > b.ratings.average) {
            return 1;
        } else {
            return 1;
        }
    });
    return movies;
}

/**
   Sorts the input list by the year of .release_date in ascending order.
  */
function sort_by_year(movies) {
    movies = movies.sort((a, b) => {
        a_year = parseInt(year_of(a.release_date));
        b_year = parseInt(year_of(b.release_date));

        if (a_year < b_year) {
            return -1;
        } else if (a_year > b_year) {
            return 1;
        } else {
            return 1;
        }
    });
    return movies;
}

/**
   Sorts the input list by the title in alphabetical order.
  */
function sort_by_title(movies) {
    movies = movies.sort((a, b) => {
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
