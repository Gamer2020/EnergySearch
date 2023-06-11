<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');
require_once('../../include.php');

function update_Deck_Featured()
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

            $deck_featured_card = "";

            $firstinstanceflag = 1;

            $deck_list_decoded = json_decode($row['cards']);

            foreach ($deck_list_decoded->cards as $card)
            {

                if ($firstinstanceflag == 1)
                {

                    $deck_featured_card = get_card_id_by_ptcgl_set_num($card->set_code, $card->set_number);

                    if (!empty($deck_featured_card))
                    {
                        $firstinstanceflag = 0;
                    }

                }

                if (containsStringIgnoreCase($row['deck_name'], getFirstWord(removeNonSpeciesFromNameString($card->name))))
                {

                    $deck_featured_card = get_card_id_by_ptcgl_set_num($card->set_code, $card->set_number);

                    if (!empty($deck_featured_card))
                    {
                        break;
                    }

                }

            }

            if (!empty($deck_featured_card))
            {

                // Update entry
                $update_sql = "UPDATE es_decks SET featuredcard = :featuredcard WHERE id = :id";
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->execute([':featuredcard' => $deck_featured_card, ':id' => $id]);

            }
        }
    }
    catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

update_Deck_Featured();