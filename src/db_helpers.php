<?php
require_once 'secret.php';


function getDatabase() {
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
?>
