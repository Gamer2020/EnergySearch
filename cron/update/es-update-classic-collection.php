<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');

function create_classic_collection_cards_table()
{
    global $pdo;

    $sql = "CREATE TABLE IF NOT EXISTS es_classic_collection_cards (
            id VARCHAR(50) PRIMARY KEY,
            name VARCHAR(255) DEFAULT NULL,
            set_id VARCHAR(50) DEFAULT NULL,
            set_number TEXT DEFAULT NULL
          )";

    $pdo->exec($sql);
}

function insert_classic_collection_cards()
{
    global $pdo;

    $data = [
        ['cel25c-2_A', 'Blastoise', 'CEL-CC', '1'],
        ['cel25c-4_A', 'Charizard', 'CEL-CC', '2'],
        ['cel25c-8_A', 'Dark Gyarados', 'CEL-CC', '5'],
        ['cel25c-9_A', 'Team Magma\'s Groudon', 'CEL-CC', '11'],
        ['cel25c-15_A1', 'Venusaur', 'CEL-CC', '3'],
        ['cel25c-15_A3', 'Rocket\'s Zapdos', 'CEL-CC', '7'],
        ['cel25c-15_A4', 'Claydol', 'CEL-CC', '16'],
        ['cel25c-17_A', 'Umbreon ☆', 'CEL-CC', '15'],
        ['cel25c-20_A', 'Cleffa', 'CEL-CC', '9'],
        ['cel25c-24_A', '_____\'s Pikachu', 'CEL-CC', '8'],
        ['cel25c-54_A', 'Mewtwo-EX', 'CEL-CC', '22'],
        ['cel25c-60_A', 'Tapu Lele-GX', 'CEL-CC', '25'],
        ['cel25c-66_A', 'Shining Magikarp', 'CEL-CC', '10'],
        ['cel25c-76_A', 'M Rayquaza-EX', 'CEL-CC', '24'],
        ['cel25c-88_A', 'Mew ex', 'CEL-CC', '13'],
        ['cel25c-93_A', 'Gardevoir ex', 'CEL-CC', '14'],
        ['cel25c-97_A', 'Xerneas-EX', 'CEL-CC', '23'],
        ['cel25c-107_A', 'Donphan', 'CEL-CC', '19'],
        ['cel25c-109_A', 'Luxray GL', 'CEL-CC', '17'],
        ['cel25c-113_A', 'Reshiram', 'CEL-CC', '20'],
        ['cel25c-114_A', 'Zekrom', 'CEL-CC', '21'],
        ['cel25c-145_A', 'Garchomp C', 'CEL-CC', '18'],
        ['cel25c-15_A2', 'Here Comes Team Rocket!', 'CEL-CC', '6'],
        ['cel25c-73_A', 'Imposter Professor Oak', 'CEL-CC', '4'],
        ['cel25c-86_A', 'Rocket\'s Admin.', 'CEL-CC', '12']
    ];

    $sql = "INSERT INTO es_classic_collection_cards (id, name, set_id, set_number) VALUES (:id, :name, :set_id, :set_number)
            ON DUPLICATE KEY UPDATE
            name = :name,
            set_id = :set_id,
            set_number = :set_number";

    $stmt = $pdo->prepare($sql);

    foreach ($data as $item) {
        $stmt->bindValue(':id', $item[0]);
        $stmt->bindValue(':name', $item[1]);
        $stmt->bindValue(':set_id', $item[2]);
        $stmt->bindValue(':set_number', $item[3]);

        $stmt->execute();
    }
}


create_classic_collection_cards_table();
insert_classic_collection_cards();