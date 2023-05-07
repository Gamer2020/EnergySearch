<h2>Latest Decks</h2>
<?php

global $pdo;

$stmt = $pdo->prepare("SELECT * from es_decks where visible = 'YES' ORDER BY id DESC LIMIT 60");
$stmt->execute();
$row_count = $stmt->rowCount();

$RowNumVar = 0;
if ($row_count > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<span id="Deck" style="float: left; width: 205px; margin-right: 20px;">';

        // if ($row['FeaturedCard'] == '') {
        //     $tempydecky = explode(',', $row['DeckList']);
        //     echo "<a href='view-deck?DeckID=" . $row['DeckID'] . "'>" . '<img width="153" height="98" src=wp-content/plugins/php-code-for-posts/PokemonTCGDatabase/CroppedCards/' . $tempydecky[0] . ".jpg" . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
        // } else {
        //     echo "<a href='view-deck?DeckID=" . $row['DeckID'] . "'>" . '<img width="153" height="98" src=wp-content/plugins/php-code-for-posts/PokemonTCGDatabase/CroppedCards/' . $row['FeaturedCard'] . ".jpg" . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
        // }
        echo "<a href='deck.php?ID=" . $row['id'] . "'>" . '<img width="205" height="127" src=img/crop_card.php?ID=' . get_featuredcard_from_id($row['id']) . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
        echo "<a href='deck.php?ID=" . $row['id'] . "'>" . strip_tags($row['deck_name']) . "</a>";
        //echo " Format: " . strip_tags($row['Format']) . "<br>";
        //echo " Votes: " . strip_tags($row['UpVotes']) . "<br>";
        //echo "Posted by " . '<a href="/members/' . $row['DeckOwner'] . '/">' . $row['DeckOwner'] . '</a><br>';
        //echo " on " . $row['PostDate']  . "<br>";
        //echo '<hr></hr><br>';

        echo '</span>';

        $RowNumVar = $RowNumVar + 1;

        if ($RowNumVar == 3) {

            echo "<br style='clear: left;' /><br style='clear: left;' />";

            $RowNumVar = 0;
        }

    }
} else {
    echo "No decks found...";
}
?>