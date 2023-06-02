<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');

require_once('../vendor/autoload.php');

use Pokemon\Pokemon;


function create_card_rarities_table()
{

    global $pdo;

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS es_card_rarities (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL
        )
    ");
}

function import_card_rarities()
{

    global $pdo;

    $rarities = Pokemon::Rarity()->all();

    // Select all card rarities from database
    $stmt_select = $pdo->prepare("SELECT name FROM es_card_rarities");
    $stmt_select->execute();
    $existing_rarities = $stmt_select->fetchAll(PDO::FETCH_COLUMN);

    // Insert new rarities into database using prepared statements
    $stmt_insert = $pdo->prepare("INSERT INTO es_card_rarities (name) VALUES (:name)");
    $new_rarities = array_diff($rarities, $existing_rarities);

    foreach ($new_rarities as $rarity) {
        $stmt_insert->bindParam(':name', $rarity);
        $stmt_insert->execute();
    }

    // Remove missing rarities from database using prepared statements
    $stmt_delete = $pdo->prepare("DELETE FROM es_card_rarities WHERE name = :name");
    $missing_rarities = array_diff($existing_rarities, $rarities);

    foreach ($missing_rarities as $rarity) {
        $stmt_delete->bindParam(':name', $rarity);
        $stmt_delete->execute();
    }

}

create_card_rarities_table();
import_card_rarities();