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

    return $statement;
}

/*
  Adds a movie_id to the current user's favorites.
 */
function favoriteMovie($movie_id)
{
    try
    {
        $conn = getDatabaseConnection();
        //$user_id = $_SESSION["u_id"];
        $user_id = 1;
        $sql = "INSERT INTO favorite (user_id, movie_id) VALUES ($user_id,$movie_id)";
        runQuery($conn,$sql,$movie_id);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = null;
}

/*
  Removes a movie_id from the current user's favorites.
 */
function unfavoriteMovie($movie_id)
{
    try
    {
        $conn = getDatabaseConnection();
        //$user_id = $_SESSION["u_id"];
        $user_id = 1;
        $sql = "DELETE FROM favorite WHERE user_id = $user_id AND movie_id = $movie_id";
        runQuery($conn,$sql,$movie_id);
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

    return $res;
}

?>




























