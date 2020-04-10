<?php
session_start();

if (isset($_SESSION['u_id'])) {
    if (isset($_SESSION['fav_movies'])) {
        echo json_encode(['favorites' => $_SESSION['fav_movies']]);
    } else {
        echo json_encode(['favorites' => []]);
    }
} else {
    echo "User not logged in";
}
