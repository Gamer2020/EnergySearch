<?php
function card_exists($card_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_cards WHERE id = ?");
    $stmt->execute([$card_id]);

    $count = $stmt->fetchColumn();

    return $count > 0;
}
?>