<?php
if (isset($_GET['search']) && ($_GET['search'] == "search"))
{

    global $pdo;

    // Define the search parameters
    $deckname = isset($_GET['deckname']) && !empty($_GET['deckname']) ? sanitizeInput($_GET['deckname']) : null;
    $containscard = isset($_GET['containscard']) && !empty($_GET['containscard']) ? sanitizeInput($_GET['containscard']) : null;
    //$format = isset($_GET['format']) && !empty($_GET['format']) ? sanitizeInput($_GET['format']) : null;

    // To add more parameters, follow the pattern above, replacing 'setid' with the parameter name.

    // Below handles values that are ALL meaning we don't search for it.


    $page = isset($_GET['page']) && !empty($_GET['page']) ? sanitizeInput((int)$_GET['page']) : 1;
    $limit = 36;
    $offset = ($page - 1) * $limit;

    // Prepare the SQL statement with optional conditions and pagination
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM es_decks WHERE 1=1";

    if ($deckname !== null)
    {
        $sql .= " AND deck_name LIKE :deckname";
    }

    if ($containscard !== null)
    {
        $sql .= " AND cards LIKE :containscard";
    }

    // if ($format === "Standard")
    // {
    //     $sql .= " AND standard_legality = 'Legal'";
    // }

    // if ($format === "Expanded")
    // {
    //     $sql .= " AND expanded_legality = 'Legal'";
    // }

    // if ($format === "Unlimited")
    // {
    //     $sql .= " AND unlimited_legality = 'Legal'";
    // }

    if (isset($_GET['standardfilter']))
    {
        $sql .= " AND standard_legality = 'Legal'";
    }
    else
    {
        $sql .= " AND standard_legality = 'Not Legal'";
    }

    if (isset($_GET['expandedfilter']))
    {
        $sql .= " AND expanded_legality = 'Legal'";
    }
    else
    {
        $sql .= " AND expanded_legality = 'Not Legal'";
    }


    if (isset($_GET['unlimitedfilter']))
    {
        $sql .= " AND unlimited_legality = 'Legal'";
    }
    else
    {
        $sql .= " AND unlimited_legality = 'Not Legal'";
    }


    // To add more conditions, follow the pattern above, replacing ':setid' and 'setid' with the parameter placeholder and field name respectively.

    $sql .= " LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);

    if ($deckname !== null)
    {
        $stmt->bindValue(':deckname', '%' . $deckname . '%', PDO::PARAM_STR);
    }

    if ($containscard !== null)
    {
        $stmt->bindValue(':containscard', '%' . $containscard . '%', PDO::PARAM_STR);
    }

    // To bind more parameters, follow the pattern above, replacing ':setid' and 'setid' with the parameter placeholder and variable respectively.

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of records
    $count_stmt = $pdo->query("SELECT FOUND_ROWS()");
    $total_records = (int)$count_stmt->fetchColumn();
    $total_pages = ceil($total_records / $limit);

    $has_previous_page = $page > 1;
    $has_next_page = $page < $total_pages;

    echo "<h2>Search Results: " . $total_records . " decks found!</h2>";
    echo "<br>";

    echo '<div style="text-align: center;">';

    // Pagination
    echo '<div class="pagination">';

    // Create the base URL for pagination links
    $base_url = "?search=search";

    // Append the parameters to the base URL if they are set and not empty
    // To add more search parameters, copy and modify the following line:
    // $base_url .= isset($parameter) && !empty($parameter) ? "&parameter=" . urlencode($parameter) : "";
    $base_url .= isset($deckname) && !empty($deckname) ? "&deckname=" . urlencode(strtolower($deckname)) : "";
    $base_url .= isset($containscard) && !empty($containscard) ? "&containscard=" . urlencode(strtolower($containscard)) : "";
    //$base_url .= isset($format) && !empty($format) ? "&format=" . urlencode($format) : "";
    $base_url .= isset($_GET['standardfilter']) ? "&standardfilter=1" : "";
    $base_url .= isset($_GET['expandedfilter']) ? "&expandedfilter=1" : "";
    $base_url .= isset($_GET['unlimitedfilter']) ? "&unlimitedfilter=1" : "";

    // If there's a previous page
    if ($has_previous_page)
    {
        $previous_page = $page - 1;
        // Create a link to the previous page, append page number at the end
        echo "<a href='{$base_url}&page={$previous_page}' style='margin-right: 10px;'>Previous</a>";
    }

    // Display the current page number and the total number of pages
    if ($total_records !== 0)
    {
        echo "Page {$page} of {$total_pages}";
    }


    // If there's a next page
    if ($has_next_page)
    {
        $next_page = $page + 1;
        // Create a link to the next page, append page number at the end
        echo "<a href='{$base_url}&page={$next_page}' style='margin-left: 10px;'>Next</a>";
    }

    echo '</div>';
    // End of pagination

    $RowNumVar = 0;
    foreach ($results as $deck)
    {
        echo '<span id="Deck" style="float: left; width: 205px; margin-right: 20px;">';

        echo "<a href='deck.php?ID=" . $deck['id'] . "'>" . '<img width="205" height="127" src=img/crop_card.php?ID=' . $deck['featuredcard'] . " alt=" . '"' . "FeaturedCard" . '"' . "></a><br>";
        echo "<a href='deck.php?ID=" . $deck['id'] . "'>" . limitStringLength(htmlspecialchars_decode($deck['deck_name']), 60) . "</a><br>";
        if ($deck['source_type'] == "YOUTUBE")
        {
            $video_info = json_decode($deck['source_info']);
            echo 'By: <a href="' . $video_info->channel_url . '" target="_blank">' . $video_info->channel_name . '</a>';
        }
        echo '</span>';

        $RowNumVar = $RowNumVar + 1;

        if ($RowNumVar == 6)
        {

            echo "<br style='clear: left;' /><br style='clear: left;' />";

            $RowNumVar = 0;
        }


    }

    if ($RowNumVar > 0)
    {
        echo "<br style='clear: left;' /><br style='clear: left;' />";
    }

    echo "<br>";

    // Pagination
    echo '<div class="pagination">';

    // Create the base URL for pagination links
    $base_url = "?search=search";

    // Append the parameters to the base URL if they are set and not empty
    // To add more search parameters, copy and modify the following line:
    // $base_url .= isset($parameter) && !empty($parameter) ? "&parameter=" . urlencode($parameter) : "";
    $base_url .= isset($deckname) && !empty($deckname) ? "&deckname=" . urlencode(strtolower($deckname)) : "";
    $base_url .= isset($containscard) && !empty($containscard) ? "&containscard=" . urlencode(strtolower($containscard)) : "";
    //$base_url .= isset($format) && !empty($format) ? "&format=" . urlencode($format) : "";
    $base_url .= isset($_GET['standardfilter']) ? "&standardfilter=1" : "";
    $base_url .= isset($_GET['expandedfilter']) ? "&expandedfilter=1" : "";
    $base_url .= isset($_GET['unlimitedfilter']) ? "&unlimitedfilter=1" : "";

    // If there's a previous page
    if ($has_previous_page)
    {
        $previous_page = $page - 1;
        // Create a link to the previous page, append page number at the end
        echo "<a href='{$base_url}&page={$previous_page}' style='margin-right: 10px;'>Previous</a>";
    }

    // Display the current page number and the total number of pages
    if ($total_records !== 0)
    {
        echo "Page {$page} of {$total_pages}";
    }

    // If there's a next page
    if ($has_next_page)
    {
        $next_page = $page + 1;
        // Create a link to the next page, append page number at the end
        echo "<a href='{$base_url}&page={$next_page}' style='margin-left: 10px;'>Next</a>";
    }

    echo '</div>';
    // End of pagination


    echo '</div>';


}
?>