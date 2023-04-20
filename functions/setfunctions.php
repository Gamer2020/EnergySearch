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

function get_ptcgo_code_by_set_id($set_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT ptcgo_code FROM es_card_sets WHERE id = :set_id");
    $stmt->bindValue(':set_id', $set_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['ptcgo_code'];
    } else {
        return null;
    }
}


function get_set_id_by_ptcgo_code($ptcgo_code) {
    global $pdo;
  
    $stmt = $pdo->prepare("SELECT id FROM es_card_sets WHERE ptcgo_code = :ptcgo_code");
    $stmt->bindParam(":ptcgo_code", $ptcgo_code);
    $stmt->execute();
  
    $result = $stmt->fetch();
    return $result['id'];
  }

?>