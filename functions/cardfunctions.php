<?php
function card_exists($card_id)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_cards WHERE id = ?");
  $stmt->execute([$card_id]);

  $count = $stmt->fetchColumn();

  return $count > 0;
}

function card_add_view($card_id)
{
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

function get_set_number_by_card_name($card_name)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT set_number FROM es_cards WHERE LOWER(name) LIKE LOWER(:card_name)");
  $stmt->bindValue(':card_name', '%' . $card_name . '%', PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    return $result['set_number'];
  } else {
    return null;
  }
}

function get_set_id_by_card_name($card_name)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT set_id FROM es_cards WHERE LOWER(name) LIKE LOWER(:card_name)");
  $stmt->bindValue(':card_name', '%' . $card_name . '%', PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    return $result['set_id'];
  } else {
    return null;
  }
}


?>