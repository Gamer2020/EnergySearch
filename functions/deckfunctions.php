<?php

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
        } elseif (preg_match('/^\*?(\d+)\s+([\w\s\-\']+)(\w{3}\s+\d+)(\s+PH)?/i', $line, $matches) || preg_match('/^(\d+)\s+([\w\s\-\']+)(\w{2,3}\s+\d+)(\s+PH)?/i', $line, $matches)) {
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