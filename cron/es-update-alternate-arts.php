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
        ['g1-28a', 'Jolteon-EX', 'XYALT', '147'],
        ['g1-73a', 'Team Flare Grunt', 'XYALT', '148'],
        ['sm1-101a', 'Eevee', 'SMALT', '25'],
        //['sm10-182a', 'Pokégear 3.0', 'sm10', '182a'],
        ['sm10-182b', 'Pokégear 3.0', 'SMALT', '154'],
        //['sm10-189a', 'Welder', 'sm10', '189a'],
        ['sm10-195a', 'Dedenne-GX', 'SMALT', '156'],
        //['sm11-191a', 'Cherish Ball', 'sm11', '191a'],
        ['sm11-206a', 'Reset Stamp', 'SMALT', '165'],
        ['sm11-79a', 'Jirachi-GX', 'SMALT', '159'],
        ['sm12-143a', 'Togepi & Cleffa & Igglybuff-GX', 'SMALT', '170'],
        //['sm2-121a', 'Choice Band', 'sm2', '121a'],
        ['sm2-124a', 'Enhanced Hammer', 'SMALT', '43'],
        ['sm2-125a', 'Field Blower', 'SMALT', '44'],
        ['sm2-128a', 'Max Potion', 'SMALT', '45'],
        ['sm2-130a', 'Rescue Stretcher', 'SMALT', '187'],
        ['sm2-157a', 'Metagross-GX', 'SMALT', '46'],
        ['sm2-19a', 'Alolan Sandshrew', 'SMALT', '30'],
        ['sm2-21a', 'Alolan Vulpix', 'SMALT', '31'],
        ['sm2-51a', 'Garbodor', 'SMALT', '34'],
        ['sm2-60a', 'Tapu Lele-GX', 'SMALT', '38'],
        ['sm2-92a', 'Sylveon-GX', 'SMALT', '42'],
        ['sm3-105a', 'Porygon-Z', 'SMALT', '71'],
        //['sm3-112a', 'Acerola', 'sm3', '112a'],
        //['sm3-115a', 'Guzma', 'sm3', '115a'],
        ['sm3-116a', 'Kiawe', 'SMALT', '72'],
        ['sm3-18a', 'Charmander', 'SMALT', '54'],
        ['sm3-39a', 'Tapu Fini-GX', 'SMALT', '60'],
        ['sm3-88a', 'Darkrai-GX', 'SMALT', '67'],
        ['sm3-92a', 'Kirlia', 'SMALT', '68'],
        ['sm35-10a', 'Entei-GX', 'SMALT', '47'],
        //['sm35-68a', 'Ultra Ball', 'sm35', '68a'],
        ['sm35-77a', 'Zoroark-GX', 'SMALT', '51'],
        ['sm4-63a', 'Guzzlord-GX', 'SMALT', '82'],
        ['sm4-84a', 'Regigigas', 'SMALT', '86'],
        //['sm5-119a', 'Cynthia', 'sm5', '119a'],
        ['sm5-122a', 'Escape Board', 'SMALT', '96'],
        //['sm5-125a', 'Lillie', 'sm5', '125a'],
        //['sm5-135a', 'Volkner', 'sm5', '135a'],
        //['sm5-153a', 'Lusamine', 'sm5', '153a'],
        //['sm6-102a', 'Beast Ring', 'sm6', '102a'],
        ['sm6-112a', 'Metal Frying Pan', 'SMALT', '105'],
        ['sm6-113a', 'Mysterious Treasure', 'SMALT', '106'],
        ['sm6-2a', 'Alolan Exeggutor', 'SMALT', '98'],
        ['sm7-10a', 'Sceptile', 'SMALT', '112'],
        ['sm7-123a', 'Acro Bike', 'SMALT', '120'],
        ['sm7-148a', 'Tate & Liza', 'SMALT', '122'],
        ['sm7-177a', 'Rayquaza-GX', 'SMALT', '123'],
        ['sm75-40a', 'Altaria', 'SMALT', '109'],
        ['sm75-60a', 'Fiery Flint', 'SMALT', '110'],
        ['sm8-172a', 'Electropower', 'SMALT', '137'],
        ['sm8-187a', 'Net Ball', 'SMALT', '139'],
        //['sm8-188a', 'Professor Elm\'s Lecture', 'sm8', '188a'],
        ['sm8-189a', 'Sightseer', 'SMALT', '140'],
        //['sm9-152a', 'Pokémon Communication', 'sm9', '152a'],
        ['sm9-152b', 'Pokémon Communication', 'SMALT', '146'],
        ['smp-SM103a', 'Lunala-GX', 'SMALT', '174'],
        ['smp-SM104a', 'Solgaleo-GX', 'SMALT', '175'],
        ['smp-SM30a', 'Tapu Koko', 'SMALT', '172'],
        ['xy10-105a', 'N', 'XYALT', '174'],
        ['xy10-111a', 'Shauna', 'XYALT', '175'],
        ['xy10-43a', 'Regirock-EX', 'XYALT', '168'],
        ['xy10-54a', 'Zygarde-EX', 'XYALT', '170'],
        ['xy2-88a', 'Blacksmith', 'XYALT', '55'],
        ['xy3-55a', 'M Lucario-EX', 'XYALT', '72'],
        ['xy4-24a', 'M Manectric-EX', 'XYALT', '89'],
        ['xy4-65a', 'Aegislash-EX', 'XYALT', '96'],
        ['xy6-77a', 'Shaymin-EX', 'XYALT', '113'],
        ['xy6-92a', 'Trainers\' Mail', 'XYALT', '115'],
        ['xy7-75a', 'Hex Maniac', 'XYALT', '125'],
        ['xy8-146a', 'Professor\'s Letter', 'XYALT', '146'],
        ['xy9-107a', 'Professor Sycamore', 'XYALT', '162'],
        ['xy9-98a', 'Delinquent', 'XYALT', '159'],
        ['xy9-98b', 'Delinquent', 'XYALT', '160'],
        ['xyp-XY150a', 'Yveltal-EX', 'XYALT', '199'],
        ['xyp-XY177a', 'Karen', 'XYALT', '200'],
        ['xyp-XY198a', 'M Camerupt-EX', 'XYALT', '201'],
        ['xyp-XY200a', 'M Sharpedo-EX', 'XYALT', '202'],
        ['xyp-XY67a', 'Jirachi', 'XYALT', '198']
    ];

    $sql = "INSERT INTO es_alternate_art_cards (id, name, set_id, set_number) VALUES (:id, :name, :set_id, :set_number)
            ON DUPLICATE KEY UPDATE
            name = :name,
            set_id = :set_id,
            set_number = :set_number";

    $stmt = $pdo->prepare($sql);

    foreach ($data as $item) {
        $stmt->bindValue(':id', $item[0]);
        $stmt->bindValue(':name', $item[1]);
        $stmt->bindValue(':set_id', $item[2]);
        $stmt->bindValue(':set_number', $item[3]);

        $stmt->execute();
    }
}


create_alternate_art_cards_table();
insert_alternate_art_cards();