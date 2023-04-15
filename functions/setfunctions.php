<?php
function set_exists($set_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_card_sets WHERE id = ?");
    $stmt->execute([$set_id]);

    $count = $stmt->fetchColumn();

    return $count > 0;
}
?>