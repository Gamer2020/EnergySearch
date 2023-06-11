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




            <?php if (isset($_GET['ID']))
            {
                if (deck_exists(sanitizeInput($_GET['ID'])) && deck_is_visible(sanitizeInput($_GET['ID'])))
                {


                    global $pdo;
                    $id = sanitizeInput($_GET['ID']);
                    deck_add_view($id);
                    $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE id = ?");
                    $stmt->execute([$id]);
                    $deck = $stmt->fetch(PDO::FETCH_ASSOC);

                    $deck_list = json_decode($deck['cards']);

                    try
                    {

                        echo '<div id="deckviewer-wrapper">';
                        echo '<div id="deckviewer-title">' . limitStringLength(htmlspecialchars_decode($deck['deck_name']), 100) . '</div>';
                        echo '<div id="deckviewer">';
                        echo '<ul>';
                        echo '<li><a href="#tab-1">Deck List</a></li>';
                        echo '<li><a href="#tab-2">Stats</a></li>';
                        echo '<li><a href="#tab-3">Future Use</a></li>';
                        echo '</ul>';


                        // print_r($deck['source_identifier']);
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
            
                        // print_r($deck['source_info']);
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
            
                        // print_r($deck['cards']);
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
            
                        // print_r($deck_list);
            
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
            
                        echo '<div id="tab-1">';

                        echo '<button id="CopyButtonPTCGL" onclick="copyToClipboard()">Copy PTCGL List</button>';

                        echo '<br>';

                        echo '<p class="deck-list"><img id="highlightedCard" class="deck-list-right-image" src="' . get_card_image_by_id($deck['featuredcard']) . '" alt="">';

                        $deckListPTCGLText = "";

                        // Opening hand vars
            
                        $decklistcount = sizeof($deck_list->cards);
                        $energycount = "0";
                        $trainercount = "0";
                        $Pokecount = "0";
                        $Basiccount = "0";

                        $OHCALCdecklisttext = "";
                        $OHCALCenergytext = "";
                        $OHCALCtrainertext = "";
                        $OHCALCPokeText = "";

                        // Generate Deck.
            
                        foreach ($deck_list->cards as $card)
                        {
                            $deckListPTCGLText .= $card->quantity . " " . $card->name . " " . $card->set_code . " " . $card->set_number . "\\n";

                            // echo "Quantity: " . $card->quantity . "<br>";
                            // echo "Name: " . $card->name . "<br>";
                            // echo "Set code: " . $card->set_code . "<br>";
                            // echo "Set number: " . $card->set_number . "<br><br>";
            
                            $stmt = $pdo->prepare("SELECT * FROM es_cards WHERE PTCGL_set_id = :ptcgl_set_id AND PTCGL_set_number = :ptcgl_set_number");
                            $stmt->bindValue(':ptcgl_set_id', $card->set_code);
                            $stmt->bindValue(':ptcgl_set_number', $card->set_number);
                            $stmt->execute();

                            $db_card = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($db_card)
                            {
                                echo "<a href='card.php" . "?ID=" . $db_card['id'] . "' class='deck-card' data-image='" . $db_card['small_image'] . "'>" . $card->quantity . " x " . $db_card['name'] . "</a>" . "<br>";

                                if ((strpos($db_card['subtypes'], 'Basic') !== false) && $db_card['supertype'] === 'Pokémon')
                                {

                                    $Basiccount = $Basiccount + $card->quantity;

                                }


                            }
                            else
                            {
                                echo $card->quantity . " x " . htmlspecialchars_decode($card->name) . "<br>";
                            }

                        }

                        echo "</p>";
                        ?>
                        <script>
                            window.onload = function () {
                                var elems = document.getElementsByClassName('deck-card');

                                for (var i = 0; i < elems.length; i++) {
                                    elems[i].addEventListener("mouseover", function () {
                                        document.getElementById("highlightedCard").src = this.getAttribute('data-image');
                                    });
                                }
                            };

                        </script>
                        <input type="text" value="<?php echo htmlspecialchars($deckListPTCGLText, ENT_QUOTES, 'UTF-8'); ?>"
                            id="PTCGLDeckList" style="display: none;">

                        <script>
                            async function copyToClipboard() {
                                var copyText = document.getElementById("PTCGLDeckList");

                                var decodedText = copyText.value.replace(/\\n/g, "\n");

                                try {
                                    await navigator.clipboard.writeText(decodedText);
                                } catch (err) {
                                    console.error('Failed to copy text: ', err);
                                }
                            }
                        </script>
                        <?php


                        echo '</div>';



                        echo '<div id="tab-2">';
                        echo "<p>";

                        echo "Number of Pokemon: " . $Pokecount . "<br>";
                        echo "Number of Basic Pokemon: " . $Basiccount . "<br>";
                        // echo "Odds of having a basic Pokemon: " . CalcCardInOpeningHand($Basiccount, $decklistcount, 7) . "<br>";
                        echo "Number of Trainer cards: " . $trainercount . "<br>";
                        echo "Number of Energy cards: " . $energycount . "<br>";
                        // echo "Odds of starting with an Energy: " . CalcCardInOpeningHand($energycount, $decklistcount, 6) . "<br>";
                        echo "<br>";


                        echo "Odds of a card being in your opening hand:<br><br>";
                        // echo $OHCALCdecklisttext;
            
                        echo "</p>";
                        echo '</div>';



                        echo '<div id="tab-3">';
                        echo '<p>This is a planned feature that has not been implemented yet...</p>';
                        echo '</div>';

                        echo "</div>";
                        echo "</div>";

                        echo "<script>";
                        echo "$(function () {";
                        echo '$("#deckviewer").tabs();';
                        echo "});";
                        echo "</script>";

                        if ($deck['source_type'] == "YOUTUBE")
                        {

                            // print_r($deck['source_identifier']);
                            // print_r($deck['source_info']);
                            // echo '<br>';
            
                            $video_info = json_decode($deck['source_info']);

                            echo '<table>';
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<th>Source Type</th>';
                            echo '<td><a href="https://youtube.com" target="_blank">YouTube</a></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Source Info</th>';
                            echo '<td>This deck is collected from a YouTube video. For more information on the deck, please watch the YouTube video. If you like their content, please consider subscribing to the channel that uploaded the video to support the channel.</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<tr>';
                            echo '<th>Video</th>';
                            echo '<td><a href="' . $deck['source_identifier'] . '" target="_blank">' . $deck['source_identifier'] . '</a></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Channel</th>';
                            echo '<td><a href="' . $video_info->channel_url . '" target="_blank">' . $video_info->channel_name . '</a></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<th>Published</th>';
                            echo '<td>' . (new DateTime($video_info->publish_date))->format('M d, Y') . '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';

                        }

                    }
                    catch (Exception $e)
                    {
                        echo 'Message: ' . $e->getMessage();
                    }

                }
                else
                {
                    echo "Deck does not exist!";
                }
            }
            else
            {
                echo "No deck specified!";
            }
            ?>
        </div>
        <aside>
            <?php include "sidebar/sidebar-deck.php"; ?>
        </aside>
    </div>
    <?php include "footer.php" ?>
</body>

</html>