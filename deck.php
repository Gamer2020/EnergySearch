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
                        echo '<li><a href="#tab-2">Future Use</a></li>';
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

                        echo '<p class="deck-list"><img id="highlightedCard" class="deck-list-right-image" src="' . get_card_image_by_id($deck['featuredcard']) . '" alt="">';

                        foreach ($deck_list->cards as $card)
                        {
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
                                // Get all elements with the class 'deck-card'
                                var elems = document.getElementsByClassName('deck-card');

                                // Add event listener for each element
                                for (var i = 0; i < elems.length; i++) {
                                    elems[i].addEventListener("mouseover", function () {
                                        document.getElementById("highlightedCard").src = this.getAttribute('data-image');
                                    });
                                }
                            };

                        </script>
                        <?php


                        echo '</div>';

                        echo '<div id="tab-2">';
                        echo '<p>This is a planned feature that has not been implemented yet...</p>';
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

                        //catch exception
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