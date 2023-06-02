<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');

function create_site_vars_Table()
{

    global $pdo;

    $sql = "CREATE TABLE IF NOT EXISTS es_site_vars (
        var_name VARCHAR(255) NOT NULL PRIMARY KEY,
        var_value TEXT NOT NULL
    )";

    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
    }
}

function update_site_vars()
{
    global $pdo;

    $data = [
        ['total_card_views', '0'],
        ['total_deck_views', '0']
    ];

    $sql = "INSERT IGNORE INTO es_site_vars (var_name, var_value) VALUES (:var_name, :var_value)";

    $stmt = $pdo->prepare($sql);

    foreach ($data as $item) {
        $stmt->bindValue(':var_name', $item[0]);
        $stmt->bindValue(':var_value', $item[1]);

        $stmt->execute();
    }
}

create_site_vars_Table();
update_site_vars();