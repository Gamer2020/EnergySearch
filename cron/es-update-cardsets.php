<?php
require_once('config.php');
require_once('../config.php');

require_once('vendor/autoload.php');

use Pokemon\Pokemon;


function create_card_sets_table()
{

    global $pdo;

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS es_card_sets (
            id VARCHAR(255) PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            series VARCHAR(255) NOT NULL,
            printed_total INT NOT NULL,
            total INT NOT NULL,
            unlimited_legality VARCHAR(255) NOT NULL,
            standard_legality VARCHAR(255) NOT NULL,
            expanded_legality VARCHAR(255) NOT NULL,
            ptcgo_code VARCHAR(255) NOT NULL,
            release_date DATE NOT NULL,
            updated_at TIMESTAMP NOT NULL,
            symbol_url VARCHAR(255) NOT NULL,
            logo_url VARCHAR(255) NOT NULL
        )
    ");
}

function import_card_sets()
{
    // Initialize Pokemon TCG SDK with your API key
    Pokemon::Options(['verify' => true]);
    Pokemon::ApiKey(es_ptcg_api_key);

    global $pdo;

    // Retrieve all card sets from the API
    $sets = Pokemon::Set()->all();

    foreach ($sets as $model) {
        $set = $model->toArray();
        $stmt = $pdo->prepare("SELECT * FROM es_card_sets WHERE id = :id");
        $stmt->execute(['id' => $set['id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            // Update existing record
            $stmt = $pdo->prepare("UPDATE es_card_sets SET name = :name, series = :series, printed_total = :printed_total, total = :total, 
                                   unlimited_legality = :unlimited, standard_legality = :standard, expanded_legality = :expanded, ptcgo_code = :ptcgo_code, 
                                   release_date = :release_date, updated_at = :updated_at, symbol_url = :symbol_url, logo_url = :logo_url 
                                   WHERE id = :id");
        } else {
            // Insert new record
            $stmt = $pdo->prepare("INSERT INTO es_card_sets (id, name, series, printed_total, total, unlimited_legality, standard_legality, expanded_legality, 
                                   ptcgo_code, release_date, updated_at, symbol_url, logo_url) 
                                   VALUES (:id, :name, :series, :printed_total, :total, :unlimited, :standard, :expanded, 
                                   :ptcgo_code, :release_date, :updated_at, :symbol_url, :logo_url)");
        }
        $stmt->execute([
            'id' => $set['id'],
            'name' => $set['name'],
            'series' => $set['series'],
            'printed_total' => $set['printedTotal'],
            'total' => $set['total'],
            'unlimited' => returnWordIfNull($set['legalities']['unlimited'], "Not Legal"),
            'standard' => returnWordIfNull($set['legalities']['standard'], "Not Legal"),
            'expanded' => returnWordIfNull($set['legalities']['expanded'], "Not Legal"),
            'ptcgo_code' => returnWordIfNull(ptcgo_code_override($set['id'],$set['ptcgoCode']), "XXX"),
            'release_date' => $set['releaseDate'],
            'updated_at' => $set['updatedAt'],
            'symbol_url' => $set['images']['symbol'],
            'logo_url' => $set['images']['logo'],
        ]);
    }

}

function returnWordIfNull($value, $word)
{
    if (is_null($value)) {
        return $word;
    } else {
        return $value;
    }
}

function ptcgo_code_override($inputValue, $returnValue)
{
    $valueList = array(
        array("input" => "sv1", "matched" => "SVI"),
        array("input" => "value2", "matched" => "output2"),
        array("input" => "value3", "matched" => "output3")
    );

    foreach ($valueList as $match) {
        if ($inputValue == $match['input']) {
            return $match['matched'];
        }
    }

    return $inputValue;
}


create_card_sets_table();
import_card_sets();

?>