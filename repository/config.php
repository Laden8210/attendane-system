<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u807574647_pcnl_db');
define('DB_PASSWORD', 'u807574647_pcnl_db');
define('DB_NAME', 'Pcnl_8210');


try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("ERROR: Could not connect. " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo $e;
}
