<?php
header('Content-Type: application/json; charset=utf-8');

include '../db-helpers.inc.php';

if (isset($_GET['id']) && $_GET['id'] != 'ALL') {
    $movies = getBriefMovies([$_GET['id']]);
    echo json_encode(['movie' => $movies]);
} else {
    $movies = getBriefMovies([]);
    echo json_encode(['movies' => $movies]);
}
?>
