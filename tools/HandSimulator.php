<?php 
require_once('../config.php');
require_once('../include.php');
?>

<?php if (isset($_GET['Deck']))
{

    echo '<style type="text/css">';
    echo '.hover_img a { position:relative; }';
    echo '.hover_img a span { position:absolute; display:none; z-index:99; }';
    echo '.hover_img a:hover span { display:block; }';
    echo '</style>';

    $deckArray = explode(',', $_GET['Deck']);

    shuffle($deckArray);

    //get_card_image_by_id

    echo '<img width="150" height="250" src=' . get_card_image_by_id($deckArray[0]). " alt=" . '""' . ">";
    echo '<img width="150" height="250" src=' . get_card_image_by_id($deckArray[1]). " alt=" . '""' . ">";
    echo '<img width="150" height="250" src=' . get_card_image_by_id($deckArray[2]). " alt=" . '""' . ">";
    echo '<img width="150" height="250" src=' . get_card_image_by_id($deckArray[3]). " alt=" . '""' . ">";
    echo '<img width="150" height="250" src=' . get_card_image_by_id($deckArray[4]). " alt=" . '""' . ">";
    echo '<img width="150" height="250" src=' . get_card_image_by_id($deckArray[5]). " alt=" . '""' . ">";
    echo '<img width="150" height="250" src=' . get_card_image_by_id($deckArray[6]). " alt=" . '""' . ">";

    echo "<br style='clear: left;' />";


}
else
{

    echo 'The page has not received a deck...';

}


?>