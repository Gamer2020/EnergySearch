<?php

require_once('../../../config.php');
require_once('../../../functions/general.php');

header("Content-Type:application/json");

$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$token = str_replace('Bearer ', '', $authHeader);

global $pdo;

$stmt = $pdo->prepare("SELECT * FROM es_api_tokens WHERE token_value = ?");
$stmt->execute(sanitizeInput([$token]));
$apiToken = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$apiToken) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid API token']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (
        !isset($data['deck_name']) || !isset($data['cards']) ||
        !isset($data['visible']) || !isset($data['source_type']) || !isset($data['source_info']) || !isset($data['source_identifier'])
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    $stmt = $pdo->prepare("
        INSERT INTO es_decks (deck_name, cards, featuredcard, visible, source_type, source_info, source_identifier)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $result = $stmt->execute([
        sanitizeInput($data['deck_name']),
        sanitizeInput($data['cards']),
        sanitizeInput($data['featuredcard']) ?? NULL,
        sanitizeInput($data['visible']),
        sanitizeInput($data['source_type']),
        sanitizeInput($data['source_info']),
        sanitizeInput($data['source_identifier'])
    ]);

    if ($result) {
        http_response_code(201);
        echo json_encode(['message' => 'Deck created successfully', 'id' => $pdo->lastInsertId()]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create deck']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM es_decks WHERE source_identifier = ?");
    $stmt->execute([sanitizeInput($_GET['id'])]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Deck not found']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

?>