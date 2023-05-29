<?php if (isset($_GET['ID']))
{
    if (card_exists(sanitizeInput($_GET['ID'])))
    {

        echo '<h3>Views: ' . get_card_views_by_id(sanitizeInput($_GET['ID'])) . "</h3>";

    }

}
?>