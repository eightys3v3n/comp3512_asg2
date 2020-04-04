<?php

session_start();
include '../db-helpers.inc.php';
// return exit(http_response_code(404));

if (isset($_SESSION["u_id"])) {
    if (isset($_GET["movie_id"])) {
        $mov_id = $_GET["movie_id"];
        return json_encode(array_push($_SESSION['fav_movies'], $mov_id));
         
        // if (favoriteMovie($_SESSION["u_id"], $_GET["movie_id"])) {
        //     echo "success";
        // } else {
        //     echo "failure";
        // }
    } else {
        echo "Missing movie_id";
    }
} else {
    echo "User not logged in";
    return json_encode(false);
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
