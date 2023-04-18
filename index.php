<?php
require_once 'include.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "header.php" ?>

<body>
    <?php include "navbar.php" ?>
    <div class="container">
        <div class="panel">

            <h1>Energy Search</h1>
            <!-- <p>TODO Think of something to put here. Card search maybe?</p> -->
            <br>
            <h2>Latest Decks</h2>
            <?php

            global $pdo;

            $stmt = $pdo->prepare("SELECT * from es_decks where visible = 'YES' ORDER BY id DESC LIMIT 8");
            $stmt->execute();
            $row_count = $stmt->rowCount();

            $RowNumVar = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<span id="Deck" style="float: left; width: 153px; margin-right: 20px;">';

                // if ($row['FeaturedCard'] == '') {
                //     $tempydecky = explode(',', $row['DeckList']);
                //     echo "<a href='view-deck?DeckID=" . $row['DeckID'] . "'>" . '<img width="153" height="98" src=wp-content/plugins/php-code-for-posts/PokemonTCGDatabase/CroppedCards/' . $tempydecky[0] . ".jpg" . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
                // } else {
                //     echo "<a href='view-deck?DeckID=" . $row['DeckID'] . "'>" . '<img width="153" height="98" src=wp-content/plugins/php-code-for-posts/PokemonTCGDatabase/CroppedCards/' . $row['FeaturedCard'] . ".jpg" . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
                // }
                echo "<a href='deck.php?ID=" . $row['id'] . "'>" . '<img width="153" height="98" src=https://placehold.co/153x98' . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
                echo "Name: <a href='deck.pho?ID=" . $row['id'] . "'>" . strip_tags($row['deck_name']) . "</a>";
                //echo " Format: " . strip_tags($row['Format']) . "<br>";
                //echo " Votes: " . strip_tags($row['UpVotes']) . "<br>";
                //echo "Posted by " . '<a href="/members/' . $row['DeckOwner'] . '/">' . $row['DeckOwner'] . '</a><br>';
                //echo " on " . $row['PostDate']  . "<br>";
                //echo '<hr></hr><br>';
            
                echo '</span>';

                $RowNumVar = $RowNumVar + 1;

                if ($RowNumVar == 4) {

                    echo "<br style='clear: left;' /><br style='clear: left;' />";

                    $RowNumVar = 0;
                }

            }

            ?>

        </div>
        <aside>
            <h2>Future Use</h2>
            <ul>
                <li>line 1</li>
                <li>line 2</li>
                <li>line 3</li>
            </ul>
        </aside>
    </div>
    <?php include "footer.php" ?>
</body>

</html>