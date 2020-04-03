<?php
header('Content-Type: application/json; charset=utf-8');

include '../db-helpers.inc.php';

if (isset($_GET['id']) && $_GET['id'] != 'ALL') {
    $movies = getBriefMovies($_GET['id']);
} else {
    $movies = getBriefMovies('ALL');
}

// print_r($movies[0]);

echo json_encode($movies);
?>
