<?php
require_once 'include.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "header.php" ?>

<body>
    <?php include "navbar.php" ?>
    <?php
    if ((isset($_GET['search']) && ($_GET['search'] == "search")))
    {
        echo '<div class="container-wide">';
    }
    else
    {
        echo '<div class="container">';
    }
    ?>
    <div class="panel">

        <!-- <h1>Decks</h1>
            <p>This is a planned feature that has not been implemented yet...</p>
            <br> -->
        <?php include "widgets/panel-deck-search.php" ?>
        <?php include "widgets/panel-deck-search-results.php" ?>
        <?php // Stuff that shows if there is no search.
        if (!(isset($_GET['search']) && ($_GET['search'] == "search")))
        {
            include "widgets/panel-lastest-decks.php";
            include "widgets/panel-most-viewed-decks.php";
            include "widgets/panel-most-votes-decks.php";
            include "widgets/panel-most-viewed-month-decks.php";
            include "widgets/panel-most-votes-month-decks.php";
        }
        ?>

    </div>
    <?php
    if (!(isset($_GET['search']) && ($_GET['search'] == "search")))
    {

        echo '<aside>';
        include "sidebar/sidebar-generic.php";
        echo '</aside>';

    }
    ?>
    </div>
    <?php include "footer.php" ?>
</body>

</html>