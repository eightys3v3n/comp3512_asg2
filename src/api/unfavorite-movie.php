<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"]) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $movieId = $_GET["movie_id"];
    print_r($_SESSION['fav_movies']);
    print_r();

    $new_favs = [];
    foreach ($_SESSION['fav_movies'] as $movie) {
        if ($movie['id'] != $movieId) {
            array_push($new_favs, $movie);
        }
    }
    
    $_SESSION['fav_movies'] = $new_favs;
    print_r($_SESSION['fav_movies']);
}
