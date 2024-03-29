<?php

require_once('../../../include.php');

header("Content-Type:application/json");

$authHeader = $_SERVER['HTTP_X_AUTH_TOKEN'] ?? '';
$token = $authHeader;
global $pdo;

$stmt = $pdo->prepare("SELECT * FROM es_api_tokens WHERE token_value = ?");
$stmt->execute([sanitizeInput($token)]);
$apiToken = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$apiToken)
{
    http_response_code(401);
    echo json_encode(['error' => 'Invalid API token']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (
    !isset($data['deck_name']) || !isset($data['cards']) || !isset($data['visible']) ||
    !isset($data['source_type']) || !isset($data['source_info']) || !isset($data['source_identifier'])
    )
    {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    $stmt = $pdo->prepare("
        INSERT INTO es_decks (deck_name, cards, featuredcard, format_legality, visible, source_type, source_info, source_identifier)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $data = sanitizeArray($data);

    $card_list = ptcglDeckListToJson($data['cards']);


    //check if list is empty
    $deck_list_decoded = json_decode($card_list);

    if (empty($deck_list_decoded->cards))
    {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create deck']);
        exit();
    }

    $totalCards = 0;
    foreach ($deck_list_decoded->cards as $card)
    {
        $totalCards += intval($card->quantity);
    }

    if ($totalCards != 60)
    {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create deck']);
        exit();
    }

    // Update deck legality

    $deckLegalityArrary = ptcglDeckListJsonLegalCheck($card_list);

    // $data['standard_legality'] = $deckLegalityArrary['standard_legality'];
    // $data['expanded_legality'] = $deckLegalityArrary['expanded_legality'];
    // $data['unlimited_legality'] = $deckLegalityArrary['unlimited_legality'];

    if ($deckLegalityArrary['standard_legality'] == "Legal")
    {
        $data['format_legality'] = "standard";
    }
    else
    {
        if ($deckLegalityArrary['expanded_legality'] == "Legal")
        {
            $data['format_legality'] = "expanded";
        }
        else
        {
            $data['format_legality'] = "unlimited";
        }
    }

    // Determine featured card
    $deck_featured_card = $data['featuredcard'];

    $firstinstanceflag = 1;

    if ($data['source_type'] == "YOUTUBE")
    {

        $deck_list_decoded = json_decode($card_list);

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

            if (containsStringIgnoreCase($data['deck_name'], getFirstWord(removeNonSpeciesFromNameString($card->name))))
            {

                $deck_featured_card = get_card_id_by_ptcgl_set_num($card->set_code, $card->set_number);

                if (!empty($deck_featured_card))
                {
                    break;
                }

            }

        }


    }
    else
    {
        $deck_featured_card = $data['featuredcard'];
    }


    $result = $stmt->execute([
        $data['deck_name'],
        $card_list,
        $deck_featured_card ?? NULL,
        $data['format_legality'] ?? "unlimited",
        $data['visible'],
        $data['source_type'],
        json_encode($data['source_info']),
        $data['source_identifier']
    ]);

    if ($result)
    {
        http_response_code(201);
        echo json_encode(['message' => 'Deck created successfully', 'id' => $pdo->lastInsertId()]);
    }
    else
    {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create deck']);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    if (!isset($_GET['id']))
    {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE source_identifier = ?");
    $stmt->execute([sanitizeInput($_GET['id'])]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result)
    {
        echo json_encode($result);
    }
    else
    {
        http_response_code(404);
        echo json_encode(['error' => 'Deck not found']);
    }
}
else
{
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

?>