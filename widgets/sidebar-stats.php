<h3>Site Stats</h3>
<?php

global $pdo;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM es_cards");
$stmt->execute();

$cardcount = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM es_decks");
$stmt->execute();

$deckcount = $stmt->fetchColumn();

$var_name = 'total_card_views'; 

$stmt = $pdo->prepare("SELECT var_value FROM es_site_vars WHERE var_name = :var_name");
$stmt->execute(['var_name' => $var_name]);

$total_card_views = $stmt->fetchColumn();

$var_name = 'total_deck_views'; 

$stmt = $pdo->prepare("SELECT var_value FROM es_site_vars WHERE var_name = :var_name");
$stmt->execute(['var_name' => $var_name]);

$total_deck_views = $stmt->fetchColumn();

echo "Total Cards: " . $cardcount;
echo "<br>";
echo "Total Decks: " . $deckcount;
echo "<br>";
echo "Total Card Views: " . $total_card_views;
echo "<br>";
echo "Total Deck Views: " . $total_deck_views;
?>