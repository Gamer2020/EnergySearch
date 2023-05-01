<?php
require_once('../config.php');
require_once('../../config.php');

require_once('../vendor/autoload.php');

use Pokemon\Pokemon;


function create_card_types_table()
{

    global $pdo;

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS es_card_types (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL
        )
    ");
}

function import_card_types()
{

    global $pdo;

    $types = Pokemon::Type()->all();

    // Select all card types from database
    $stmt_select = $pdo->prepare("SELECT name FROM es_card_types");
    $stmt_select->execute();
    $existing_types = $stmt_select->fetchAll(PDO::FETCH_COLUMN);

    // Insert new types into database using prepared statements
    $stmt_insert = $pdo->prepare("INSERT INTO es_card_types (name) VALUES (:name)");
    $new_types = array_diff($types, $existing_types);

    foreach ($new_types as $type) {
        $stmt_insert->bindParam(':name', $type);
        $stmt_insert->execute();
    }

    // Remove missing types from database using prepared statements
    $stmt_delete = $pdo->prepare("DELETE FROM es_card_types WHERE name = :name");
    $missing_types = array_diff($existing_types, $types);

    foreach ($missing_types as $type) {
        $stmt_delete->bindParam(':name', $type);
        $stmt_delete->execute();
    }

}

create_card_types_table();
import_card_types();