[TOC]



# Elements

## Search

- Query text box
- Search button
- Also accepts enter to execute search

## Movie List

- Displays poster, title, year, and rating
- Can be sorted by title, year, rating by clicking the column heading. Sorts lexicographically on first click, then anti-lexicographically on the second click.
- Clicking on the poster or title links to the single-movie page
- Movies are sorted by title by default

## Poster List

- A list of movies
- Displays only the poster with the title below
- Clicking on either the poster or the title goes to the single-movie page.



## Movie Object

- Maybe we should make this an actual object?
- Then we could have it automatically construct the URLs and what not.

```javascript
{
	id:
	tmdb_id:
	imdb_id:
	release_date:
	title:
	runtime:
	revenue:
	tagline:
	poster:
	overview:
	ratings: {
		popularity:
		average:
		count:
	}	
}
```



## Filter Object

```javascript
new Filter(title, year_between, rating_between)
// year_between is [min_year, max_year] inclusive
// rating_between is [min_rating, max_rating] inclusive
// to not filter by something, make it undefined

new Filter(undefined, [2000, undefined], undefined)
// This will get all the movies made in 2000 and newer.
```





# APIs

## movies.php

- [ ] 



## db_helpers.php

- [ ] favorite_movie(id):
  - [ ] returns true if successful or movie was already favorited
  - [ ] returns false if there was some database error or something
- [ ] unfavorite_movie(id)
  - [ ] returns true if successful or movie was not favorited
  - [ ] returns false if there was some database error or something
- [ ] get_movies()
  - [ ] returns a list of all the movies see [Movie Object](#Movie-Object)
- [ ] get_filtered_movies(Filter)
  - [ ] returns a list of all the movies that match the given filter; see [Movie Object](#Movie-Object), [Filter Object](#Filter-Object)



# Pages

## login.php?last_page= ***Login***

- [ ] email text box
- [ ] password text box
- [ ] Login button:
  - [ ] Shows red error text if the password or email is wrong
  - [ ] Save a sessionID as a cookie
  - [ ] Otherwise redirects to `last_page`, or `index.php`
- [ ] Register button:
  - [ ] Redirects to `register.php`



## register.php ***Register***





## browse-movies.php ***Search***

- [ ] Extract search view from assignment 1
- [ ] Ensure that the search view is complete (I don't remember if I finished all the functionality):
  - [ ] All the filters work as expected
- [ ] Make the view button redirect to `single-movie.php?id=`
- [ ] Make the movie list sortable by different columns:
  - [ ] Sort alphabetical and reverse alphabetical by clicking title column header
  - [ ] Sort lex and anti-lex by year
  - [ ] Sort lex and anti-lex by rating
- [ ] ***Still checking whether this uses our movies API or accesses the database directly***
- [ ] Use event delegation for the movie list buttons



## single-movie.php ***Movie Details***

- [ ] Extract details view from assignment 1
- [ ] This needs to access the database, **not** use the API (says the guidelines)
- [ ] Remove Speak and Close button
- [ ] Complete Crew and Cast information
- [ ] "Add to Favorites" button next to view button:
  - [ ] Button changes to "Remove from Favorites" if movie is in favorites (also update when the button is pressed)
  - [ ] Could also just have an empty and full heart icon
  - [ ] When button is pressed, use JavaScript fetch to `favorite-movie.php?id=`
  - [ ] When button is unpressed, use JavaScript fetch to `unfavorite-movie.php?id=`



## favorites.php ***Favorites***

### When not logged in

- [ ] Display an error message about not being logged in

### When logged in

- [ ] Display favorites; see [Movie List element](#Movie List)
- [ ] Movies should be selectable with check boxes
- [ ] Select all button
- [ ] Remove from favorites button; removes all selected movies from favorites



## about.php ***About***

- [ ] Brief description of the website:
  - [ ] "Web II"
  - [ ] "Mount Royal University"
  - [ ] professor name
  - [ ] "Winter 2020"
  - [ ] technologies used
- [ ] Names and Github links for all group members



## index.php ***Home***

### When not logged in

- [ ] Login button
- [ ] Register button
- [ ] Search box
- [ ] Search submit button

### When logged in

- [ ] User info: country, city, email, first/last name...
- [ ] Search box & search submit button see [Search element](#Search)
- [ ] Favorite movies list; see [Poster List element](#Poster-List)
- [ ] Recommendations list; see [Poster List element](#Poster-List)