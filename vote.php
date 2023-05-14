<?php

require_once 'include.php';


// Get the request body and decode it as JSON
$request = json_decode(file_get_contents('php://input'), true);

if (isset($request['CardId']))
{

    // Get the action, userId, and postId from the request
    $action = sanitizeInput($request['action']);
    $cardId = sanitizeInput($request['CardId']);

    // Use these variables in your vote tracking logic
    if ($action === 'vote')
    {
        // Add vote logic here
    }
    else if ($action === 'remove')
    {
        // Remove vote logic here
    }

    // Get the current vote count
    $voteCount = get_card_votes_by_id($cardId);

    // Send a response with the vote count
    echo json_encode(['voteCount' => $voteCount]);

}


?>