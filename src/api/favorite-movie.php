<?php

session_start();
include '../db-helpers.inc.php';
// return exit(http_response_code(404));

if (isset($_SESSION["u_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_GET["movie_id"]) && isset($_GET["poster"]) && isset($_GET["title"])) {
        
        $mov_id = $_GET["movie_id"];
        $poster = $_GET["poster"];
        $title = $_GET["title"];
        $found = false;
        
        foreach($_SESSION['fav_movies'] as $movie){
                if($movie['id'] == $mov_id){
                    $found = true;
                }          
        }
        
        if (!$found) {
            $new_data  = array(
                "id" => $mov_id,
                "poster" => $poster,
                "title" => $title 
            );
            
            array_push($_SESSION['fav_movies'], $new_data); 
        } else {
            echo "Already favorited"; // don't change this string. It's used to check if a movie was favorited.
        }
    } else {
        echo "Malformed request, missing movie_id, poster, or title";
    }
} else {
    echo "User not logged in";
    // return json_encode(false);
    // what is this return for? There's no function here.
}
    
// This is terrence's new comment
    // and a second comment

?>


