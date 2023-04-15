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
            <h1>Welcome to my website</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eleifend enim vitae augue faucibus, vel
                aliquet odio consequat. Nam imperdiet volutpat risus, at rhoncus ex efficitur sit amet. Donec eu nunc
                urna.</p>

            <?php

            global $pdo;

            // Retrieve the sets with Unlimited legality
            $stmt1 = $pdo->prepare("SELECT * FROM es_card_sets WHERE unlimited_legality = 'Legal' AND expanded_legality = 'Not Legal' AND standard_legality = 'Not Legal'");
            $stmt1->execute();
            $unlimited_sets = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            // Retrieve the sets with Standard legality
            $stmt2 = $pdo->prepare("SELECT * FROM es_card_sets WHERE standard_legality = 'Legal'");
            $stmt2->execute();
            $standard_sets = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            // Retrieve the sets with Expanded legality
            $stmt3 = $pdo->prepare("SELECT * FROM es_card_sets WHERE expanded_legality = 'Legal' AND standard_legality = 'Not Legal'");
            $stmt3->execute();
            $expanded_sets = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            echo '<table>';
            echo '<tr>';
            echo '<th>Standard</th>';
            echo '<th>Expanded</th>';
            echo '<th>Unlimited</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<td valign="top">';
            echo '<span id="Standard">';

            foreach ($standard_sets as $set) {

                echo '<a href=set.php?id=' . $set['id'] . '>' . '<img width="30" height="30" src=' . $set['symbol_url'] . '>' . $set['name'] . '</a><br>';

            }

            echo '</span>';
            echo "</td>";

            echo '<td valign="top">';
            echo '<span id="Expanded">';

            foreach ($expanded_sets as $set) {

                echo '<a href=set.php?id=' . $set['id'] . '>' . '<img width="30" height="30" src=' . $set['symbol_url'] . '>' . $set['name'] . '</a><br>';

            }
            echo '</span>';
            echo "</td>";

            echo '<td valign="top">';
            echo '<span id="Unlimited">';

            foreach ($unlimited_sets as $set) {

                echo '<a href=set.php?id=' . $set['id'] . '>' . '<img width="30" height="30" src=' . $set['symbol_url'] . '>' . $set['name'] . '</a><br>';

            }

            echo '</span>';
            echo "</td>";
            echo '</tr>';
            echo '</table>';

            ?>

        </div>
    </div>
    <?php include "footer.php" ?>
</body>

</html>