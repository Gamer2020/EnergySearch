<?php
require_once 'include.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "header.php" ?>

<body>
    <?php include "navbar.php" ?>
    <div class="container-wide">
        <div class="panel panel-full">

            <?php if (isset($_GET['ID'])) {
                if (set_exists(sanitizeInput($_GET['ID']))) {
                } else {
                    echo "Set does not exist!";
                }
            } else {
                echo "No set specified!";
            }
            ?>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>

</html>