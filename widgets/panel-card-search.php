<h2>Card Search</h2>
<!-- The form -->
<form action="cards.php">
  <input type="text" placeholder="Card Name..." name="cardname"
    value="<?php echo (isset($_GET['cardname']) ? sanitizeInput($_GET['cardname']) : '') ?>">
  <!--<input type="text" placeholder="Card text..." name="cardtext" value="<?php //echo (isset($_GET['cardtext']) ? sanitize_text_field($_GET['cardtext']) : '') ?>">-->

  <?php

  echo 'Set: <select name="setid">';
  echo '<option ';

  if (isset($_GET['setid']))
  {
    if (sanitizeInput($_GET['setid']) == "All")
    {
      echo "selected";
    }
  }
  else
  {
    echo "selected";
  } ?>
  <?php echo 'value="All">All</option>'; ?>

  <?php

  global $pdo;

  $stmt = $pdo->prepare("SELECT * FROM es_card_sets");
  $stmt->execute();
  $card_sets = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($card_sets as $set)
  {

    echo '<option ' .
        ((isset($_GET['setid'])) ?
            ((sanitizeInput($_GET['setid']) == $set['id']) ? 'selected' : '')
            : '')
        . ' value="' . $set['id'] . '">' . $set['name'] . '</option>';

  }

  echo '</select>';
  ?>

  <?php

  echo 'Type: <select name="type">';
  echo '<option ';

  if (isset($_GET['type']))
  {
    if (sanitizeInput($_GET['type']) == "All")
    {
      echo "selected";
    }
  }
  else
  {
    echo "selected";
  } ?>
  <?php echo 'value="All">All</option>'; ?>

  <?php

  global $pdo;

  $stmt = $pdo->prepare("SELECT * FROM es_card_types");
  $stmt->execute();
  $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($types as $type)
  {

    echo '<option ' .
        ((isset($_GET['type'])) ?
            ((sanitizeInput($_GET['type']) == $type['name']) ? 'selected' : '')
            : '')
        . ' value="' . $type['name'] . '">' . $type['name'] . '</option>';

  }

  echo '</select>';
  ?>

  <?php

  echo 'Weakness: <select name="weakness">';
  echo '<option ';

  if (isset($_GET['weakness']))
  {
    if (sanitizeInput($_GET['weakness']) == "All")
    {
      echo "selected";
    }
  }
  else
  {
    echo "selected";
  } ?>
  <?php echo 'value="All">All</option>'; ?>

  <?php

  global $pdo;

  $stmt = $pdo->prepare("SELECT * FROM es_card_types");
  $stmt->execute();
  $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($types as $type)
  {

    echo '<option ' .
        ((isset($_GET['weakness'])) ?
            ((sanitizeInput($_GET['weakness']) == $type['name']) ? 'selected' : '')
            : '')
        . ' value="' . $type['name'] . '">' . $type['name'] . '</option>';

  }

  echo '</select>';
  ?>

  <?php

  echo 'Resistance: <select name="resistance">';
  echo '<option ';

  if (isset($_GET['resistance']))
  {
    if (sanitizeInput($_GET['resistance']) == "All")
    {
      echo "selected";
    }
  }
  else
  {
    echo "selected";
  } ?>
  <?php echo 'value="All">All</option>'; ?>

  <?php

  global $pdo;

  $stmt = $pdo->prepare("SELECT * FROM es_card_types");
  $stmt->execute();
  $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($types as $type)
  {

    echo '<option ' .
        ((isset($_GET['resistance'])) ?
            ((sanitizeInput($_GET['resistance']) == $type['name']) ? 'selected' : '')
            : '')
        . ' value="' . $type['name'] . '">' . $type['name'] . '</option>';

  }

  echo '</select>';
  ?>

<?php

echo 'Category: <select name="supertypes">';
echo '<option ';

if (isset($_GET['supertypes']))
{
  if (sanitizeInput($_GET['supertypes']) == "All")
  {
    echo "selected";
  }
}
else
{
  echo "selected";
} ?>
<?php echo 'value="All">All</option>'; ?>

<?php

global $pdo;

$stmt = $pdo->prepare("SELECT * FROM es_card_super_types");
$stmt->execute();
$types = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($types as $type)
{

  echo '<option ' .
      ((isset($_GET['supertypes'])) ?
          ((sanitizeInput($_GET['supertypes']) == $type['name']) ? 'selected' : '')
          : '')
      . ' value="' . $type['name'] . '">' . $type['name'] . '</option>';

}

echo '</select>';
?>

<?php

echo 'Sub Category: <select name="subtypes">';
echo '<option ';

if (isset($_GET['subtypes']))
{
  if (sanitizeInput($_GET['subtypes']) == "All")
  {
    echo "selected";
  }
}
else
{
  echo "selected";
} ?>
<?php echo 'value="All">All</option>'; ?>

<?php

global $pdo;

$stmt = $pdo->prepare("SELECT * FROM es_card_sub_types");
$stmt->execute();
$types = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($types as $type)
{

  echo '<option ' .
      ((isset($_GET['subtypes'])) ?
          ((sanitizeInput($_GET['subtypes']) == $type['name']) ? 'selected' : '')
          : '')
      . ' value="' . $type['name'] . '">' . $type['name'] . '</option>';

}

echo '</select>';
?>

  <input type="submit" name="search" value="search"></input>
</form><br>