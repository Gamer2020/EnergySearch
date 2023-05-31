<h2>Deck Matches - By Set and Number</h2>
<?php

global $pdo;

$json_Card_String1 = '"set_code": "' . $card['PTCGL_set_id'] . '"';
$json_Card_String2 = '"set_number": "' . $card['PTCGL_set_number'] . '"';

$stmt = $pdo->prepare("SELECT * from es_decks where visible = 'YES' AND cards LIKE :cardnumber AND cards LIKE :cardset ORDER BY id DESC LIMIT 10");
$stmt->bindValue(':cardset', '%' . $json_Card_String1 . '%', PDO::PARAM_STR);
$stmt->bindValue(':cardnumber', '%' . $json_Card_String2 . '%', PDO::PARAM_STR);
$stmt->execute();
$row_count = $stmt->rowCount();

$RowNumVar = 0;
if ($row_count > 0)
{
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        echo '<span id="Deck" style="float: left; width: 205px; margin-right: 20px;">';

        echo "<a href='deck.php?ID=" . $row['id'] . "'>" . '<img width="205" height="127" src=img/crop_card.php?ID=' . $row['featuredcard'] . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
        echo "<a href='deck.php?ID=" . $row['id'] . "'>" . limitStringLength(htmlspecialchars_decode($row['deck_name']), 60) . "</a><br>";
        if ($row['source_type'] == "YOUTUBE")
        {
            $video_info = json_decode($row['source_info']);
            echo 'By: <a href="' . $video_info->channel_url . '" target="_blank">' . $video_info->channel_name . '</a>';
        }
        //echo " Format: " . strip_tags($row['Format']) . "<br>";
        //echo " Votes: " . strip_tags($row['UpVotes']) . "<br>";
        //echo "Posted by " . '<a href="/members/' . $row['DeckOwner'] . '/">' . $row['DeckOwner'] . '</a><br>';
        //echo " on " . $row['PostDate']  . "<br>";
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