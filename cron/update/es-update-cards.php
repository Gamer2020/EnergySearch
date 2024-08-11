<?php

chdir(__DIR__);

require_once('../config.php');
require_once('../../config.php');
require_once('../../include.php');

require_once('../vendor/autoload.php');

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
            weakness TEXT DEFAULT NULL,
            resistance TEXT DEFAULT NULL,
            retreat_cost VARCHAR(255) DEFAULT NULL,
            converted_retreat_cost INT DEFAULT NULL,
            set_id VARCHAR(50) DEFAULT NULL,
            set_number TEXT DEFAULT NULL,
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
            tcg_player_data TEXT DEFAULT NULL,
            card_market_data TEXT DEFAULT NULL,
            PTCGL_set_id VARCHAR(50) DEFAULT NULL, 
            PTCGL_set_number TEXT DEFAULT NULL,
            views INT DEFAULT 0,
            monthly_views INT DEFAULT 0,
            upvotes INT DEFAULT 0,
            monthly_upvotes INT DEFAULT 0
          )";

  $pdo->exec($sql);
}

function import_cards()
{
  // Initialize Pokemon TCG SDK with your API key
  Pokemon::Options(['verify' => true]);
  Pokemon::ApiKey(es_ptcg_api_key);

  global $pdo;

  // Get the pagination information for all cards
  $pagination = Pokemon::Card()->pagination();

  // Get the total number of pages for the card query
  $total_pages = $pagination->getTotalPages();
  $page_size = $pagination->getPageSize();


  $sql = "INSERT INTO es_cards (
              id, name, supertype, subtypes, hp, types, rules, evolves_from, evolves_to,
              abilityname1, abilitytext1, abilitytype1, abilityname2, abilitytext2, abilitytype2,
              attackname1, attackcost1, attackconvertedenergycost1, attackdamage1, attacktext1,
              attackname2, attackcost2, attackconvertedenergycost2, attackdamage2, attacktext2,
              attackname3, attackcost3, attackconvertedenergycost3, attackdamage3, attacktext3,
              attackname4, attackcost4, attackconvertedenergycost4, attackdamage4, attacktext4,
              weakness, resistance,
              retreat_cost, converted_retreat_cost,
              set_id, set_number, artist, rarity, flavor_text, national_pokedex_numbers,
              unlimited_legality, standard_legality, expanded_legality,
              small_image, large_image, ancientTrait,
              tcg_player_data, card_market_data,
              PTCGL_set_id, PTCGL_set_number,
              views, monthly_views, upvotes, monthly_upvotes
            )
            VALUES (
              :id, :name, :supertype, :subtypes, :hp, :types, :rules, :evolves_from, :evolves_to,
              :abilityname1, :abilitytext1, :abilitytype1, :abilityname2, :abilitytext2, :abilitytype2,
              :attackname1, :attackcost1, :attackconvertedenergycost1, :attackdamage1, :attacktext1,
              :attackname2, :attackcost2, :attackconvertedenergycost2, :attackdamage2, :attacktext2,
              :attackname3, :attackcost3, :attackconvertedenergycost3, :attackdamage3, :attacktext3,
              :attackname4, :attackcost4, :attackconvertedenergycost4, :attackdamage4, :attacktext4,
              :weakness, :resistance,
              :retreat_cost, :converted_retreat_cost,
              :set_id, :set_number, :artist, :rarity, :flavor_text, :national_pokedex_numbers,
              :unlimited_legality, :standard_legality, :expanded_legality,
              :small_image, :large_image, :ancientTrait, 
              :tcg_player_data, :card_market_data,
              :PTCGL_set_id, :PTCGL_set_number,
              :views, :monthly_views, :upvotes, :monthly_upvotes
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
              weakness = :weakness,
              resistance = :resistance,
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
              ancientTrait = :ancientTrait,
              tcg_player_data = :tcg_player_data,
              card_market_data = :card_market_data,
              PTCGL_set_id = :PTCGL_set_id, 
              PTCGL_set_number = :PTCGL_set_number;";

  for ($i = 1; $i <= $total_pages; $i++)
  {

    $retryCount = 0;
    $maxRetries = 5;


    while ($retryCount < $maxRetries)
    {
      try
      {
        $response = Pokemon::Card()->page($i)->pageSize($page_size)->all();
        break;
      }
      catch (Exception $e)
      {
        // Handle the exception, if necessary
        // ...
        // Increment the retry count and wait for a short time before trying again
        $retryCount++;
        sleep(15);
      }
    }

    if ($retryCount == $maxRetries)
    {
      // If all attempts failed, throw an exception or handle the error
      // ...
    }

    foreach ($response as $model)
    {

      try
      {

        $cardData = $model->toArray();

        $stmt = $pdo->prepare($sql);


        // Bind the values here...
        $stmt->bindParam(':id', $cardData['id']);
        $stmt->bindParam(':name', $cardData['name']);
        $stmt->bindParam(':supertype', $cardData['supertype']);
        $subtypesvar = arrayToString($cardData['subtypes']);
        $stmt->bindParam(':subtypes', $subtypesvar);
        $stmt->bindParam(':hp', $cardData['hp']);
        $typesvar = arrayToString($cardData['types']);
        $stmt->bindParam(':types', $typesvar);
        $rulesvar = arrayToString($cardData['rules']);
        $stmt->bindParam(':rules', $rulesvar);
        $stmt->bindParam(':evolves_from', $cardData['evolvesFrom']);
        $evolvestovar = arrayToString($cardData['evolvesTo']);
        $stmt->bindParam(':evolves_to', $evolvestovar);

        $abilityname1var = '';
        $abilitytext1var = '';
        $abilitytype1var = '';
        $abilityname2var = '';
        $abilitytext2var = '';
        $abilitytype2var = '';

        if (isset($cardData['abilities'][0]))
        {
          $ability1 = $cardData['abilities'][0];
          $abilityname1var = $ability1['name'];
          $abilitytext1var = $ability1['text'];
          $abilitytype1var = $ability1['type'];
        }

        if (isset($cardData['abilities'][1]))
        {
          $ability2 = $cardData['abilities'][1];
          $abilityname2var = $ability2['name'];
          $abilitytext2var = $ability2['text'];
          $abilitytype2var = $ability2['type'];
        }

        $stmt->bindParam(':abilityname1', $abilityname1var);
        $stmt->bindParam(':abilitytext1', $abilitytext1var);
        $stmt->bindParam(':abilitytype1', $abilitytype1var);
        $stmt->bindParam(':abilityname2', $abilityname2var);
        $stmt->bindParam(':abilitytext2', $abilitytext2var);
        $stmt->bindParam(':abilitytype2', $abilitytype2var);

        $attackname1var = '';
        $attacktext1var = '';
        $attackcost1var = '';
        $attackconvertedEnergyCost1var = '';
        $attackdamage1var = '';

        $attackname2var = '';
        $attacktext2var = '';
        $attackcost2var = '';
        $attackconvertedEnergyCost2var = '';
        $attackdamage2var = '';

        $attackname3var = '';
        $attacktext3var = '';
        $attackcost3var = '';
        $attackconvertedEnergyCost3var = '';
        $attackdamage3var = '';

        $attackname4var = '';
        $attacktext4var = '';
        $attackcost4var = '';
        $attackconvertedEnergyCost4var = '';
        $attackdamage4var = '';

        if (isset($cardData['attacks'][0]))
        {
          $attack1 = $cardData['attacks'][0];
          $attackname1var = $attack1['name'];
          $attacktext1var = $attack1['text'];
          $attackcost1var = json_encode($attack1['cost']);
          $attackconvertedEnergyCost1var = $attack1['convertedEnergyCost'];
          $attackdamage1var = $attack1['damage'];
        }

        if (isset($cardData['attacks'][1]))
        {
          $attack2 = $cardData['attacks'][1];
          $attackname2var = $attack2['name'];
          $attacktext2var = $attack2['text'];
          $attackcost2var = json_encode($attack2['cost']);
          $attackconvertedEnergyCost2var = $attack2['convertedEnergyCost'];
          $attackdamage2var = $attack2['damage'];
        }

        if (isset($cardData['attacks'][2]))
        {
          $attack3 = $cardData['attacks'][2];
          $attackname3var = $attack3['name'];
          $attacktext3var = $attack3['text'];
          $attackcost3var = json_encode($attack3['cost']);
          $attackconvertedEnergyCost3var = $attack3['convertedEnergyCost'];
          $attackdamage3var = $attack3['damage'];
        }

        if (isset($cardData['attacks'][3]))
        {
          $attack4 = $cardData['attacks'][3];
          $attackname4var = $attack4['name'];
          $attacktext4var = $attack4['text'];
          $attackcost4var = json_encode($attack4['cost']);
          $attackconvertedEnergyCost4var = $attack4['convertedEnergyCost'];
          $attackdamage4var = $attack4['damage'];
        }

        $stmt->bindParam(':attackname1', $attackname1var);
        $stmt->bindParam(':attacktext1', $attacktext1var);
        $stmt->bindParam(':attackcost1', $attackcost1var);
        $stmt->bindParam(':attackconvertedenergycost1', $attackconvertedEnergyCost1var);
        $stmt->bindParam(':attackdamage1', $attackdamage1var);

        $stmt->bindParam(':attackname2', $attackname2var);
        $stmt->bindParam(':attacktext2', $attacktext2var);
        $stmt->bindParam(':attackcost2', $attackcost2var);
        $stmt->bindParam(':attackconvertedenergycost2', $attackconvertedEnergyCost2var);
        $stmt->bindParam(':attackdamage2', $attackdamage2var);

        $stmt->bindParam(':attackname3', $attackname3var);
        $stmt->bindParam(':attacktext3', $attacktext3var);
        $stmt->bindParam(':attackcost3', $attackcost3var);
        $stmt->bindParam(':attackconvertedenergycost3', $attackconvertedEnergyCost3var);
        $stmt->bindParam(':attackdamage3', $attackdamage3var);

        $stmt->bindParam(':attackname4', $attackname4var);
        $stmt->bindParam(':attacktext4', $attacktext4var);
        $stmt->bindParam(':attackcost4', $attackcost4var);
        $stmt->bindParam(':attackconvertedenergycost4', $attackconvertedEnergyCost4var);
        $stmt->bindParam(':attackdamage4', $attackdamage4var);

        $weaknessesvar = json_encode($cardData['weaknesses']);
        $stmt->bindParam(':weakness', $weaknessesvar);

        try
        {

          $resistancesvar = json_encode($cardData['resistances']);
          $stmt->bindParam(':resistance', $resistancesvar);
        }
        catch (Exception $e)
        {
          print_r($cardData);
          echo "<br><br>";
          echo 'Message: ' . $e->getMessage();
          $resistancesvar = "ERROR";
          $stmt->bindParam(':resistance', $resistancesvar);
        }

        $retreatcostvar = json_encode($cardData['retreatCost']);
        $stmt->bindParam(':retreat_cost', $retreatcostvar);
        $stmt->bindParam(':converted_retreat_cost', $cardData['convertedRetreatCost']);

        $stmt->bindParam(':set_id', $cardData['set']['id']);
        $stmt->bindParam(':set_number', $cardData['number']);


        $PTCGLsetidvar = ptcgl_code_override($cardData['set']['ptcgoCode'], $cardData['set']['id']);


        if (substr($cardData['number'], -1) === "a")
        {
          $PTCGLsetidvar = get_set_id_from_alternate_art_table($cardData['id']);
          $PTCGLsetnumbervar = get_set_number_from_alternate_art_table($cardData['id']);
        }
        else if (substr($cardData['number'], -1) === "b")
        {
          $PTCGLsetidvar = get_set_id_from_alternate_art_table($cardData['id']);
          $PTCGLsetnumbervar = get_set_number_from_alternate_art_table($cardData['id']);
        }
        else if (substr($cardData['number'], 0, 2) === "RC")
        {
          $PTCGLsetnumbervar = "RC" . ltrim(preg_replace('/[^0-9]/', '', $cardData['number']), "0");
          $PTCGLsetidvar = "LTR-RC";
        }
        else
        {
          $PTCGLsetnumbervar = ltrim(preg_replace('/[^0-9]/', '', $cardData['number']), "0");

        }

        if ($cardData['set']['id'] == "sma")
        {
          $PTCGLsetnumbervar = (preg_replace('/[^0-9]/', '', $cardData['number'])) + 69;
        }
        elseif ($cardData['set']['id'] == "swsh45sv")
        {
          $PTCGLsetnumbervar = (preg_replace('/[^0-9]/', '', $cardData['number'])) + 73;
        }
        elseif ($cardData['set']['id'] == "cel25c")
        {
          $PTCGLsetidvar = get_set_id_from_classic_collection_table($cardData['id']);
          $PTCGLsetnumbervar = get_set_number_from_classic_collection_table($cardData['id']);
        }


        $stmt->bindParam(':PTCGL_set_id', $PTCGLsetidvar);
        $stmt->bindParam(':PTCGL_set_number', $PTCGLsetnumbervar);

        $stmt->bindParam(':artist', $cardData['artist']);
        $stmt->bindParam(':rarity', $cardData['rarity']);
        $stmt->bindParam(':flavor_text', $cardData['flavorText']);
        $stmt->bindParam(':national_pokedex_numbers', $cardData['nationalPokedexNumbers'][0]);

        $legal_override_ids = [
          "bw9-122",
          "sm3-163",
          "sm8-209",
          "bwp-BW95",
          "bw10-90",
          "sm1-158",
          "sm1-123",
          "bw5-93",
          "sm1-161",
          "sm2-122",
          "sm35-68",
          "bw9-103",
          "xy8-149",
          "bw3-95",
          "dv1-20",
          "sm1-135"
        ];

        if (in_array($cardData['id'], $legal_override_ids))
        {
          $legal_text_var = "Legal";
          $stmt->bindParam(':standard_legality', $legal_text_var);
        }
        else
        {
          $stmt->bindParam(':standard_legality', $cardData['legalities']['standard']);
        }

        $stmt->bindParam(':expanded_legality', $cardData['legalities']['expanded']);
        $stmt->bindParam(':unlimited_legality', $cardData['legalities']['unlimited']);

        $stmt->bindParam(':small_image', $cardData['images']['small']);
        $stmt->bindParam(':large_image', $cardData['images']['large']);
        $ancientTraitvar = arrayToStringWithSpaces($cardData['ancientTrait']);
        $stmt->bindParam(':ancientTrait', $ancientTraitvar);

        $defaultviewvar = 0;
        $stmt->bindParam(':views', $defaultviewvar);
        $stmt->bindParam(':monthly_views', $defaultviewvar);
        $stmt->bindParam(':upvotes', $defaultviewvar);
        $stmt->bindParam(':monthly_upvotes', $defaultviewvar);

        $tcgplayerdatavar = json_encode($cardData['tcgplayer']);
        $stmt->bindParam(':tcg_player_data', $tcgplayerdatavar);

        $cardmarketdatavar = json_encode($cardData['cardmarket']);
        $stmt->bindParam(':card_market_data', $cardmarketdatavar);

        $stmt->execute();
        //catch exception
      }
      catch (Exception $e)
      {
        print_r($cardData);
        echo "<br><br>";
        echo 'Message: ' . $e->getMessage();
        echo "<br><br>";
      }
    }
  }


}

function arrayToString($variable)
{
  // Check if the input variable is an array
  if (is_array($variable))
  {
    // Concatenate all the array values into a string separated by "/"
    return implode('/', $variable);
  }
  else
  {
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
function getNestedArrayValue($array, $outerIndex, $innerIndex)
{
  // Check if the outer index exists in the array and if the inner index exists in the nested array.
  if (isset($array[$outerIndex]) && isset($array[$outerIndex][$innerIndex]))
  {
    // If both indexes exist, return the value at the given indexes.
    return $array[$outerIndex][$innerIndex];
  }
  // If either index doesn't exist, return null.
  return null;
}

function arrayToStringWithSpaces($variable)
{
  // Check if the input variable is an array
  if (is_array($variable))
  {
    // Concatenate all the array values into a string separated by a space
    return implode(' ', $variable);
  }
  else
  {
    // If the input variable is not an array, return it as is
    return $variable;
  }
}

create_cards_table();
import_cards();

?>