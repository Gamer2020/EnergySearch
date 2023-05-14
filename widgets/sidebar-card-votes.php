<?php if (isset($_GET['ID']))
{
    if (card_exists(sanitizeInput($_GET['ID'])))
    {
        ?>

        <h3>Upvotes</h3>
        <script>
            async function castVote() {
                try {
                    let response = await fetch('vote.php', {
                        method: 'POST',
                        body: JSON.stringify({ action: 'vote', CardId: '<?php echo sanitizeInput($_GET['ID']);?>' }),
                        headers: { 'Content-Type': 'application/json' }
                    });

                    if (response.ok) {
                        let data = await response.json();
                        document.getElementById('vote-count').textContent = 'Vote count: ' + data.voteCount;
                        document.getElementById('vote-btn').innerHTML = 'Voted';
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
                        body: JSON.stringify({ action: 'remove', CardId: '<?php echo sanitizeInput($_GET['ID']);?>' }),
                        headers: { 'Content-Type': 'application/json' }
                    });

                    if (response.ok) {
                        let data = await response.json();
                        document.getElementById('vote-count').textContent = 'Vote count: ' + data.voteCount;
                        document.getElementById('vote-btn').innerHTML = 'Vote';
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
        if (check_card_voted_by_id(sanitizeInput($_GET['ID'])))
        {
            echo '<button id="vote-btn" class="voted" onclick="removeVote()">Voted</button>';
        }
        else
        {
            echo '<button id="vote-btn" class="not-voted" onclick="castVote()">Vote</button>';
        }

        echo '<p id="vote-count">Vote count: ' . get_card_votes_by_id(sanitizeInput($_GET['ID'])) . '</p>';



    }

}
?>