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

function get_card_name_by_set_number($set_id, $set_number)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT name FROM es_cards WHERE set_id = :set_id AND set_number = :set_number");
  $stmt->bindParam(":set_id", $set_id);
  $stmt->bindParam(":set_number", $set_number);
  $stmt->execute();

  $result = $stmt->fetch();
  return $result['name'];
}

function card_exists_by_set_number($set_id, $set_number)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_cards WHERE set_id = :set_id AND set_number = :set_number");
  $stmt->bindParam(":set_id", $set_id);
  $stmt->bindParam(":set_number", $set_number);
  $stmt->execute();

  $result = $stmt->fetchColumn();
  return $result > 0;
}

function ptcgl_code_override($PTCGO_Value, $SET_Value)
{

  if ($PTCGO_Value == "") {

    $valueList = array(
      array("input" => "sv1", "matched" => "SVI"),
      array("input" => "svp", "matched" => "PR-SV"),
      array("input" => "swsh12tg", "matched" => "CRZ-GG"),
      array("input" => "sma", "matched" => "HIF")
    );

    foreach ($valueList as $match) {
      if ($SET_Value == $match['input']) {
        return $match['matched'];
      }
    }

    return "INVALID";

  } elseif ($SET_Value == "swsh12pt5gg") {

    return "CRZ-GG";

  } elseif ($SET_Value == "swsh12tg") {

    return "SIT-GG";

  } elseif ($SET_Value == "swsh11tg") {

    return "LOR-GG";

  } elseif ($SET_Value == "swsh10tg") {

    return "ASR-GG";

  } elseif ($SET_Value == "swsh9tg") {

    return "BRS-GG";

  } elseif ($SET_Value == "cel25c") {

    return "CEL-CC";

  } else {

    return $PTCGO_Value;
  }

}

?>