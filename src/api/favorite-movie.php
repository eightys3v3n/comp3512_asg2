<?php

session_start();
include '../db-helpers.inc.php';

if (isset($_SESSION["u_id"])) {
    if (isset($_GET["mov_id"])) {
        if (favoriteMovie($_SESSION["u_id"], $_GET["movie_id"])) {
            echo "success";
        } else {
            echo "failure";
        }
    } else {
        echo "Missing movie_id";
    }
} else {
    echo "User not logged in";
}


// if (isset($_SESSION["u_id"])) {
//     if (isset($_GET["movie_id"])) {
//         if (favoriteMovie($_SESSION["u_id"], $_GET["movie_id"])) {
//             echo "success";
//         } else {
//             echo "failure";
//         }
//     } else {
//         echo "Missing movie_id";
//     }
// } else {
//     echo "User not logged in";
// }

?>
