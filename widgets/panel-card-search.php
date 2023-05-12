<h2>Card Search</h2>
<!-- The form -->
<form action="cards.php">
  <input type="text" placeholder="Card Name..." name="cardname"
    value="<?php echo (isset($_GET['cardname']) ? $_GET['cardname'] : '') ?>">
  <!--<input type="text" placeholder="Card text..." name="cardtext" value="<?php //echo (isset($_GET['cardtext']) ? sanitize_text_field($_GET['cardtext']) : '') ?>">-->

  <?php //echo 'Set: <select name="setcode">';
  //echo '<option'; ?> <?php //if (isset($_GET['setcode'])) {
   //if (sanitize_text_field($_GET['setcode']) == "All") {
   //    echo "selected";
   //}
   // } else {
   //echo "selected";
   //} ?>

  <?php

  // $sets = Pokemon::Set()->all();
  
  // foreach ($sets as $model) {
  //     $set = $model->toArray();
  
  //     echo '<option ' .
  //         ((isset($_GET['setcode'])) ?
  //             ((sanitize_text_field($_GET['setcode']) == $set['code']) ? 'selected' : '')
  //             : '')
  //         . ' value="' . $set['code'] . '">' . $set['name'] . '</option>';
  
  // }
  // echo '</select>';
  ?>

  <?php
  // $types = Pokemon::Type()->all();
  
  // echo 'Type: <select name="type">';
  
  // echo '<option'; ?> <?php //if (isset($_GET['type'])) {
   //        if (sanitize_text_field($_GET['type']) == "All") {
   //            echo "selected";
   //        }
   //    } else {
   //        echo "selected";
   //    } ?> <?php //echo 'value="All">All</option>';
    
    //     foreach ($types as $type) {
    
    //         echo '<option ' .
    //             ((isset($_GET['type'])) ?
    //                 ((sanitize_text_field($_GET['type']) == $type) ? 'selected' : '')
    //                 : '')
    //             . ' value="' . $type . '">' . $type . '</option>';
    
    //     }
    
    //     echo '</select>';
    ?>

  <?php
  // echo 'Weakness: <select name="weakness">';
  
  // echo '<option'; ?> <?php //if (isset($_GET['weakness'])) {
   //        if (sanitize_text_field($_GET['weakness']) == "All") {
   //            echo "selected";
   //        }
   //    } else {
   //        echo "selected";
   //    } ?> <?php //echo 'value="All">All</option>';
    
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
  
  // echo '<option'; ?> <?php //if (isset($_GET['resistance'])) {
   //        if (sanitize_text_field($_GET['resistance']) == "All") {
   //            echo "selected";
   //        }
   //    } else {
   //        echo "selected";
   //    } ?> <?php //echo 'value="All">All</option>';
    
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
  
  // echo '<option'; ?> <?php //if (isset($_GET['cat'])) {
   //        if (sanitize_text_field($_GET['cat']) == "All") {
   //            echo "selected";
   //        }
   //    } else {
   //        echo "selected";
   //    } ?> <?php //echo 'value="All">All</option>';
    
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
  
  // echo '<option'; ?> <?php //if (isset($_GET['subcat'])) {
   //        if (sanitize_text_field($_GET['subcat']) == "All") {
   //            echo "selected";
   //        }
   //    } else {
   //        echo "selected";
   //    }     ?> <?php //echo 'value="All">All</option>';
    
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