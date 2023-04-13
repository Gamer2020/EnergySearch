<?php
require_once('config.php');
require_once('../config.php');

require_once('vendor/autoload.php');

use Pokemon\Pokemon;

function create_cards_table()
{

  global $pdo;

  $sql = "CREATE TABLE IF NOT EXISTS es_cards (
            id VARCHAR(50) PRIMARY KEY,
            name VARCHAR(255) DEFAULT NULL,
            supertype VARCHAR(50) DEFAULT NULL,
            subtypes VARCHAR(255) DEFAULT NULL,
            hp VARCHAR(10) DEFAULT NULL,
            types VARCHAR(255) DEFAULT NULL,
            rules TEXT DEFAULT NULL,
            evolves_from VARCHAR(255) DEFAULT NULL,
            evolves_to VARCHAR(255) DEFAULT NULL,
            abilityname1 TEXT DEFAULT NULL,
            abilitytext1 TEXT DEFAULT NULL,
            abilitytype1 TEXT DEFAULT NULL,
            abilityname2 TEXT DEFAULT NULL,
            abilitytext2 TEXT DEFAULT NULL,
            abilitytype2 TEXT DEFAULT NULL,
            attackname1 TEXT DEFAULT NULL,
            attackcost1 TEXT DEFAULT NULL,
            attackconvertedenergycost1 TEXT DEFAULT NULL,
            attackdamage1 TEXT DEFAULT NULL,
            attacktext1 TEXT DEFAULT NULL,
            attackname2 TEXT DEFAULT NULL,
            attackcost2 TEXT DEFAULT NULL,
            attackconvertedenergycost2 TEXT DEFAULT NULL,
            attackdamage2 TEXT DEFAULT NULL,
            attacktext2 TEXT DEFAULT NULL,
            attackname3 TEXT DEFAULT NULL,
            attackcost3 TEXT DEFAULT NULL,
            attackconvertedenergycost3 TEXT DEFAULT NULL,
            attackdamage3 TEXT DEFAULT NULL,
            attacktext3 TEXT DEFAULT NULL,
            attackname4 TEXT DEFAULT NULL,
            attackcost4 TEXT DEFAULT NULL,
            attackconvertedenergycost4 TEXT DEFAULT NULL,
            attackdamage4 TEXT DEFAULT NULL,
            attacktext4 TEXT DEFAULT NULL,
            weaknesstype TEXT DEFAULT NULL,
            weaknessvalue TEXT DEFAULT NULL,
            resistancetype TEXT DEFAULT NULL,
            resistancevalue TEXT DEFAULT NULL,
            retreat_cost VARCHAR(255) DEFAULT NULL,
            converted_retreat_cost INT DEFAULT NULL,
            set_id VARCHAR(50) DEFAULT NULL,
            set_number VARCHAR(50) DEFAULT NULL,
            artist VARCHAR(255) DEFAULT NULL,
            rarity VARCHAR(50) DEFAULT NULL,
            flavor_text TEXT DEFAULT NULL,
            national_pokedex_numbers TEXT DEFAULT NULL,
            unlimited_legality VARCHAR(10) DEFAULT NULL,
            standard_legality VARCHAR(10) DEFAULT NULL,
            expanded_legality VARCHAR(10) DEFAULT NULL,
            small_image VARCHAR(255) DEFAULT NULL,
            large_image VARCHAR(255) DEFAULT NULL,
            ancientTrait VARCHAR(255) DEFAULT NULL,
            views VARCHAR(50) DEFAULT NULL,
            monthly_views VARCHAR(50) DEFAULT NULL
          )";

  $pdo->exec($sql);
}

