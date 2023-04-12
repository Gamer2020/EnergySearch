<?php
// database hostname - you don't usually need to change this
define('db_host', 'localhost');
// database username
define('db_user', 'root');
// database password
define('db_pass', '');
// database name
define('db_name', 'energysearch');

global $pdo;

/* Attempt to connect to MySQL database */
try {
    $pdo = new PDO("mysql:host=" . db_host . ";dbname=" . db_name, db_user, db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

?>