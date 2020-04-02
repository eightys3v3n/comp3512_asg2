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
        $poster = "https://image.tmdb.org/t/p/w342/" . $movie["poster_path"];
        $companies = $movie["production_companies"];
        $countries = $movie["production_countries"];
        $genres = $movie["genres"];
        $keywords = $movie["keywords"];
        $cast = $movie["cast"];
        $crew = $movie["crew"];
        
        function printCompanies($companies)
        {
            foreach ($companies as $company)
            {
                echo $company["name"];
                echo '<br>';
            }
        }
    
        function printCountries($countries)
        {
            foreach ($countries as $country)
            {
                echo $country["name"];
                echo '<br>';
            }
        }
    
        function printKeywords($keywords)
        {
            foreach ($keywords as $keyword)
            {
                echo $keyword["name"];
                echo '<br>';
            }
        }
    
        function printGenres($genres)
        {
            foreach ($genres as $genre)
            {
                echo $genre["name"];
                echo '<br>';
            }
        }
    
        function printCast($cast)
        {
            foreach ($cast as $c)
            {
                echo '<p>Character: ' . $c["character"] . '</p>';
                echo '<p>Name: ' . $c["name"] . '</p>';
            }
        }
    
        function printCrew($crew)
        {
            foreach ($crew as $c)
            {
                echo '<p>Department: ' . $c["department"] . '</p>';
                echo '<p>Job: ' . $c["job"] . '</p>';
                echo '<p>Name: ' . $c["name"] . '</p>';
            }
        }
    
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
                echo '<div id="companies" class="border">';
                    echo '<h2>Companies</h2>';
                    echo '<p>' . printCompanies($companies) . '</p>';
                echo '</div>';
                echo '<div id="countries" class="border">';
                    echo '<h2>Countries</h2>';
                    echo '<p>' . printCountries($countries) . '</p>';
                echo '</div>';
                echo '<div id="keywords" class="border">';
                    echo '<h2>Keywords</h2>';
                    echo '<p>' . printKeywords($keywords) . '</p>';
                echo '</div>';
                echo '<div id="genres" class="border">';
                    echo '<h2>Genres</h2>';
                    echo '<p>' . printGenres($genres) . '</p>';
                echo '</div>';
            echo '</div>';
            echo '<div id="images">';
                echo '<img src=' . $poster . '>';
            echo '</div>';
            echo '<div>';
                echo '<div id="cast-crew-buttons">';
                    echo '<input type="button" value="Cast" class="active">';
                    echo '<input type="button" value="Crew" class="hidden">';
                echo '</div>';
                echo '<div id="castcrew">';
                    echo '<div id="cast">';
                    printCast($cast);
                    echo '</div>';
                echo '<div id="crew">';
                printCrew($crew);
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</section>';    
    
    }

?>




























