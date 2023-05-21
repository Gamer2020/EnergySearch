<h2>Most Viewed Cards - All time</h2>
<?php

global $pdo;

$stmt = $pdo->prepare("SELECT * from es_cards ORDER BY views DESC LIMIT 5");
$stmt->execute();
$row_count = $stmt->rowCount();

$RowNumVar = 0;
if ($row_count > 0)
{
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        echo '<span id="Card" style="float: left; width: 205px; margin-right: 20px;">';

        echo "<a href='card.php?ID=" . $row['id'] . "'>" . '<img width="205" height="127" src=img/crop_card.php?ID=' . $row['id'] . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
        echo "<a href='card.php?ID=" . $row['id'] . "'>" . limitStringLength(htmlspecialchars_decode($row['name']), 60) . "</a>";
        echo "<br>Views: " . ($row['views']);
        //echo " Format: " . strip_tags($row['Format']) . "<br>";
        //echo " Votes: " . strip_tags($row['UpVotes']) . "<br>";
        //echo '<hr></hr><br>';

        echo '</span>';

        $RowNumVar = $RowNumVar + 1;

        if ($RowNumVar == 5)
        {

            echo "<br style='clear: left;' /><br style='clear: left;' />";

            $RowNumVar = 0;
        }

    }
}
else
{
    echo "No decks found...";
}
?>