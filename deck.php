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
                if (deck_exists(sanitizeInput($_GET['ID'])))
                {


                    global $pdo;
                    $id = sanitizeInput($_GET['ID']);
                    deck_add_view($id);
                    $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE id = ?");
                    $stmt->execute([$id]);
                    $deck = $stmt->fetch(PDO::FETCH_ASSOC);

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
                        $deck_list = json_decode($deck['cards']);
                        // print_r($deck_list);
            
                        // echo "<br>";
                        // echo "<br>";
                        // echo "<br>";
            
                        echo '<div id="tab-1">';
                        //echo '<p>Content for Tab 1</p>';
            

                        foreach ($deck_list->cards as $card)
                        {
                            echo "Quantity: " . $card->quantity . "<br>";
                            echo "Name: " . $card->name . "<br>";
                            echo "Set code: " . $card->set_code . "<br>";
                            echo "Set number: " . $card->set_number . "<br><br>";
                        }

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