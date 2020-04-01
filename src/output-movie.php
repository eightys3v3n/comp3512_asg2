<?php

if (isset($_GET["id"]))
    {
        $m = getMovie((int)$_GET["id"]);
        $movie_id = $m["id"];
        
        $movie = getMovie($movie_id);
        
        $title = $movie["title"];
        $release_date = $movie["release_date"];
        $revenue = number_format($movie["revenue"]);
        $runtime = $movie["runtime"];
        $tagline = $movie["tagline"];
        $imdb_id = "https://imdb.com/title/" . $movie["imdb_id"];
        $tmdb_id = "https://www.themoviedb.org/movie/" . $movie["tmdb_id"];
        $popularity = $movie["popularity"];
        $vote_average = $movie["vote_average"];
        $ratings = $movie["vote_count"];
        $overview = $movie["overview"];
        $poster = $movie["poster_path"];
        $companies = $movie["production_companies"];
        $countries = $movie["production_countries"];
        $genres = $movie["genres"];
        $keywords = $movie["keywords"];
        $cast = $movie["cast"];
        $crew = $movie["crew"];
        
        echo '<section id="details">';
            echo '<input type="button" name="close" value="Close">';
            echo '<div id="info">';
                echo '<div id="text">';
                    echo '<h1>' . $title . '</h1>';
                    echo '<input type="button" value="Speak">';
                    echo '<div id="movie_stats">';
                        echo '<p>';
                            echo '<b>Release date: ' . $release_date . '</b> <div id="release_date"></div><br/>';
                            echo '<b>Revenue: $' . $revenue . '</b> <div id="revenue"></div><br/>';
                            echo '<b>Runtime: </b>' . $runtime . '<div id="runtime"></div> minutes<br/>';
                            echo '<b>Tagline: </b>' . $tagline . '<div id="tagline"></div><br/>';
                            echo '<b>Links:</b> <a href=' . $imdb_id . '>IMDB </a>' . '<a href=' . $tmdb_id . 'id="tmdb">TMDB</a><br/>';
                            echo '<b>Popularity: ' . $popularity . '</b> <div id="popularity"></div><br/>';
                            echo '<b>Average rating: ' . $vote_average . '</b> <div id="average_rating"></div><br/>';
                            echo '<b>Ratings: ' . $ratings . '</b> <div id="ratings"></div><br/>';
                            echo '<h2>Overview</h2>';
                            echo '<div id="overview">' . $overview . '</div>';
                        echo '</p>';
                    echo '</div>';
                echo '</div>';
    }

?>