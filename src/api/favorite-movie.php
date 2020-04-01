<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"])) {
    if (isset($_GET["movie_id"])) {
        favoriteMovie($_SESSION["u_id"], $_GET["movie_id"]);
    }
} else {
    echo "User not logged in";
}

?>
