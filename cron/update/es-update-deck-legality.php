<?php
require_once('../config.php');
require_once('../../config.php');
require_once('../../include.php');

function update_Deck_Legality()
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
            $id = $row['id'];

            $deckLegalityArrary = ptcglDeckListJsonLegalCheck($row['cards']);

            if ($deckLegalityArrary['standard_legality'] == "Legal")
            {
                $format_legality = "standard";
            }
            else
            {
                if ($deckLegalityArrary['expanded_legality'] == "Legal")
                {
                    $format_legality = "expanded";
                }
                else
                {
                    $format_legality = "unlimited";
                }
            }


            // Update entry
            $update_sql = "UPDATE es_decks SET format_legality = :format_legality WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([':format_legality' => $format_legality, ':id' => $id]);
        }
    }
    catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

update_Deck_Legality();