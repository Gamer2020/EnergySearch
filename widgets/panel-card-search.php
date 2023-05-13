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
  // echo 'Weakness: <select name="weakness">';
  
  // echo '<option'; ?>
  <?php //if (isset($_GET['weakness'])) {
  //        if (sanitize_text_field($_GET['weakness']) == "All") {
  //            echo "selected";
  //        }
  //    } else {
  //        echo "selected";
  //    } ?>
  <?php //echo 'value="All">All</option>';
  
  //     foreach ($types as $type) {
  
  //         echo '<option ' .
  //             ((isset($_GET['weakness'])) ?
  //                 ((sanitize_text_field($_GET['weakness']) == $type) ? 'selected' : '')
  //                 : '')
  //             . ' value="' . $type . '">' . $type . '</option>';
  
  //     }
  
  //     echo '</select>';
  ?>

  <?php
  // echo 'Resistance: <select name="resistance">';
  
  // echo '<option'; ?>
  <?php //if (isset($_GET['resistance'])) {
  //        if (sanitize_text_field($_GET['resistance']) == "All") {
  //            echo "selected";
  //        }
  //    } else {
  //        echo "selected";
  //    } ?>
  <?php //echo 'value="All">All</option>';
  
  //     foreach ($types as $type) {
  
  //         echo '<option ' .
  //             ((isset($_GET['resistance'])) ?
  //                 ((sanitize_text_field($_GET['resistance']) == $type) ? 'selected' : '')
  //                 : '')
  //             . ' value="' . $type . '">' . $type . '</option>';
  
  //     }
  
  //     echo '</select>';
  ?>

  <?php
  // $supertypes = Pokemon::Supertype()->all();
  
  // echo 'Category: <select name="cat">';
  
  // echo '<option'; ?>
  <?php //if (isset($_GET['cat'])) {
  //        if (sanitize_text_field($_GET['cat']) == "All") {
  //            echo "selected";
  //        }
  //    } else {
  //        echo "selected";
  //    } ?>
  <?php //echo 'value="All">All</option>';
  
  //     foreach ($supertypes as $supertype) {
  
  //         echo '<option ' .
  //             ((isset($_GET['cat'])) ?
  //                 ((sanitize_text_field($_GET['cat']) == $supertype) ? 'selected' : '')
  //                 : '')
  //             . ' value="' . $supertype . '">' . $supertype . '</option>';
  
  //     }
  
  //     echo '</select>';
  ?>

  <?php
  // $subtypes = Pokemon::Subtype()->all();
  
  // echo 'Sub Category: <select name="subcat">';
  
  // echo '<option'; ?>
  <?php //if (isset($_GET['subcat'])) {
  //        if (sanitize_text_field($_GET['subcat']) == "All") {
  //            echo "selected";
  //        }
  //    } else {
  //        echo "selected";
  //    }     ?>
  <?php //echo 'value="All">All</option>';
  
  //     foreach ($subtypes as $subtype) {
  
  //         echo '<option ' .
  //             ((isset($_GET['subcat'])) ?
  //                 ((sanitize_text_field($_GET['subcat']) == $subtype) ? 'selected' : '')
  //                 : '')
  //             . ' value="' . $subtype . '">' . $subtype . '</option>';
  
  //     }
  
  //     echo '</select>';
  ?>

  <input type="submit" name="search" value="search"></input>
</form><br>