function import_cards()
{
  // Initialize Pokemon TCG SDK with your API key
  Pokemon::Options(['verify' => true]);
  Pokemon::ApiKey(es_ptcg_api_key);

  global $pdo;

  $response = Pokemon::Card()->all();

  $sql = "INSERT INTO es_cards (
              id, name, supertype, subtypes, hp, types, rules, evolves_from, evolves_to,
              abilityname1, abilitytext1, abilitytype1, abilityname2, abilitytext2, abilitytype2,
              attackname1, attackcost1, attackconvertedenergycost1, attackdamage1, attacktext1,
              attackname2, attackcost2, attackconvertedenergycost2, attackdamage2, attacktext2,
              attackname3, attackcost3, attackconvertedenergycost3, attackdamage3, attacktext3,
              attackname4, attackcost4, attackconvertedenergycost4, attackdamage4, attacktext4,
              weaknesstype, weaknessvalue, resistancetype, resistancevalue,
              retreat_cost, converted_retreat_cost,
              set_id, set_number, artist, rarity, flavor_text, national_pokedex_numbers,
              unlimited_legality, standard_legality, expanded_legality,
              small_image, large_image, ancientTrait, views, monthly_views
            )
            VALUES (
              :id, :name, :supertype, :subtypes, :hp, :types, :rules, :evolves_from, :evolves_to,
              :abilityname1, :abilitytext1, :abilitytype1, :abilityname2, :abilitytext2, :abilitytype2,
              :attackname1, :attackcost1, :attackconvertedenergycost1, :attackdamage1, :attacktext1,
              :attackname2, :attackcost2, :attackconvertedenergycost2, :attackdamage2, :attacktext2,
              :attackname3, :attackcost3, :attackconvertedenergycost3, :attackdamage3, :attacktext3,
              :attackname4, :attackcost4, :attackconvertedenergycost4, :attackdamage4, :attacktext4,
              weaknesstype, weaknessvalue, resistancetype, resistancevalue,
              retreat_cost, converted_retreat_cost,
              set_id, set_number, artist, rarity, flavor_text, national_pokedex_numbers,
              unlimited_legality, standard_legality, expanded_legality,
              small_image, large_image, ancientTrait, views, monthly_views
            )
            ON DUPLICATE KEY UPDATE
              name = :name,
              supertype = :supertype,
              subtypes = :subtypes,
              hp = :hp,
              types = :types,
              rules = :rules,
              evolves_from = :evolves_from,
              evolves_to = :evolves_to,
              abilityname1 = :abilityname1,
              abilitytext1 = :abilitytext1,
              abilitytype1 = :abilitytype1,
              abilityname2 = :abilityname2,
              abilitytext2 = :abilitytext2,
              abilitytype2 = :abilitytype2,
              attackname1 = :attackname1,
              attackcost1 = :attackcost1,
              attackconvertedenergycost1 = :attackconvertedenergycost1,
              attackdamage1 = :attackdamage1,
              attacktext1 = :attacktext1,
              attackname2 = :attackname2,
              attackcost2 = :attackcost2,
              attackconvertedenergycost2 = :attackconvertedenergycost2,
              attackdamage2 = :attackdamage2,
              attacktext2 = :attacktext2,
              attackname3 = :attackname3,
              attackcost3 = :attackcost3,
              attackconvertedenergycost3 = :attackconvertedenergycost3,
              attackdamage3 = :attackdamage3,
              attacktext3 = :attacktext3,
              attackname4 = :attackname4,
              attackcost4 = :attackcost4,
              attackconvertedenergycost4 = :attackconvertedenergycost4,
              attackdamage4 = :attackdamage4,
              attacktext4 = :attacktext4,
              weaknesstype = :weaknesstype,
              weaknessvalue = :weaknessvalue,
              resistancetype = :resistancetype,
              resistancevalue = :resistancevalue,
              retreat_cost = :retreat_cost,
              converted_retreat_cost = :converted_retreat_cost,
              set_id = :set_id,
              set_number = :set_number,
              artist = :artist,
              rarity = :rarity,
              flavor_text = :flavor_text,
              national_pokedex_numbers = :national_pokedex_numbers,
              unlimited_legality = :unlimited_legality,
              standard_legality = :standard_legality,
              expanded_legality = :expanded_legality,
              small_image = :small_image,
              large_image = :large_image,
              ancientTrait = :ancientTrait;";
  foreach ($response as $model) {

    $cardData = $model->toArray();

    $stmt = $pdo->prepare($sql);

    $tempvar = "";

    // Bind the values here...
    $stmt->bindParam(':id', $cardData['id']);
    $stmt->bindParam(':name', $cardData['name']);
    $stmt->bindParam(':supertype', $cardData['supertype']);
    $subtypesvar = arrayToString($cardData['subtypes']);
    $stmt->bindParam(':subtypes', $subtypesvar);
    $stmt->bindParam(':hp', $cardData['hp']);
    $typesvar = arrayToString($cardData['types']);
    $stmt->bindParam(':types', $typesvar);
    $stmt->bindParam(':rules', $cardData['types']);
    $stmt->bindParam(':evolves_from', $cardData['evolvesFrom']);
    $stmt->bindParam(':evolves_to', $cardData['evolvesTo']);
    $abilityname1var = getNestedArrayValue($cardData['abilities'],0,0);
    $stmt->bindParam(':abilityname1', $abilityname1var);
    $abilitytext1var = getNestedArrayValue($cardData['abilities'],0,1);
    $stmt->bindParam(':abilitytext1', $abilitytext1var);
    $abilitytype1var = getNestedArrayValue($cardData['abilities'],0,2);
    $stmt->bindParam(':abilitytype1', $abilitytype1var);
    $abilityname2var = getNestedArrayValue($cardData['abilities'],1,0);
    $stmt->bindParam(':abilityname2', $abilityname2var);
    $abilitytext2var = getNestedArrayValue($cardData['abilities'],1,1);
    $stmt->bindParam(':abilitytext2', $abilitytext2var);
    $abilitytype2var = getNestedArrayValue($cardData['abilities'],1,2);
    $stmt->bindParam(':abilitytype2', $abilitytype2var);
    $stmt->bindParam(':attackname1', $tempvar);
    $stmt->bindParam(':attackcost1', $tempvar);
    $stmt->bindParam(':attackconvertedenergycost1', $tempvar);
    $stmt->bindParam(':attackdamage1', $tempvar);
    $stmt->bindParam(':attacktext1', $tempvar);
    $stmt->bindParam(':attackname2', $tempvar);
    $stmt->bindParam(':attackcost2', $tempvar);
    $stmt->bindParam(':attackconvertedenergycost2', $tempvar);
    $stmt->bindParam(':attackdamage2', $tempvar);
    $stmt->bindParam(':attacktext2', $tempvar);
    $stmt->bindParam(':attackname3', $tempvar);
    $stmt->bindParam(':attackcost3', $tempvar);
    $stmt->bindParam(':attackconvertedenergycost3', $tempvar);
    $stmt->bindParam(':attackdamage3', $tempvar);
    $stmt->bindParam(':attacktext3', $tempvar);
    $stmt->bindParam(':attackname4', $tempvar);
    $stmt->bindParam(':attackcost4', $tempvar);
    $stmt->bindParam(':attackconvertedenergycost4', $tempvar);
    $stmt->bindParam(':attackdamage4', $tempvar);
    $stmt->bindParam(':attacktext4', $tempvar);
    $stmt->bindParam(':weaknesstype', $tempvar);
    $stmt->bindParam(':weaknessvalue', $tempvar);
    $stmt->bindParam(':resistancetype', $tempvar);
    $stmt->bindParam(':resistancevalue', $tempvar);
    $stmt->bindParam(':retreat_cost', $tempvar);
    $stmt->bindParam(':converted_retreat_cost', $tempvar);
    $stmt->bindParam(':set_id', $tempvar);
    $stmt->bindParam(':set_number', $tempvar);
    $stmt->bindParam(':artist', $tempvar);
    $stmt->bindParam(':rarity', $tempvar);
    $stmt->bindParam(':flavor_text', $tempvar);
    $stmt->bindParam(':national_pokedex_numbers', $tempvar);
    $stmt->bindParam(':unlimited_legality', $tempvar);
    $stmt->bindParam(':standard_legality', $tempvar);
    $stmt->bindParam(':expanded_legality', $tempvar);
    $stmt->bindParam(':small_image', $tempvar);
    $stmt->bindParam(':large_image', $tempvar);
    $stmt->bindParam(':ancientTrait', $tempvar);

    $defaultviewvar = 0;
    $stmt->bindParam(':views', $defaultviewvar);
    $stmt->bindParam(':monthly_views', $defaultviewvar);

    $stmt->execute();
  }
}

function arrayToString($variable) {
  // Check if the input variable is an array
  if (is_array($variable)) {
    // Concatenate all the array values into a string separated by "/"
    return implode('/', $variable);
  } else {
    // If the input variable is not an array, return it as is
    return $variable;
  }
}


/**
 * Retrieves a value from a nested array based on the given indexes.
 *
 * @param array $array The array to search through.
 * @param int|string $outerIndex The index of the outer array that contains the inner array.
 * @param int|string $innerIndex The index of the inner array that contains the value to retrieve.
 *
 * @return mixed|null The value at the given indexes, or null if either index doesn't exist.
 */
function getNestedArrayValue($array, $outerIndex, $innerIndex) {
  // Check if the outer index exists in the array and if the inner index exists in the nested array.
  if (isset($array[$outerIndex]) && isset($array[$outerIndex][$innerIndex])) {
      // If both indexes exist, return the value at the given indexes.
      return $array[$outerIndex][$innerIndex];
  }
  // If either index doesn't exist, return null.
  return null;
}


create_cards_table();
import_cards();

?>