<?php if (isset($_GET['ID']))
{
    if (deck_exists(sanitizeInput($_GET['ID'])) && deck_is_visible(sanitizeInput($_GET['ID'])))
    {
        ?>
        <script>
            async function castVote() {
                try {
                    let response = await fetch('vote.php', {
                        method: 'POST',
                        body: JSON.stringify({ action: 'vote', DeckId: '<?php echo sanitizeInput($_GET['ID']); ?>' }),
                        headers: { 'Content-Type': 'application/json' }
                    });

                    if (response.ok) {
                        let data = await response.json();
                        document.getElementById('vote-count').textContent = 'Upvotes: ' + data.voteCount;
                        document.getElementById('vote-btn').innerHTML = 'Unvote -1';
                        document.getElementById('vote-btn').className = 'voted';
                        document.getElementById('vote-btn').setAttribute('onclick', 'removeVote()');
                    } else {
                        console.error('Vote request failed');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            async function removeVote() {
                try {
                    let response = await fetch('vote.php', {
                        method: 'POST',
                        body: JSON.stringify({ action: 'remove', DeckId: '<?php echo sanitizeInput($_GET['ID']); ?>' }),
                        headers: { 'Content-Type': 'application/json' }
                    });

                    if (response.ok) {
                        let data = await response.json();
                        document.getElementById('vote-count').textContent = 'Upvotes: ' + data.voteCount;
                        document.getElementById('vote-btn').innerHTML = 'Upvote +1';
                        document.getElementById('vote-btn').className = 'not-voted';
                        document.getElementById('vote-btn').setAttribute('onclick', 'castVote()');
                    } else {
                        console.error('Remove vote request failed');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        </script>
        <?php
        echo '<div id="vote-container">';
        echo '<div id="vote-count">Upvotes: ' . get_deck_votes_by_id(sanitizeInput($_GET['ID'])) . '</div>';
        ?>
        <?php
        if (check_deck_voted_by_id(sanitizeInput($_GET['ID'])))
        {
            echo '<button id="vote-btn" class="voted" onclick="removeVote()">Unvote -1</button>';
        }
        else
        {
            echo '<button id="vote-btn" class="not-voted" onclick="castVote()">Upvote +1</button>';
        }

        echo '</div>';

    }

}
?>