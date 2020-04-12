<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include '../db-helpers.inc.php';

if (isset($_SESSION['u_id'])) {
    if (isset($_SESSION['fav_movies']) && sizeof($_SESSION['fav_movies']) > 0) {
        $ids = $_SESSION['fav_movies'];
        $ids = array_map(fn($mov) => $mov['id'], $ids);
        
        $movies = getBriefMovies($ids);
        echo json_encode(['favorite_movies_brief' => $movies]);
    } else {
        echo json_encode(['favorite_movies_brief' => []]);
    }
} else {
    echo "User not logged in";
}
?>
