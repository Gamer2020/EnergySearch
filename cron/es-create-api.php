<?php
require_once('config.php');
require_once('../config.php');

function create_api_token_Table()
{

    global $pdo;

    $sql = "CREATE TABLE IF NOT EXISTS es_api_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        token_name VARCHAR(255) NOT NULL,
        token_value VARCHAR(255) NOT NULL UNIQUE
    )";

    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
    }
}

create_api_token_Table();