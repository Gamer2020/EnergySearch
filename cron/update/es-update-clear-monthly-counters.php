<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');
require_once('../../include.php');


function clear_monthly_decks()
{
    global $pdo;

    // Query to get all entries from the table
    $sql = "SELECT * FROM es_decks";
    try
    {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Fetch all rows
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Examine each entry and update accordingly
        foreach ($rows as $row)
        {
            // Perform your logic here
            // This example will increment 'views' by 1
            $id = $row['id'];
            $default = 0;

            // Update entry
            $update_sql = "UPDATE es_decks SET monthly_views = :views WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([':views' => $default, ':id' => $id]);

            // Update entry
            $update_sql = "UPDATE es_decks SET monthly_upvotes = :votes WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([':votes' => $default, ':id' => $id]);
        }
    }
    catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}


function clear_monthly_cards()
{
    global $pdo;

    // Query to get all entries from the table
    $sql = "SELECT * FROM es_cards";
    try
    {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Fetch all rows
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Examine each entry and update accordingly
        foreach ($rows as $row)
        {
            // Perform your logic here
            // This example will increment 'views' by 1
            $id = $row['id'];
            $default = 0;

            // Update entry
            $update_sql = "UPDATE es_cards SET monthly_views = :views WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([':views' => $default, ':id' => $id]);

            // Update entry
            $update_sql = "UPDATE es_cards SET monthly_upvotes = :votes WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([':votes' => $default, ':id' => $id]);
        }
    }
    catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

clear_monthly_decks();
clear_monthly_cards();

?>