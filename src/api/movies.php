<?php
header('Content-Type: application/json; charset=utf-8');

include '../db-helpers.inc.php';

$movies = getMovies();
echo json_encode($movies);
?>
