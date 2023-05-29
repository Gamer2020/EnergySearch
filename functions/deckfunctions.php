<?php

function deck_exists($deck_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_decks WHERE id = ?");
    $stmt->execute([$deck_id]);

    $count = $stmt->fetchColumn();

    return $count > 0;
}

function deck_is_visible($deck_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE id = ?");
    $stmt->execute([$deck_id]);

    $deck = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($deck['visible'] === 'YES')
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function get_deck_votes_by_id($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT upvotes FROM es_decks WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $result = $stmt->fetch();
    return $result['upvotes'];
}

function get_deck_views_by_id($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT views FROM es_decks WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $result = $stmt->fetch();
    return $result['views'];
}

function check_deck_voted_by_id($id)
{
    global $pdo;

    $ip_address = get_user_ip();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_deck_upvotes WHERE deck_id = :id AND ip_address = :ip");
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":ip", $ip_address);
    $stmt->execute();

    $count = $stmt->fetchColumn();

    return $count > 0;
}

function addDeckVote($deckId, $ipAddress)
{
    global $pdo;

    $sql = "INSERT INTO es_deck_upvotes (deck_id, ip_address) VALUES (:deckId, :ipAddress)";

    try
    {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':deckId', $deckId, PDO::PARAM_STR);
        $stmt->bindParam(':ipAddress', $ipAddress, PDO::PARAM_STR);
        $stmt->execute();
    }
    catch (PDOException $e)
    {
        // Handle the exception or log the error
        echo "Error: " . $e->getMessage();
    }
}

function removeDeckVote($deckId, $ipAddress)
{
    global $pdo;

    $sql = "DELETE FROM es_deck_upvotes WHERE deck_id = :deckId AND ip_address = :ipAddress";

    try
    {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':deckId', $deckId, PDO::PARAM_STR);
        $stmt->bindParam(':ipAddress', $ipAddress, PDO::PARAM_STR);
        $stmt->execute();
    }
    catch (PDOException $e)
    {
        // Handle the exception or log the error
        echo "Error: " . $e->getMessage();
    }
}

function deck_add_vote($deck_id)
{
    global $pdo;

    // Update the views column
    $sql = "UPDATE es_decks SET upvotes = upvotes + 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deck_id]);

    // Update the monthly_views column
    $sql = "UPDATE es_decks SET monthly_upvotes = monthly_upvotes + 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deck_id]);

}

function deck_remove_vote($deck_id)
{
    global $pdo;

    // Update the views column
    $sql = "UPDATE es_decks SET upvotes = upvotes - 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deck_id]);

    // Update the monthly_views column
    $sql = "UPDATE es_decks SET monthly_upvotes = monthly_upvotes - 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deck_id]);

}

function deck_add_view($deck_id)
{
    global $pdo;

    // Update the views column
    $sql = "UPDATE es_decks SET views = views + 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deck_id]);

    // Update the monthly_views column
    $sql = "UPDATE es_decks SET monthly_views = monthly_views + 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$deck_id]);

    increment_total_deck_views();
}

function increment_total_deck_views()
{
    global $pdo;

    $sql = "UPDATE es_site_vars SET var_value = var_value + 1 WHERE var_name = 'total_deck_views'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

function get_featuredcard_from_id($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT featuredcard FROM es_decks WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result)
    {
        // Deck not found
        return null;
    }

    return $result['featuredcard'];
}

function ptcglDeckListToJson($decklist)
{
    $lines = explode("\n", $decklist);
    $json_data = [
        "cards" => [],
    ];

    foreach ($lines as $line)
    {
        $line = trim($line);

        if ($line)
        {
            $parts = explode(' ', $line);

            if (empty($parts))
            {
                continue;
            }

            $quantity = array_shift($parts);

            if (!is_numeric($quantity))
            {
                continue;
            }


            $set_number = array_pop($parts);

            $max_iterations = 10; // set a limit for iterations
            $iterations = 0;

            while (!is_numeric($set_number) && !empty($parts) && $iterations < $max_iterations)
            {
                array_unshift($parts, $set_number);
                $set_number = array_pop($parts);
                $iterations++;
            }


            if (!is_numeric($set_number))
            {
                //continue;

                $card_name = $set_number;
                $set_code = get_PTCGL_set_by_card_name($card_name);
                $set_number = get_PTCGL_num_by_card_name($card_name);

            }else{
                $set_code = array_pop($parts);
                $card_name = implode(' ', $parts);
            }


            if (empty($set_code)) {
                continue;
            }

            if (empty($set_number)) {
                continue;
            }

            if (card_exists_by_ptcgl(strtoupper($set_code), $set_number))
            {
                $card_name = get_card_name_by_ptcgl(strtoupper($set_code), $set_number);
            }

            $card_data = [
                "quantity" => $quantity,
                "name" => $card_name,
                "set_code" => strtoupper($set_code),
                "set_number" => $set_number,
            ];

            $json_data["cards"][] = $card_data;
        }
    }

    sanitizeArray($json_data);

    return json_encode($json_data, JSON_PRETTY_PRINT);
}

function ptcglDeckListJsonLegalCheck($decklist_JSON)
{

    $legalityArrary = array(
        'standard_legality' => 'Legal',
        'expanded_legality' => 'Legal',
        'unlimited_legality' => 'Legal'
    );

    $deck_list_decoded = json_decode($decklist_JSON);

    foreach ($deck_list_decoded->cards as $card)
    {

        if (card_exists_by_ptcgl($card->set_code, $card->set_number))
        {

            global $pdo;

            $stmt = $pdo->prepare("SELECT * FROM es_cards WHERE PTCGL_set_id = :set_id AND PTCGL_set_number = :set_number");
            $stmt->bindParam(":set_id", $card->set_code);
            $stmt->bindParam(":set_number", $card->set_number);
            $stmt->execute();

            $result = $stmt->fetch();

            if ($result['standard_legality'] != "Legal")
            {
                $legalityArrary['standard_legality'] = 'Not Legal';
            }

            if ($result['expanded_legality'] != "Legal")
            {
                $legalityArrary['expanded_legality'] = 'Not Legal';
            }

            if ($result['unlimited_legality'] != "Legal")
            {
                $legalityArrary['unlimited_legality'] = 'Not Legal';
            }

        }

    }


    return $legalityArrary;

}

function updateDeckListNames($deck_input)
{
    $deck_list = json_decode($deck_input['cards']);

    foreach ($deck_list->cards as $card)
    {

        // if (card_exists_by_set_number(get_set_id_by_ptcgo_code($card->set_code), $card->set_number)) {
        //     $card->name = get_card_name_by_set_number(get_set_id_by_ptcgo_code($card->set_code), $card->set_number);
        // }

        $card->name = 2;

        echo "Quantity: " . $card->quantity . "<br>";
        echo "Name: " . $card->name . "<br>";
        echo "Set code: " . $card->set_code . "<br>";
        echo "Set number: " . $card->set_number . "<br><br>";
    }


}


?>