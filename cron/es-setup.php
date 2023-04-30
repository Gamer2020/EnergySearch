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
echo "Installing super types...";
require_once('es-update-cardsupertypes.php');
echo "DONE!<br>";
echo "Installing sub types...";
require_once('es-update-cardsubtypes.php');
echo "DONE!<br>";
echo "Installing rarities...";
require_once('es-update-cardrarities.php');
echo "DONE!<br>";
echo "Installing decks table...";
require_once('es-create-decks.php');
echo "DONE!<br>";
echo "Installing api token table...";
require_once('es-create-api.php');
echo "DONE!<br>";
echo "Installing Alternate Card Arts table...";
require_once('es-update-alternate-arts.php');
echo "DONE!<br>";
echo "Installing Classic Collection Card table...";
require_once('es-update-classic-collection.php');
echo "DONE!<br>";


?>