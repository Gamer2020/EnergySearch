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

            <?php
            // specify the path to your text file
            $filename = "txt/changelog.txt";

            // read the contents of the file into a variable
            $file_contents = file_get_contents($filename);

            // echo the contents of the file on the screen as page text
            echo $file_contents;
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