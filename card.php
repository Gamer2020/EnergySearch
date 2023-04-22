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

            <?php if (isset($_GET['ID'])) {
                if (card_exists(sanitizeInput($_GET['ID']))) {


                    global $pdo;
                    $id = sanitizeInput($_GET['ID']);
                    card_add_view($id);
                    $stmt = $pdo->prepare("SELECT * FROM es_cards WHERE id = ?");
                    $stmt->execute([$id]);
                    $card = $stmt->fetch(PDO::FETCH_ASSOC);

                    try {

                        echo '<table cellspacing="0" border="1">';

                        echo '<tbody>';

                        //Card name
            
                        echo '<tr>';

                        echo '<th style="font-size: 1.5em; line-height: 1.5em; color:: #000000;" colspan="3">' . $card['name'];

                        echo '</th></tr>';



                        //card image
            
                        echo '<tr>';

                        echo '<td rowspan="90"><a href="' . $card['large_image'] . '">' . '<img width="250" height="350" src=' . $card['small_image'] . " alt=" . '"' . $card['name'] . '"' . ">" . "</a>";

                        echo '</td></tr>';



                        //Set
            
                        echo '<tr>';

                        echo '<td> <b>Set:</b>';

                        echo '</td><td>' . get_set_name_from_id($card['set_id']);

                        echo '</td></tr>';



                        //Number
            
                        echo '<tr>';

                        echo '<td> <b>Number:</b>';

                        echo '</td><td>' . $card['set_number'];

                        echo '</td></tr>';



                        //Type
            
                        echo '<tr>';

                        echo '<td> <b>Type:</b>';

                        echo '</td><td>' . $card['types'];

                        echo '</td></tr>';



                        //CardType
            
                        echo '<tr>';

                        echo '<td> <b>Card Type:</b>';

                        echo '</td><td>' . $card['supertype'];

                        echo '</td></tr>';



                        //HP
            
                        echo '<tr>';

                        echo '<td> <b>HP:</b>';

                        echo '</td><td>' . $card['hp'];

                        echo '</td></tr>';



                        //Weakness
            
                        echo '<tr>';

                        echo '<td> <b>Weakness:</b>';

                        echo '</td><td>';
                        if (($card['weakness']) != "null") {
                            $weaknesses = json_decode($card['weakness'], true);

                            for ($x = 0; $x < count($weaknesses); $x++) {
                                echo $weaknesses[$x]['type'];
                                echo " " . $weaknesses[$x]['value'];
                                echo '<br>';
                            }
                        }
                        echo '</td></tr>';



                        //Resistance
            
                        echo '<tr>';

                        echo '<td> <b>Resistance:</b>';

                        echo '</td><td>';

                        if (($card['resistance']) != "null") {
                            $resistance = json_decode($card['resistance'], true);

                            for ($x = 0; $x < count($resistance); $x++) {
                                echo $resistance[$x]['type'];
                                echo " " . $resistance[$x]['value'];
                                echo '<br>';
                            }
                        }

                        echo '</td></tr>';



                        //RetreatCost
            
                        echo '<tr>';

                        echo '<td> <b>RetreatCost:</b>';

                        echo '</td><td>';

                        // for ($x = 0; $x < count($card['retreatCost']); $x++) {
                        //     echo TypeToImageHTML($card['retreatCost'][$x]);
                        // }
            
                        echo $card['converted_retreat_cost'];

                        echo '</td></tr>';



                        //Rarity
            
                        echo '<tr>';

                        echo '<td> <b>Rarity:</b>';

                        echo '</td><td>' . $card['rarity'];

                        echo '</td></tr>';



                        //Text
            
                        echo '<tr>';

                        echo '<td> <b>Text:</b>';

                        echo '</td><td>';

                        if ($card['rules'] <> "") {
                            echo $card['rules'];
                            echo '<br>' . '<br>';
                        }

                        if ($card['abilitytext1'] <> "") {
                            echo $card['abilitytype1'] . " - " . $card['abilityname1'] . "<br>";
                            echo $card['abilitytext1'];
                            echo '<br>' . '<br>';
                        }

                        if ($card['abilitytext2'] <> "") {
                            echo $card['abilitytype2'] . " - " . $card['abilityname2'] . "<br>";
                            echo $card['abilitytext2'];
                            echo '<br>' . '<br>';
                        }

                        if ($card['attackname1'] <> "") {
                            echo $card['attackcost1'] . " - " . $card['attackname1'] . " " . $card['attackdamage1'] . "<br>";
                            echo $card['attacktext1'];
                            echo '<br>' . '<br>';
                        }

                        if ($card['attackname2'] <> "") {
                            echo $card['attackcost2'] . " - " . $card['attackname2'] . " " . $card['attackdamage2'] . "<br>";
                            echo $card['attacktext2'];
                            echo '<br>' . '<br>';
                        }

                        if ($card['attackname3'] <> "") {
                            echo $card['attackcost3'] . " - " . $card['attackname3'] . " " . $card['attackdamage3'] . "<br>";
                            echo $card['attacktext3'];
                            echo '<br>' . '<br>';
                        }

                        if ($card['attackname4'] <> "") {
                            echo $card['attackcost4'] . " - " . $card['attackname4'] . " " . $card['attackdamage4'] . "<br>";
                            echo $card['attacktext4'];
                            echo '<br>' . '<br>';
                        }

                        echo '</td></tr>';

                        echo '</tbody></table>';

                        // $cardPrev = "";
                        // $cardNext = "";
            
                        // $response = Pokemon::Card($options)->where([
                        //     'setCode' => $card['setCode'],
                        //     'number' => ($card['number'] - 1)
                        // ])->all();
                        // foreach ($response as $model) {
                        //     $cardPrev = $model->toArray();
                        // }
            
                        // $response = Pokemon::Card($options)->where([
                        //     'setCode' => $card['setCode'],
                        //     'number' => ($card['number'] + 1)
                        // ])->all();
                        // foreach ($response as $model) {
                        //     $cardNext = $model->toArray();
                        // }
            
                        // echo '<table>';
                        // echo '<tr>';
            
                        // if (!empty($cardPrev)) {
                        //     echo '<th>Previous card in set</th>';
                        // }
            
                        // if (!empty($cardNext)) {
                        //     echo '<th>Next card in set</th>';
                        // }
            
                        // echo '</tr>';
                        // echo '<tr>';
            
                        // if (!empty($cardPrev)) {
                        //     echo "<td>" . '<div style="text-align:center"><a href="' . get_permalink($es_cardpage_options['page_id']) . "?ID=" . $cardPrev['id'] . '">' . '<img width="250" height="350" src=' . $cardPrev['imageUrl'] . "" . ">" . "</a></div>" . "</td>";
                        // }
            
                        // if (!empty($cardNext)) {
                        //     echo "<td>" . '<div style="text-align:center"><a href="' . get_permalink($es_cardpage_options['page_id']) . "?ID=" . $cardNext['id'] . '">' . '<img width="250" height="350" src=' . $cardNext['imageUrl'] . "" . ">" . "</a></div>" . "</td>";
                        // }
            
                        echo '</tr>';
                        echo '</table>';

                        //catch exception
                    } catch (Exception $e) {
                        echo 'Message: ' . $e->getMessage();
                    }

                } else {
                    echo "Card does not exist!";
                }
            } else {
                echo "No card specified!";
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