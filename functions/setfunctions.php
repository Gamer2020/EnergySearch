<?php
function set_exists($set_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_card_sets WHERE id = ?");
    $stmt->execute([$set_id]);

    $count = $stmt->fetchColumn();

    return $count > 0;
}

function get_set_name_from_id($id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT name FROM es_card_sets WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['name'] ?? null;
}

?>