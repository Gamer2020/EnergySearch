<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');

function create_Deck_Table()
{

    global $pdo;

    $sql = "CREATE TABLE IF NOT EXISTS es_decks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                deck_name VARCHAR(255) NOT NULL,
                cards TEXT NOT NULL,
                featuredcard VARCHAR(50) DEFAULT NULL,
                format_legality VARCHAR(10) DEFAULT NULL,
                views INT DEFAULT 0,
                monthly_views INT DEFAULT 0,
                upvotes INT DEFAULT 0,
                monthly_upvotes INT DEFAULT 0,
                visible TEXT NOT NULL,
                source_type TEXT NOT NULL,
                source_info TEXT NOT NULL,
                source_identifier TEXT NOT NULL
            )";

    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
    }
}

create_Deck_Table();