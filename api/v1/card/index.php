<?php

require_once('../../../config.php');
require_once('../../../functions/general.php');

header("Content-Type:application/json");

$authHeader = $_SERVER['HTTP_X_AUTH_TOKEN'] ?? '';
$token = $authHeader;
global $pdo;

$stmt = $pdo->prepare("SELECT * FROM es_api_tokens WHERE token_value = ?");
$stmt->execute([sanitizeInput($token)]);
$apiToken = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$apiToken) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid API token']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM es_cards WHERE id = ?");
        $stmt->execute([sanitizeInput($_GET['id'])]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif (isset($_GET['set_id']) && isset($_GET['set_number'])) {
        $stmt = $pdo->prepare("SELECT * FROM es_cards WHERE set_id = ? AND set_number = ?");
        $stmt->execute([sanitizeInput($_GET['set_id']), sanitizeInput($_GET['set_number'])]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif (isset($_GET['name'])) {
        $stmt = $pdo->prepare("SELECT * FROM es_cards WHERE name LIKE ?");
        $stmt->execute([sanitizeInput('%' . $_GET['name'] . '%')]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    if ($result) {
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Card not found']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

?>