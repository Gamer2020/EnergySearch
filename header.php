<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <?php

    $currentPage = basename($_SERVER['PHP_SELF']);

    $pageTitle = '';
    switch ($currentPage)
    {
        case 'card.php':
            $pageTitle = "Energy Search | A Pokémon TCG database and search engine!";

            if (isset($_GET['ID']))
            {
                if (card_exists(sanitizeInput($_GET['ID'])))
                {

                    global $pdo;
                    $id = sanitizeInput($_GET['ID']);
                    $stmt = $pdo->prepare("SELECT * FROM es_cards WHERE id = ?");
                    $stmt->execute([$id]);
                    $card = $stmt->fetch(PDO::FETCH_ASSOC);

                    $pageTitle = $card['name'] . " - " . get_set_name_from_id($card['set_id']) . " | Energy Search";

                }
            }
            break;
        case 'deck.php':
            $pageTitle = "Energy Search | A Pokémon TCG database and search engine!";

            if (isset($_GET['ID']))
            {
                if (deck_exists(sanitizeInput($_GET['ID'])) && deck_is_visible(sanitizeInput($_GET['ID'])))
                {
                    global $pdo;
                    $id = sanitizeInput($_GET['ID']);
                    $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE id = ?");
                    $stmt->execute([$id]);
                    $deck = $stmt->fetch(PDO::FETCH_ASSOC);

                    $pageTitle = limitStringLength(htmlspecialchars_decode($deck['deck_name']), 100) . " | Energy Search";

                }
            }

            break;
        default:
            $pageTitle = "Energy Search | A Pokémon TCG database and search engine!";
            break;
    }

    echo "<title>" . $pageTitle . "</title>"

        ?>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>