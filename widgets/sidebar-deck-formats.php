<h3>Formats</h3>

<?php if (isset($_GET['ID']))
{
    if (deck_exists(sanitizeInput($_GET['ID'])))
    {
        global $pdo;
        $id = sanitizeInput($_GET['ID']);
        card_add_view($id);
        $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE id = ?");
        $stmt->execute([$id]);
        $deck = $stmt->fetch(PDO::FETCH_ASSOC);
    }


    echo '<div class="legality-button-group">';
    echo '<button class="legality-button1" disabled>Standard</button>';
    if ($deck['standard_legality'] == "Legal")
    {
        echo '<button class="legality-button2" disabled>Legal</button>';
    }
    else
    {
        echo '<button class="legality-button3" disabled>Not Legal</button>';
    }

    echo '</div>';

    echo '<div class="legality-button-group">';
    echo '<button class="legality-button1" disabled>Expanded</button>';
    if ($deck['expanded_legality'] == "Legal")
    {
        echo '<button class="legality-button2" disabled>Legal</button>';
    }
    else
    {
        echo '<button class="legality-button3" disabled>Not Legal</button>';
    }
    echo '</div>';

    echo '<div class="legality-button-group">';
    echo '<button class="legality-button1" disabled>Unlimited</button>';
    if ($deck['unlimited_legality'] == "Legal")
    {
        echo '<button class="legality-button2" disabled>Legal</button>';
    }
    else
    {
        echo '<button class="legality-button3" disabled>Not Legal</button>';
    }
    echo '</div>';

}
?>