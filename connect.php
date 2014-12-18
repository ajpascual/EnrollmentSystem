<?php



/* Database config */

$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= '';
$db_database	= 'dbHR';

/* End config */

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_user, $db_pass);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }

?>