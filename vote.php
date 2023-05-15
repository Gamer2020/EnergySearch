<?php

require_once 'include.php';


// Get the request body and decode it as JSON
$request = json_decode(file_get_contents('php://input'), true);

if (isset($request['CardId']))
{
    if (card_exists(sanitizeInput($request['CardId'])))
    {

        // Get the action, userId, and postId from the request
        $action = sanitizeInput($request['action']);
        $cardId = sanitizeInput($request['CardId']);

        // Use these variables in your vote tracking logic
        if ($action === 'vote')
        {
            if (check_card_voted_by_id($cardId) == false)
            {
                addCardVote($cardId, get_user_ip());
                card_add_vote($cardId);
            }
        }
        else if ($action === 'remove')
        {
            if (check_card_voted_by_id($cardId))
            {
                removeCardVote($cardId, get_user_ip());
                card_remove_vote($cardId);
            }
        }

        // Get the current vote count
        $voteCount = get_card_votes_by_id($cardId);

        // Send a response with the vote count
        echo json_encode(['voteCount' => $voteCount]);

    }

}


?>