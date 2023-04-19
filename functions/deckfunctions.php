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
        "pokemon" => [],
        "trainers" => [],
        "energies" => [],
    ];

    $current_section = "";

    foreach ($lines as $line) {
        $line = trim($line);
        if (preg_match('/^##? ?Pok[eé]mon(:)?/i', $line)) {
            $current_section = "pokemon";
        } elseif (preg_match('/^##? ?Trainer(:)?/i', $line)) {
            $current_section = "trainers";
        } elseif (preg_match('/^##? ?Energy(:)?/i', $line)) {
            $current_section = "energies";
        } elseif (preg_match('/^\*?(\d+)\s+([\w\s\-\']+)(\w{1,3}\s+\d+)(\s+PH)?/i', $line, $matches)) {
            $quantity = $matches[1];
            $card_name = $matches[2];
            $set_code = $matches[3];

            $json_data[$current_section][] = [
                "quantity" => $quantity,
                "name" => $card_name,
                "set_code" => $set_code,
            ];
        }
    }

    return json_encode($json_data, JSON_PRETTY_PRINT);
}



?>