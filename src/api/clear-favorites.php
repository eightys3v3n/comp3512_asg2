<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"])) {
unset($_SESSION['fav_movies'])
}