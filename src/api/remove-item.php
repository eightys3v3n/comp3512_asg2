<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
    
}