<?php

session_start();
include '../db-helpers.inc.php';
// return exit(http_response_code(404));

if (isset($_SESSION["u_id"])  && $_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_GET["movie_id"]) && isset($_GET["poster"]) && isset($_GET["title"])) {
        
        $mov_id = $_GET["movie_id"];
        $poster = $_GET["poster"];
        $title = $_GET["title"];
        if(!array_key_exists($mov_id, $_SESSION['fav_movies'])){
            $new_data  = array(
                "id" => $mov_id,
                "poster" => $poster,
                "title" => $title 
            );
            $_SESSION['fav_movies'][$mov_id] = $new_data; 

        }
    } else {
        echo "Missing movie_id";
    }
} else {
    echo "User not logged in";
    return json_encode(false);
}


?>
