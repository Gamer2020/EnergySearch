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

  increment_total_card_views();
}

function increment_total_card_views()
{
  global $pdo;

  $sql = "UPDATE es_site_vars SET var_value = var_value + 1 WHERE var_name = 'total_card_views'";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
}

function get_set_number_by_card_name($card_name)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT set_number FROM es_cards WHERE LOWER(name) LIKE LOWER(:card_name)");
  $stmt->bindValue(':card_name', '%' . $card_name . '%', PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result)
  {
    return $result['set_number'];
  }
  else
  {
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

  if ($result)
  {
    return $result['set_id'];
  }
  else
  {
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

function get_PTCGL_set_by_card_name($card_name)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT PTCGL_set_id FROM es_cards WHERE LOWER(name) LIKE LOWER(:card_name)");
  $stmt->bindValue(':card_name', '%' . $card_name . '%', PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result)
  {
    return $result['PTCGL_set_id'];
  }
  else
  {
    return null;
  }
}

function get_PTCGL_num_by_card_name($card_name)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT PTCGL_set_number FROM es_cards WHERE LOWER(name) LIKE LOWER(:card_name)");
  $stmt->bindValue(':card_name', '%' . $card_name . '%', PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result)
  {
    return $result['PTCGL_set_number'];
  }
  else
  {
    return null;
  }
}

function get_card_votes_by_id($id)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT upvotes FROM es_cards WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  $result = $stmt->fetch();
  return $result['upvotes'];
}

function get_card_views_by_id($id)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT views FROM es_cards WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  $result = $stmt->fetch();
  return $result['views'];
}

function check_card_voted_by_id($id)
{
  global $pdo;

  $ip_address = get_user_ip();

  $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_card_upvotes WHERE card_id = :id AND ip_address = :ip");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":ip", $ip_address);
  $stmt->execute();

  $count = $stmt->fetchColumn();

  return $count > 0;
}

function card_add_vote($card_id)
{
  global $pdo;

  // Update the views column
  $sql = "UPDATE es_cards SET upvotes = upvotes + 1 WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$card_id]);

  // Update the monthly_views column
  $sql = "UPDATE es_cards SET monthly_upvotes = monthly_upvotes + 1 WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$card_id]);

}

function card_remove_vote($card_id)
{
  global $pdo;

  // Update the views column
  $sql = "UPDATE es_cards SET upvotes = upvotes - 1 WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$card_id]);

  // Update the monthly_views column
  $sql = "UPDATE es_cards SET monthly_upvotes = monthly_upvotes - 1 WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$card_id]);

}

function get_card_name_by_ptcgl($set_id, $set_number)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT name FROM es_cards WHERE PTCGL_set_id = :set_id AND PTCGL_set_number = :set_number");
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

function card_exists_by_ptcgl($set_id, $set_number)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT COUNT(*) FROM es_cards WHERE PTCGL_set_id = :set_id AND PTCGL_set_number = :set_number");
  $stmt->bindParam(":set_id", $set_id);
  $stmt->bindParam(":set_number", $set_number);
  $stmt->execute();

  $result = $stmt->fetchColumn();
  return $result > 0;
}

function get_card_image_by_id($id)
{
  global $pdo;
  $stmt = $pdo->prepare("SELECT small_image FROM es_cards WHERE id = ?");
  $stmt->bindValue(1, $id, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch();
  return $result ? $result['small_image'] : null;
}

function get_card_id_by_ptcgl_set_num($ptcgl_set_id, $ptcgl_set_number)
{
  global $pdo;

  $stmt = $pdo->prepare("SELECT id FROM es_cards WHERE PTCGL_set_id = :ptcgl_set_id AND PTCGL_set_number = :ptcgl_set_number");
  $stmt->bindValue(':ptcgl_set_id', $ptcgl_set_id);
  $stmt->bindValue(':ptcgl_set_number', $ptcgl_set_number);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result)
  {
    return $result['id'];
  }
  else
  {
    return null;
  }
}

function addCardVote($cardId, $ipAddress)
{
  global $pdo;

  $sql = "INSERT INTO es_card_upvotes (card_id, ip_address) VALUES (:cardId, :ipAddress)";

  try
  {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cardId', $cardId, PDO::PARAM_STR);
    $stmt->bindParam(':ipAddress', $ipAddress, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch (PDOException $e)
  {
    // Handle the exception or log the error
    echo "Error: " . $e->getMessage();
  }
}

function removeCardVote($cardId, $ipAddress)
{
  global $pdo;

  $sql = "DELETE FROM es_card_upvotes WHERE card_id = :cardId AND ip_address = :ipAddress";

  try
  {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cardId', $cardId, PDO::PARAM_STR);
    $stmt->bindParam(':ipAddress', $ipAddress, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch (PDOException $e)
  {
    // Handle the exception or log the error
    echo "Error: " . $e->getMessage();
  }
}

function ptcgl_code_override($PTCGO_Value, $SET_Value)
{

  if ($PTCGO_Value == "")
  {

    $valueList = array(
      array("input" => "sv1", "matched" => "SVI"),
      array("input" => "sv2", "matched" => "PAL"),
      array("input" => "svp", "matched" => "PR-SV"),
      array("input" => "swsh12tg", "matched" => "CRZ-GG"),
      array("input" => "sma", "matched" => "HIF"),
      array("input" => "sve", "matched" => "SVE"),
      array("input" => "sv3", "matched" => "OBF")
    );

    foreach ($valueList as $match)
    {
      if ($SET_Value == $match['input'])
      {
        return $match['matched'];
      }
    }

    return "INVALID";

  }
  elseif ($SET_Value == "swsh12pt5gg")
  {

    return "CRZ-GG";

  }
  elseif ($SET_Value == "swsh12tg")
  {

    return "SIT-GG";

  }
  elseif ($SET_Value == "swsh11tg")
  {

    return "LOR-TG";

  }
  elseif ($SET_Value == "swsh10tg")
  {

    return "ASR-GG";

  }
  elseif ($SET_Value == "swsh9tg")
  {

    return "BRS-GG";

  }
  elseif ($SET_Value == "cel25c")
  {

    return "CEL-CC";

  }
  else
  {

    return $PTCGO_Value;
  }

}

function get_set_id_from_alternate_art_table($id)
{
  global $pdo;

  $sql = "SELECT set_id FROM es_alternate_art_cards WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result ? $result['set_id'] : null;
}

function get_set_number_from_alternate_art_table($id)
{
  global $pdo;

  $sql = "SELECT set_number FROM es_alternate_art_cards WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result ? $result['set_number'] : null;
}

function get_set_id_from_classic_collection_table($id)
{
  global $pdo;

  $sql = "SELECT set_id FROM es_classic_collection_cards WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result ? $result['set_id'] : null;
}

function get_set_number_from_classic_collection_table($id)
{
  global $pdo;

  $sql = "SELECT set_number FROM es_classic_collection_cards WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result ? $result['set_number'] : null;
}

function removeNonSpeciesFromNameString($string)
{
  $wordsToRemove = array('Origin', 'Forme', 'PH', 'Radiant', 'Hisuian');

  // Convert string and words to lowercase to avoid case-sensitive matching
  $string = strtolower($string);
  $wordsToRemove = array_map('strtolower', $wordsToRemove);

  // Remove words from string
  foreach ($wordsToRemove as $word)
  {
    $string = str_replace($word, '', $string);
  }

  // Remove extra spaces between words
  $string = preg_replace('/\s+/', ' ', $string);

  // Trim spaces from beginning and end of string
  $string = trim($string);

  // Return the modified string
  return $string;
}

?>