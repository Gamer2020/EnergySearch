<?php if (isset($_GET['ID']))
{
    if (deck_exists(sanitizeInput($_GET['ID'])) && deck_is_visible(sanitizeInput($_GET['ID'])))
    {

        echo '<h3>Views: ' . get_deck_views_by_id(sanitizeInput($_GET['ID'])) . "</h3>";

    }

}
?>