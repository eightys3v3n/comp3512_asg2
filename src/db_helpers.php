<?php
require_once 'secret.php';


function getDatabaseConnection() {
    /// This returns a connection to the database. Make sure to set to null when finished.
    try {
        $pdo = new PDO(SQL_URL, SQL_USER, SQL_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
	}

    return $pdo;
}


// From https://www.youtube.com/watch?v=mcvshAEUeH4
// Randy's Web II video
function runQuery($db, $sql, $data=array()) {
    /// Takes a db as returned from getDatabase(), an SQL string, and an array (or not) of data.
    /// $res = runQuery($db, "SELECT * FROM users", undefined);
    if (!is_array($data)) {
        $data = array($data);
    }

    $statement = null;
    if (count($data) > 0) {
        $statement = $db->prepare($sql);
        $execOk = $statement->execute($data);
        if (!$execOk) {
            throw new PDOException;
        }
    } else {
        $statement = $db->query($sql);
        if (!$statement) {
            throw new PDOException;
        }
    }

    return $statement;
}


function favoriteMovie($movie_id)
{
    try
    {
        $conn = getDatabaseConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user_id = $_SESSION["u_id"];
        $sql = "INSERT INTO favorite (user_id, movie_id) VALUES ($user_id,$movie_id)";
        $conn->exec($sql);
        echo "Movie has been added to favorites";
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = null;
}


function unfavoriteMovie($movie_id)
{
    try
    {
        $conn = getDatabaseConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user_id = $_SESSION["u_id"];
        $sql = "DELETE FROM favorite WHERE user_id = $user_id AND movie_id = $movie_id";
        $conn->exec($sql);
        echo "Movie has been removed from favorites";
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = null;
}


function getFavoriteMovies()
{
    try
    {
        $conn = getDatabaseConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user_id = $_SESSION["u_id"];
        $sql = $conn->prepare("SELECT movie_id FROM favorites WHERE user_id = $user_id");
        $sql->execute();
        
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = null;
    
    return $result;
}

?>




























