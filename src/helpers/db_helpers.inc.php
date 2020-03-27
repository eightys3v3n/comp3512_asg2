<?php
/*
  This function returns a connection object to a database
*/
function setConnectionInfo($connString,$user,$password)
{
    $pdo = new PDO($connString,$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;      
}

/*
  This function runs the specified SQL query using the 
  passed connection and the passed array of parameters (null if none)
*/
function runQuery($connection, $sql, $parameters=array())
{
    // Ensure parameters are in an array
    if (!is_array($parameters))
    {
        $parameters = array($parameters);
    }

    $statement = null;
    if (count($parameters) > 0)
    {
        // Use a prepared statement of parameters 
        $statement = $connection->prepare($sql);
        $executedOk = $statement->execute($parameters);
        if (! $executedOk)
        {
            throw new PDOException;
        }
    }
    else
    {
        // Execute a normal query     
        $statement = $connection->query($sql); 
        if (!$statement)
        {
            throw new PDOException;
        }
    }
    return $statement;
}  

?>
