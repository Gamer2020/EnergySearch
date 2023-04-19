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
}

function ptcglDeckListToJson($decklist)
{
    $lines = explode("\n", $decklist);
    $json_data = [
        "cards" => [],
    ];

    foreach ($lines as $line) {
        $line = trim($line);

        if (preg_match('/^(\d+)\s+(.+?)(?:\s+(\w{1,4})\s+(\d+))?(\s+PH)?$/i', $line, $matches)) {

            if (isset($matches[1]) && isset($matches[2])) {

                $quantity = $matches[1];
                $card_name = $matches[2];

                if (isset($matches[3]) && isset($matches[4])) {
                    $set_code = $matches[3];
                    $set_number = $matches[4];
                } else {

                    $set_code = get_ptcgo_code_by_set_id(get_set_id_by_card_name($matches[3]));
                    $set_number = get_set_number_by_card_name($matches[2]);                    
                }

                $card_data = [
                    "quantity" => $quantity,
                    "name" => $card_name,
                    "set_code" => $set_code,
                    "set_number" => $set_number,
                ];

                $json_data["cards"][] = $card_data;
            }
        }
    }

    return json_encode($json_data, JSON_PRETTY_PRINT);
}


?>