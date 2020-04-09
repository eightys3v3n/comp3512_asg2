<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"]) && $_SERVER['REQUEST_METHOD'] == "GET") {
    // echo json_encode({'a' => 1});
    // echo "heyeyeyey";
    $movieId = $_GET["movie_id"];
    echo $movieId;
}

?>