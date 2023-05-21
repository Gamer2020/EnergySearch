<h2>Deck Search</h2>
<!-- The form -->
<form action="decks.php">
  <input type="text" placeholder="Deck Name..." name="deckname"
    value="<?php echo (isset($_GET['deckname']) ? sanitizeInput($_GET['deckname']) : '') ?>">
  <input type="text" placeholder="Contains Card..." name="containscard"
    value="<?php echo (isset($_GET['containscard']) ? sanitizeInput($_GET['containscard']) : '') ?>">

  <?php

  echo 'Format: <select name="format">';
  echo '<option ';

  if (isset($_GET['format']))
  {
    if (sanitizeInput($_GET['format']) == "All")
    {
      echo "selected ";
    }
  }
  else
  {
    echo "selected ";
  }
  echo 'value="All">All</option>';

  echo '<option ';

  if (isset($_GET['format']))
  {
    if (sanitizeInput($_GET['format']) == "Standard")
    {
      echo "selected ";
    }
  }
  echo 'value="Standard">Standard</option>';

  echo '<option ';

  if (isset($_GET['format']))
  {
    if (sanitizeInput($_GET['format']) == "Expanded")
    {
      echo "selected ";
    }
  }
  echo 'value="Expanded">Expanded</option>';

  echo '<option ';

  if (isset($_GET['format']))
  {
    if (sanitizeInput($_GET['format']) == "Unlimited")
    {
      echo "selected ";
    }
  }
  echo 'value="Unlimited">Unlimited</option>';

  echo '</select>';
  ?>

  <input type="submit" name="search" value="search"></input>
</form><br>