<?php if (isset($_GET['ID']))
{
    if (deck_exists(sanitizeInput($_GET['ID'])) && deck_is_visible(sanitizeInput($_GET['ID'])))
    {

        echo "<h3>Formats</h3>";

        global $pdo;
        $id = sanitizeInput($_GET['ID']);
        $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE id = ?");
        $stmt->execute([$id]);
        $deck = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($deck['format_legality'] == "standard")
        {
            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Standard</button>';
            echo '<button class="legality-button2" disabled>Legal</button>';
            echo '</div>';

            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Expanded</button>';
            echo '<button class="legality-button2" disabled>Legal</button>';
            echo '</div>';

            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Unlimited</button>';
            echo '<button class="legality-button2" disabled>Legal</button>';
            echo '</div>';
        }
        else if ($deck['format_legality'] == "expanded")
        {
            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Standard</button>';
            echo '<button class="legality-button3" disabled>Not Legal</button>';
            echo '</div>';

            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Expanded</button>';
            echo '<button class="legality-button2" disabled>Legal</button>';
            echo '</div>';

            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Unlimited</button>';
            echo '<button class="legality-button2" disabled>Legal</button>';
            echo '</div>';
        }
        else if ($deck['format_legality'] == "unlimited")
        {
            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Standard</button>';
            echo '<button class="legality-button3" disabled>Not Legal</button>';
            echo '</div>';

            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Expanded</button>';
            echo '<button class="legality-button3" disabled>Not Legal</button>';
            echo '</div>';

            echo '<div class="legality-button-group">';
            echo '<button class="legality-button1" disabled>Unlimited</button>';
            echo '<button class="legality-button2" disabled>Legal</button>';
            echo '</div>';
        }
    }
}
?>