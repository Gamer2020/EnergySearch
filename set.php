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

                    global $pdo;
                    // Retrieve the set
                    $id = sanitizeInput($_GET['ID']);
                    $stmt = $pdo->prepare("SELECT * FROM es_card_sets WHERE id = ?");
                    $stmt->execute([$id]);
                    $set = $stmt->fetch(PDO::FETCH_ASSOC);

                    echo $set['name'];

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