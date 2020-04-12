<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"]) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $movieId = $_GET["movie_id"];
    
    $_SESSION['fav_movies'] = array_filter($_SESSION['fav_movies'],
                                           function($mov) use ($movieId) {
            if ($mov['id'] == $movieId) { return false; }
            else { return true; }
        });
}
?>
