<?php
session_start();

if (isset($_SESSION['u_id']) && isset($_SESSION['fav_movies'])) {
    echo json_encode(['favorites' => $_SESSION['fav_movies']]);
} else {
    echo json_encode(['favorites' => []]);
}
