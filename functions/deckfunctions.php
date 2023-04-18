<?php

function ptcglDeckListToJson($deck_string) {
    $sections = preg_split("/\n\n/", $deck_string);
    $deck = [
        'pokemon' => [],
        'trainer' => [],
        'energy' => []
    ];

    foreach ($sections as $section) {
        preg_match_all("/^(\d+)\s(.*?)\s([A-Z]+)\s(\d+)/m", $section, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $card = [
                'quantity' => (int) $match[1],
                'name' => $match[2],
                'set_code' => $match[3],
                'set_number' => (int) $match[4]
            ];

            if (preg_match("/^Pokémon:/", $section)) {
                $deck['pokemon'][] = $card;
            } elseif (preg_match("/^(Trainer|Trainers):/", $section)) {
                $deck['trainer'][] = $card;
            } elseif (preg_match("/^(Energy|Energies):/", $section)) {
                $deck['energy'][] = $card;
            }
        }
    }

    return json_encode($deck, JSON_PRETTY_PRINT);
}

?>