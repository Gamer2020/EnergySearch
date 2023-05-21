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

            <!-- <h1>Energy Search</h1> -->
            <!-- <p>TODO Think of something to put here. Card search maybe?</p> -->
            <!-- <br> -->
            <?php include "widgets/panel-lastest-decks.php"; ?>
            <?php include "widgets/panel-most-viewed-decks.php"; ?>
            <?php include "widgets/panel-most-votes-decks.php"; ?>
            <?php include "widgets/panel-most-viewed-month-decks.php"; ?>
            <?php include "widgets/panel-most-votes-month-decks.php"; ?>

        </div>
        <aside>
            <?php include "sidebar/sidebar-generic.php"; ?>
        </aside>
    </div>
    <?php include "footer.php" ?>
</body>

</html>