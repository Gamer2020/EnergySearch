<?php
function card_exists($card_id)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_cards WHERE id = ?");
    $stmt->execute([$card_id]);

    $count = $stmt->fetchColumn();

    return $count > 0;
}

function card_add_view($card_id) {
    global $pdo;
  
    // Update the views column
    $sql = "UPDATE es_cards SET views = views + 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$card_id]);
  
    // Update the monthly_views column
    $sql = "UPDATE es_cards SET monthly_views = monthly_views + 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$card_id]);
  }
  

?>