<?php

function ptcglDeckListToJson($deck_list)
{
    $deck_regex = '/(?:(?:##?\s*Pok[eé]mon|Pok[eé]mon:)\s*-?\s*\d*[\r\n]+(?:\*?\s*\d+\s+[\w\s\'-]+[A-Z]+\s\d+(?:\sPH)?[\r\n]+)+)(?:(?:##?\s*Trainer|Trainer:)\s*-?\s*\d*[\r\n]+(?:\*?\s*\d+\s+[\w\s\'-]+[A-Z]+\s\d+(?:\sPH)?[\r\n]+)+)(?:(?:##?\s*Energy|Energy:)\s*-?\s*\d*[\r\n]+(?:\*?\s*\d+\s+[\w\s\'-]+[A-Z]+\s\d+(?:\sPH)?[\r\n]+)+)/';

    if (preg_match($deck_regex, $deck_list, $matches)) {
        $deck = $matches[0];

        $deck_data = [];
        $categories = ["pokemon", "trainer", "energy"];
        $category_index = 0;

        $lines = explode("\n", $deck);
        foreach ($lines as $line) {
            $line = trim($line);
            if (strlen($line) == 0) {
                continue;
            }

            if (preg_match('/^(\d+)\s([\w\s\'-]+)\s([A-Z]+)\s(\d+)/', $line, $card_matches)) {
                $deck_data[$categories[$category_index]][] = [
                    "quantity" => intval($card_matches[1]),
                    "name" => $card_matches[2],
                    "set_code" => $card_matches[3],
                    "set_number" => intval($card_matches[4]),
                ];
            } else {
                $category_index++;
            }
        }

        return json_encode($deck_data, JSON_PRETTY_PRINT);
    } else {
        return null;
    }
}

?>