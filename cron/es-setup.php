<?php
require_once('config.php');
require_once('../config.php');
echo "<h2>Energy Search set up!</h2>";
echo "The set up is now running!<br>";
echo "If it takes longer than " . ini_get("max_execution_time") . " seconds the script will error and you may need to edit the value in the config.<br>";
echo "Installing card sets...";
require_once('es-update-cardsets.php');
echo "DONE!<br>";
echo "Installing cards...";
require_once('es-update-cards.php');
echo "DONE!<br>";
echo "Installing types...";
require_once('es-update-cardtypes.php');
echo "DONE!<br>";

?>