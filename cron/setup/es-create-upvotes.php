<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');

function create_Upvote_Tables()
{

    global $pdo;

    $sql = "CREATE TABLE IF NOT EXISTS es_card_upvotes (
        card_id TEXT NOT NULL,
        ip_address TEXT NOT NULL
    )";

    try
    {
        $pdo->exec($sql);
    }
    catch (PDOException $e)
    {
    }

    $sql = "CREATE TABLE IF NOT EXISTS es_deck_upvotes (
        deck_id TEXT NOT NULL,
        ip_address TEXT NOT NULL
    )";

    try
    {
        $pdo->exec($sql);
    }
    catch (PDOException $e)
    {
    }
}


create_Upvote_Tables();