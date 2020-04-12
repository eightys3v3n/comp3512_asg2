<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"]) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $movieId = $_GET["movie_id"];
    $index = findMovie($movieId);
    echo $index;
    print_r($_SESSION["fav_movies"][$index]);
    isset($_SESSION["fav_movies"][$index]) ? unset($_SESSION["fav_movies"][$index]) : die('Not there');
}
function findMovie($mov_id){
    $x = 0;
    foreach($_SESSION["fav_movies"] as $key => $value) {
        if ($value['id'] == $mov_id){
            return (int)$x;
        };
        ++$x;
    }
}


?>