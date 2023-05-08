<?php
require_once 'include.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "header.php" ?>

<body>
    <?php include "navbar.php" ?>
    <?php
    if ((isset($_GET['search']) && ($_GET['search'] == "search"))) {
        echo '<div class="container-wide">';
    } else {
        echo '<div class="container">';
    }
    ?>
    <div class="panel">

        <!-- <h1>Cards</h1>
            <p>This is a planned feature that has not been implemented yet...</p>
            <br> -->
        <?php include "widgets/panel-card-search.php" ?>
        <?php include "widgets/panel-card-search-results.php" ?>

    </div>
    <?php
    if ((isset($_GET['search']) && ($_GET['search'] == "search"))) {
    } else {

        echo '<aside>';
        echo '<h2>Future Use</h2>';
        echo '<ul>';
        echo '<li>line 1</li>';
        echo '<li>line 2</li>';
        echo '<li>line 3</li>';
        echo '</ul>';
        echo '</aside>';

    }
    ?>
    </div>
    <?php include "footer.php" ?>
</body>

</html>