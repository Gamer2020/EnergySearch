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
            name VARCHAR(255) NOT NULL,
            supertype VARCHAR(50) NOT NULL,
            subtypes VARCHAR(255) DEFAULT NULL,
            hp VARCHAR(10) NOT NULL,
            types VARCHAR(255) NOT NULL,
            evolves_from VARCHAR(255) DEFAULT NULL,
            abilities TEXT DEFAULT NULL,
            attacks TEXT DEFAULT NULL,
            weaknesses TEXT DEFAULT NULL,
            retreat_cost VARCHAR(255) DEFAULT NULL,
            converted_retreat_cost INT DEFAULT NULL,
            set_id VARCHAR(50) NOT NULL,
            set_name VARCHAR(255) NOT NULL,
            set_series VARCHAR(255) NOT NULL,
            set_printed_total INT DEFAULT NULL,
            set_total INT DEFAULT NULL,
            set_unlimited VARCHAR(10) NOT NULL,
            set_standard VARCHAR(10) NOT NULL,
            set_expanded VARCHAR(10) NOT NULL,
            set_ptcgo_code VARCHAR(50) DEFAULT NULL,
            set_release_date DATE NOT NULL,
            set_updated_at TIMESTAMP NOT NULL,
            set_symbol VARCHAR(255) DEFAULT NULL,
            set_logo VARCHAR(255) DEFAULT NULL,
            number VARCHAR(50) NOT NULL,
            artist VARCHAR(255) DEFAULT NULL,
            rarity VARCHAR(50) NOT NULL,
            flavor_text TEXT DEFAULT NULL,
            national_pokedex_numbers TEXT DEFAULT NULL,
            unlimited VARCHAR(10) NOT NULL,
            standard VARCHAR(10) NOT NULL,
            expanded VARCHAR(10) NOT NULL,
            small_image VARCHAR(255) DEFAULT NULL,
            large_image VARCHAR(255) DEFAULT NULL,
            url_tcgplayer VARCHAR(255) DEFAULT NULL,
            price_tcgplayer TEXT DEFAULT NULL,
            url_cardmarket VARCHAR(255) DEFAULT NULL,
            price_cardmarket TEXT DEFAULT NULL
          )";

    $pdo->exec($sql);
}

create_cards_table();

?>