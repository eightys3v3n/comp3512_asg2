<?php
require_once 'secret.php';

/*
  This function returns a connection object to a database.
 */
function getDatabaseConnection() {
    try {
        $pdo = new PDO(SQL_URL, SQL_USER, SQL_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
	}

    return $pdo;
}

/*
  This function runs the specified SQL query using the passed connection and the passed array of parameters (null or undefined if none)

  From https://www.youtube.com/watch?v=mcvshAEUeH4
  Randy's Web II video
*/
function runQuery($db, $sql, $data=array()) {
    // Ensure parameters are in an array
    if (!is_array($data)) {
        $data = array($data);
    }

    $statement = null;

    try {
        if (count($data) > 0) {
            // Use a prepared statement of parameters
            $statement = $db->prepare($sql);
            $execOk = $statement->execute($data);
            if (!$execOk) {
                throw new PDOException;
            }
        } else {
            // Execute a normal query without parameters
            $statement = $db->query($sql);
            if (!$statement) {
                throw new PDOException;
            }
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    return $statement;
}

/*
  Attemps to add user on Sign up form submit.

  Returns false if email is already registered.
  Returns true if registration is successful.
 */
function registerUser($fName, $lName, $city, $country, $email, $password){
    // SEE THIS LINK for how to do this. Terrence chose to use password_hash instead of a manual hash function.
    // https://www.sitepoint.com/hashing-passwords-php-5-5-password-hashing-api/

    $fName = ucfirst(strtolower($fName));
    $lName = ucfirst(strtolower($lName));
    $city = ucfirst(strtolower($city));
    $country = ucfirst(strtolower($country));
    $email = strtolower($email);
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
    
    try{
        $conn = getDatabaseConnection();
        $res = runQuery($conn,
                        "SELECT COUNT(*) FROM user WHERE email=?",
                        $email);
        if ($res->fetch()[0] > 0) {
            return false; // email already in use
        }

        $res = runQuery($conn,
                        "INSERT INTO user(firstname, lastname, city, country, email, password) VALUES(?, ?, ?, ?, ?, ?)",
                        [$fName, $lName, $city, $country, $email, $pass_hash]);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

    return true;
}

/*
  Tries to log user in.

  Returns true if password and email was correct.
  Returns false if password or email was incorrect.
*/
function login($email, $password) {
    $email = strtolower($email);

    // Get the PHP password hash+salt
    $conn = getDatabaseConnection();
    $res = runQuery($conn, "SELECT id, password FROM user WHERE email=?", $email);
    if ($res->rowCount() == 0) {
        return false;
    }
    
    [$u_id, $corr_password] = $res->fetch();
    $conn = null;
    
    // check if the password is the correct password.
    if (password_verify($password, $corr_password)) {
        $_SESSION['fav_movies'] = array();
        $_SESSION['u_id'] = $u_id;
        return true;
    } else {
        return false;
    }
}

/*
  Gets the user information in an associative array
 */
function getUserInfo($user_id) {
    $conn = getDatabaseConnection();
    $res = runQuery($conn, "SELECT * FROM user WHERE id=?", $user_id);
        
    $user_info = $res->fetch();

    // remove secret fields that should never be used
    unset($user_info['password']);
    unset($user_info[6]);
    unset($user_info['password_sha256']);
    unset($user_info[7]);
    unset($user_info['salt']);
    unset($user_info[8]);

    return $user_info;
}

/*
  Adds a movie_id to the current user's favorites.
 */
function favoriteMovie($user_id, $movie_list)
{
    try
    {    
        $conn = getDatabaseConnection();
        $sql = "SELECT * FROM movie WHERE id IN ($movie_list)";
        $result = runQuery($conn, $sql);
        return $result->fetchAll();
        $conn = null;
    }
    catch(PDOException $e)
    {
        $conn = null;
        print_r($e);
        return false;
    }

    
    return true;
}

/*
  Removes a movie_id from the current user's favorites.
  Update April 4: changing from a db query to array splice of "fav_movies" 
 */
function unfavoriteMovie($movie_id)
{
    try
    {

    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = null;
}

/*
  This fuction returns a list of a users favorite movies in the form of movie_ids
 */
function getFavoriteMovies()
{
    try
    {
        $conn = getDatabaseConnection();
        //$user_id = $_SESSION["u_id"];
        $user_id = 1;
        $sql = "SELECT movie_id FROM favorite WHERE user_id =?";
        $result = runQuery($conn,$sql,$user_id);
        $result = $result->fetchAll();
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = null;
    
    return $result;
}

/*
  Get all the information on a movie from the database.
  Returns an associative array or null.
 */
function getMovie($movie_id) {
    try {
        $conn = getDatabaseConnection();
        $sql = "SELECT * FROM movie WHERE id=?";
        $res = runQuery($conn, $sql, $movie_id);
        if ($res->rowCount() == 0) {
            $res = null;
        } else {
            $res = $res->fetch();
        }
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $res['production_companies'] = json_decode($res['production_companies'], true);
    $res['production_countries'] = json_decode($res['production_countries'], true);
    $res['crew'] = json_decode($res['crew'], true);
    $res['genres'] = json_decode($res['genres'], true);
    $res['keywords'] = json_decode($res['keywords'], true);
    $res['cast'] = json_decode($res['cast'], true);

    return $res;
}

/*
  Get all the movies in the database and their information.
 */
// function getMovies() {
    // $movies = [];
    
    // try {
        // $conn = getDatabaseConnection();
        // $sql = "SELECT * FROM movie";
        // $res = runQuery($conn, $sql);
        // $movies = $res->fetchAll();
    // } catch (PDOException $e) {
        // echo $sql."<br>".$e->getMessage();
    // }

    // return $movies;
// }

/*
  Get all the movies in the database but without the companies, countries, keywords, genres, cast, and crew.
*/
function getBriefMovies($id) {
    $movies = [];

    try {
        $conn = getDatabaseConnection();

        if (isset($id) && $id != 'ALL') {
            $res = runQuery($conn, "SELECT * FROM movie WHERE id=?", $id);
        } else {
            $res = runQuery($conn, "SELECT * FROM movie");
        }

        foreach ($res as $movie) {
            foreach ($movie as $k=>$v) {
                if (is_integer($k)) {
                    unset($movie[$k]);
                }
            }

            $movie['id'] = (int)$movie['id'];
            $movie['tmdb_id'] = (int)$movie['tmdb_id'];
            $movie['runtime'] = (int)$movie['runtime'];
            $movie['revenue'] = (int)$movie['revenue'];
            
            unset($movie['production_companies']);
            unset($movie['production_countries']);
            unset($movie['genres']);
            unset($movie['keywords']);
            unset($movie['cast']);
            unset($movie['crew']);

            $movie['ratings'] = [
                'average' => (float)$movie['vote_average'],
                'count' => (int)$movie['vote_count'],
                'popularity' => (float)$movie['popularity']
            ];
            unset($movie['vote_average']);
            unset($movie['vote_count']);
            unset($movie['popularity']);

            $movie['poster'] = $movie['poster_path'];
            unset($movie['poster_path']);

            array_push($movies, $movie);
        }
    } catch (PDOException $e) {
        die($e->getMessage);
    }

    if (isset($id) && $id != 'ALL') {
        $movies = $movies[0];
    }
    
    return $movies;
}
?>




























