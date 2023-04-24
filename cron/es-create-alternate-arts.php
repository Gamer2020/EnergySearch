<?php
require_once('config.php');
require_once('../config.php');

function create_alternate_art_cards_table()
{
    global $pdo;

    $sql = "CREATE TABLE IF NOT EXISTS es_alternate_art_cards (
            id VARCHAR(50) PRIMARY KEY,
            name VARCHAR(255) DEFAULT NULL,
            set_id VARCHAR(50) DEFAULT NULL,
            set_number TEXT DEFAULT NULL
          )";

    $pdo->exec($sql);
}

function insert_alternate_art_cards()
{
    global $pdo;

    $data = [
        ['g1-28a', 'Jolteon-EX', 'g1', '28a'],
        ['g1-73a', 'Team Flare Grunt', 'g1', '73a'],
        ['sm1-101a', 'Eevee', 'sm1', '101a'],
        ['sm10-182a', 'Pokégear 3.0', 'sm10', '182a'],
        ['sm10-182b', 'Pokégear 3.0', 'sm10', '182b'],
        ['sm10-189a', 'Welder', 'sm10', '189a'],
        ['sm10-195a', 'Dedenne-GX', 'sm10', '195a'],
        ['sm11-191a', 'Cherish Ball', 'sm11', '191a'],
        ['sm11-206a', 'Reset Stamp', 'sm11', '206a'],
        ['sm11-79a', 'Jirachi-GX', 'sm11', '79a'],
        ['sm12-143a', 'Togepi & Cleffa & Igglybuff-GX', 'sm12', '143a'],
        ['sm2-121a', 'Choice Band', 'sm2', '121a'],
        ['sm2-124a', 'Enhanced Hammer', 'sm2', '124a'],
        ['sm2-125a', 'Field Blower', 'sm2', '125a'],
        ['sm2-128a', 'Max Potion', 'sm2', '128a'],
        ['sm2-130a', 'Rescue Stretcher', 'sm2', '130a'],
        ['sm2-157a', 'Metagross-GX', 'sm2', '157a'],
        ['sm2-19a', 'Alolan Sandshrew', 'sm2', '19a'],
        ['sm2-21a', 'Alolan Vulpix', 'sm2', '21a'],
        ['sm2-51a', 'Garbodor', 'sm2', '51a'],
        ['sm2-60a', 'Tapu Lele-GX', 'sm2', '60a'],
        ['sm2-92a', 'Sylveon-GX', 'sm2', '92a'],
        ['sm3-105a', 'Porygon-Z', 'sm3', '105a'],
        ['sm3-112a', 'Acerola', 'sm3', '112a'],
        ['sm3-115a', 'Guzma', 'sm3', '115a'],
        ['sm3-116a', 'Kiawe', 'sm3', '116a'],
        ['sm3-18a', 'Charmander', 'sm3', '18a'],
        ['sm3-39a', 'Tapu Fini-GX', 'sm3', '39a'],
        ['sm3-88a', 'Darkrai-GX', 'sm3', '88a'],
        ['sm3-92a', 'Kirlia', 'sm3', '92a'],
        ['sm35-10a', 'Entei-GX', 'sm35', '10a'],
        ['sm35-68a', 'Ultra Ball', 'sm35', '68a'],
        ['sm35-77a', 'Zoroark-GX', 'sm35', '77a'],
        ['sm4-63a', 'Guzzlord-GX', 'sm4', '63a'],
        ['sm4-84a', 'Regigigas', 'sm4', '84a'],
        ['sm5-119a', 'Cynthia', 'sm5', '119a'],
        ['sm5-122a', 'Escape Board', 'sm5', '122a'],
        ['sm5-125a', 'Lillie', 'sm5', '125a'],
        ['sm5-135a', 'Volkner', 'sm5', '135a'],
        ['sm5-153a', 'Lusamine', 'sm5', '153a'],
        ['sm6-102a', 'Beast Ring', 'sm6', '102a'],
        ['sm6-112a', 'Metal Frying Pan', 'sm6', '112a'],
        ['sm6-113a', 'Mysterious Treasure', 'sm6', '113a'],
        ['sm6-2a', 'Alolan Exeggutor', 'sm6', '2a'],
        ['sm7-10a', 'Sceptile', 'sm7', '10a'],
        ['sm7-123a', 'Acro Bike', 'sm7', '123a'],
        ['sm7-148a', 'Tate & Liza', 'sm7', '148a'],
        ['sm7-177a', 'Rayquaza-GX', 'sm7', '177a'],
        ['sm75-40a', 'Altaria', 'sm75', '40a'],
        ['sm75-60a', 'Fiery Flint', 'sm75', '60a'],
        ['sm8-172a', 'Electropower', 'sm8', '172a'],
        ['sm8-187a', 'Net Ball', 'sm8', '187a'],
        ['sm8-188a', 'Professor Elm\'s Lecture', 'sm8', '188a'],
        ['sm8-189a', 'Sightseer', 'sm8', '189a'],
        ['sm9-152a', 'Pokémon Communication', 'sm9', '152a'],
        ['sm9-152b', 'Pokémon Communication', 'sm9', '152b'],
        ['smp-SM103a', 'Lunala-GX', 'smp', '103a'],
        ['smp-SM104a', 'Solgaleo-GX', 'smp', '104a'],
        ['smp-SM30a', 'Tapu Koko', 'smp', '30a'],
        ['xy10-105a', 'N', 'xy10', '105a'],
        ['xy10-111a', 'Shauna', 'xy10', '111a'],
        ['xy10-43a', 'Regirock-EX', 'xy10', '43a'],
        ['xy10-54a', 'Zygarde-EX', 'xy10', '54a'],
        ['xy2-88a', 'Blacksmith', 'xy2', '88a'],
        ['xy3-55a', 'M Lucario-EX', 'xy3', '55a'],
        ['xy4-24a', 'M Manectric-EX', 'xy4', '24a'],
        ['xy4-65a', 'Aegislash-EX', 'xy4', '65a'],
        ['xy6-77a', 'Shaymin-EX', 'xy6', '77a'],
        ['xy6-92a', 'Trainers\' Mail', 'xy6', '92a'],
        ['xy7-75a', 'Hex Maniac', 'xy7', '75a'],
        ['xy8-146a', 'Professor\'s Letter', 'xy8', '146a'],
        ['xy9-107a', 'Professor Sycamore', 'xy9', '107a'],
        ['xy9-98a', 'Delinquent', 'xy9', '98a'],
        ['xy9-98b', 'Delinquent', 'xy9', '98b'],
        ['xyp-XY150a', 'Yveltal-EX', 'xyp', '150a'],
        ['xyp-XY177a', 'Karen', 'xyp', '177a'],
        ['xyp-XY198a', 'M Camerupt-EX', 'xyp', '198a'],
        ['xyp-XY200a', 'M Sharpedo-EX', 'xyp', '200a'],
        ['xyp-XY67a', 'Jirachi', 'xyp', '67a']
    ];

    $sql = "INSERT INTO es_alternate_art_cards (id, name, set_id, set_number) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    foreach ($data as $row) {
        $stmt->execute($row);
    }
}



create_alternate_art_cards_table();
insert_alternate_art_cards();