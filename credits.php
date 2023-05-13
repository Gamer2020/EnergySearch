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
            $filename = "txt/credits.txt";

            // read the contents of the file into a variable
            $file_contents = file_get_contents($filename);

            // echo the contents of the file on the screen as page text
            echo $file_contents;
            ?>

        </div>
        <aside>
            <?php include "sidebar/sidebar-generic.php"; ?>
        </aside>
    </div>
    <?php include "footer.php" ?>
</body>

</html>