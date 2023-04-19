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

        if (preg_match('/^(\d+)\s+(.+)\s+(\w{1,4})\s+(\d+)(\s+PH)?$/i', $line, $matches)) {
            $quantity = $matches[1];
            $card_name = $matches[2];
            $set_code = $matches[3];
            $set_number = $matches[4];
            
            $card_data = [
                "quantity" => $quantity,
                "name" => $card_name,
                "set_code" => $set_code,
                "set_number" => $set_number,
            ];

            $json_data["cards"][] = $card_data;
        }
    }

    return json_encode($json_data, JSON_PRETTY_PRINT);
}



?>