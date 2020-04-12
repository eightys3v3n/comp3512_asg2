document.addEventListener("DOMContentLoaded", main);

// MAIN STUFF - Variables
const poster_url = "https://image.tmdb.org/t/p/";
const up_arrow = "&#8679;";
const down_arrow = "&#8681;";
let movies;

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
    // Expects an event as second argument. So we fake an event.
    switch_sort_mode(SORT_MODES.ALPHA, {'target': document.querySelector("#search #matches #list-header #title")});

    get_movies(); // get all the movies and favorited movies and populate `movies` and `favorited_movies`

    // unfavorite all movies
    document.querySelector("#favorites #list-header #unfavorite-all")
        .addEventListener("click", e => {
            unfavorite_all(e);
        });
    
    // change the sort mode when a heading title is clicked
    document.querySelector("#favorites #list-header #title")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ALPHA, e);
        });
    document.querySelector("#favorites #list-header #year")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ASC_YEAR, e);
        });
    document.querySelector("#favorites #list-header #rating")
        .addEventListener("click", e => {
            switch_sort_mode(SORT_MODES.ASC_RATING, e);
        });
}

/**
   Tries to populate the `movies` global variable using local storage, or the `api_url`.
   Also populated `filtered_movies` with a sorted version of `movies`.
  */
function get_movies() {
    console.log("Downloading favorites...");
    fetch('api/favorites-brief.php')
        .then(resp => resp.json())
        .then(data => {
            movies = data['favorite_movies_brief'];
            console.log("Retrieved all initialization data");
            display_movies();
        });
}

/**
   Shows a loading image/text and hides the movies list.
  */
function show_loading() {
    // display the loading stuff
	document.querySelector("#favorites #matches #loading").style.display = "block";
    document.querySelector("#favorites #matches ul").style.display = "none";
}

/**
   Hides the loading image/text and shows the movie list.
  */
function hide_loading() {
	document.querySelector("#favorites #matches #loading").style.display = "none";
    document.querySelector("#favorites #matches ul").style.display = "block";
}

function is_favorited(movie_id) {
    for (movie of movies) {
        if (movie['id'] == movie_id) {
            return true;
        }
    }
    return false;
}

/**
   Removes a movie from favorites and removes it from the DOM
  */

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
    if (! movies) {
        console.warn("Tried to display movies before they were fetched");
    } else {
        sorted_movies = sort_movies(movies);
        populate_movies(sorted_movies);
    
        hide_loading();
    }
}

/**
   Adds all the given movies to the CSS:`#favorites #matches #ul` element.
   Also shows a "No Matches" element if no movies are given, or hides
   the "No Matches" element if movies are given.
  */
function populate_movies(movies_list) {        
	let matches = document.querySelector("#favorites #matches ul");

	matches.innerHTML = "";

	if (movies_list.length === 0) {
		document.querySelector("#favorites #matches #no_favorites").style.display = "block";
	} else {
		document.querySelector("#favorites #matches #no_favorites").style.display = "none";
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
    let fav = document.createElement("input");
    fav.type = "button";
	fav.classList.add("linkStyle");
    if (is_favorited(movie['id'])) {
        fav.value = "Unfavorite";
        fav.addEventListener("click", e=> {
            unfavorite_movie(e, movie);
        });
    } else {
        fav.value = "Unfavorited";
        fav.disabled = true;        
    }
	li.appendChild(fav);
    
	let view = document.createElement("a");
    view.href = `single-movie.php?id=${movie.id}`;
	view.textContent = "View";
	li.appendChild(view);
	view.classList.add("linkStyle");
    
	element.appendChild(li);
	li.addEventListener("click", e => { window.location = view.href; });
}

function unfavorite_movie(e, movie) {
    fetch(`api/unfavorite-movie.php?movie_id=${movie.id}`)
        .then(resp => {
            e.target.value = "Unfavorited";
            e.target.disabled = true;
        });

    if (e) {
        e.stopPropagation();
    }
}

function unfavorite_all(e) {
    let buttons = document.querySelectorAll("#favorites ul li input[value='Unfavorite']");

    for (let button of buttons) {
        button.click();
    }
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
        sorted_movies = sort_movies(movies);
        populate_movies(sorted_movies);
    }
}

/**
   Handles moving the arrow (sort indicator) between headings when sort mode is switched.
  */
function switch_sort_indicator(sort_mode) {
    // Tried just feeding in the event as an argument to this function.
    // However event.target was changing in an unexpected way and I couldn't get it to work.
    // This is inefficient because the event Should have been giving the required elements.
    let title = document.querySelector("#favorites #matches #list-header #title h2");
    let year = document.querySelector("#favorites #matches #list-header #year h2");
    let rating = document.querySelector("#favorites #matches #list-header #rating h2");

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
