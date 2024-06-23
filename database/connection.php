<?php

include("config.php");

$GLOBALS["config"] = $config;

//funkcja do nawiązania połączenia z bazą danych
function connect_to_db($config)
{
    $conn = new mysqli($config['server'], $config['login'], $config['password'], $config['database'],$config['port']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

//connect_to_db($config);

?>