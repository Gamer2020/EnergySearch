<?php

function deck_exists($deck_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_decks WHERE id = ?");
    $stmt->execute([$deck_id]);

    $count = $stmt->fetchColumn();

    return $count > 0;
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

    if (!$result) {
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

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line) {
            $parts = explode(' ', $line);

            if (empty($parts)) {
                continue;
            }

            $quantity = array_shift($parts);

            if (!is_numeric($quantity)) {
                continue;
            }


            $set_number = array_pop($parts);
            while (!is_numeric($set_number) && !empty($parts)) {
                array_unshift($parts, $set_number);
                $set_number = array_pop($parts);
            }

            $set_code = array_pop($parts);
            $card_name = implode(' ', $parts);

            // if (empty($set_code)) {
            //     $set_code = get_ptcgo_code_by_set_id(get_set_id_by_card_name($card_name));
            // }

            // if (empty($set_number)) {
            //     $set_number = get_set_number_by_card_name($card_name);
            // }

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

function updateDeckListNames($deck_input)
{
    $deck_list = json_decode($deck_input['cards']);

    foreach ($deck_list->cards as $card) {

        if (card_exists_by_set_number(get_set_id_by_ptcgo_code($card->set_code), $card->set_number)) {
            $card->name = get_card_name_by_set_number(get_set_id_by_ptcgo_code($card->set_code), $card->set_number);
        }

        $card->name = 2;

        echo "Quantity: " . $card->quantity . "<br>";
        echo "Name: " . $card->name . "<br>";
        echo "Set code: " . $card->set_code . "<br>";
        echo "Set number: " . $card->set_number . "<br><br>";
    }


}


?>