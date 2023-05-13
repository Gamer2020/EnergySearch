<?php
if (isset($_GET['search']) && ($_GET['search'] == "search"))
{

    global $pdo;

    // Define the search parameters
    $cardname = isset($_GET['cardname']) && !empty($_GET['cardname']) ? sanitizeInput($_GET['cardname']) : null;
    $setid = isset($_GET['setid']) && !empty($_GET['setid']) ? sanitizeInput($_GET['setid']) : null;
    $type = isset($_GET['type']) && !empty($_GET['type']) ? sanitizeInput($_GET['type']) : null;
    $weakness = isset($_GET['weakness']) && !empty($_GET['weakness']) ? sanitizeInput($_GET['weakness']) : null;
    $resistance = isset($_GET['resistance']) && !empty($_GET['resistance']) ? sanitizeInput($_GET['resistance']) : null;
    $supertypes = isset($_GET['supertypes']) && !empty($_GET['supertypes']) ? sanitizeInput($_GET['supertypes']) : null;
    $subtypes = isset($_GET['subtypes']) && !empty($_GET['subtypes']) ? sanitizeInput($_GET['subtypes']) : null;

    // To add more parameters, follow the pattern above, replacing 'setid' with the parameter name.

    // Below handles values that are ALL meaning we don't search for it.
    if ($setid === "All")
    {
        $setid = null;
    }

    if ($type === "All")
    {
        $type = null;
    }

    if ($weakness === "All")
    {
        $weakness = null;
    }

    if ($resistance === "All")
    {
        $resistance = null;
    }

    if ($supertypes === "All")
    {
        $supertypes = null;
    }

    if ($subtypes === "All")
    {
        $subtypes = null;
    }

    $page = isset($_GET['page']) && !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 40;
    $offset = ($page - 1) * $limit;

    // Prepare the SQL statement with optional conditions and pagination
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM es_cards WHERE 1=1";

    if ($cardname !== null)
    {
        $sql .= " AND name LIKE :cardname";
    }

    if ($setid !== null)
    {
        $sql .= " AND set_id = :setid";
    }

    if ($type !== null)
    {
        $sql .= " AND types LIKE :type";
    }

    if ($weakness !== null)
    {
        $sql .= " AND weakness LIKE :weakness";
    }

    if ($resistance !== null)
    {
        $sql .= " AND resistance LIKE :resistance";
    }

    if ($supertypes !== null)
    {
        $sql .= " AND supertype = :supertypes";
    }

    if ($subtypes !== null)
    {
        $sql .= " AND subtypes LIKE :subtypes";
    }

    // To add more conditions, follow the pattern above, replacing ':setid' and 'setid' with the parameter placeholder and field name respectively.

    $sql .= " LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);

    if ($cardname !== null)
    {
        $stmt->bindValue(':cardname', '%' . $cardname . '%', PDO::PARAM_STR);
    }

    if ($setid !== null)
    {
        $stmt->bindValue(':setid', $setid, PDO::PARAM_STR);
    }

    if ($type !== null)
    {
        $stmt->bindValue(':type', '%' . $type . '%', PDO::PARAM_STR);
    }

    if ($weakness !== null)
    {
        $stmt->bindValue(':weakness', '%' . $weakness . '%', PDO::PARAM_STR);
    }

    if ($resistance !== null)
    {
        $stmt->bindValue(':resistance', '%' . $resistance . '%', PDO::PARAM_STR);
    }

    if ($supertypes !== null)
    {
        $stmt->bindValue(':supertypes', $supertypes, PDO::PARAM_STR);
    }

    if ($subtypes !== null)
    {
        $stmt->bindValue(':subtypes', '%' . $subtypes . '%', PDO::PARAM_STR);
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

    echo "<h2>Search Results: " . $total_records . " cards found!</h2>";
    echo "<br>";

    echo '<div style="text-align: center;">';

    // Pagination
    echo '<div class="pagination">';

    // Create the base URL for pagination links
    $base_url = "?search=search";

    // Append the parameters to the base URL if they are set and not empty
    // To add more search parameters, copy and modify the following line:
    // $base_url .= isset($parameter) && !empty($parameter) ? "&parameter=" . urlencode($parameter) : "";
    $base_url .= isset($cardname) && !empty($cardname) ? "&cardname=" . urlencode(strtolower($cardname)) : "";
    $base_url .= isset($set_id) && !empty($set_id) ? "&set_id=" . urlencode($set_id) : "";
    $base_url .= isset($type) && !empty($type) ? "&set_id=" . urlencode($type) : "";
    $base_url .= isset($weakness) && !empty($weakness) ? "&set_id=" . urlencode($weakness) : "";
    $base_url .= isset($resistance) && !empty($resistance) ? "&set_id=" . urlencode($resistance) : "";
    $base_url .= isset($supertypes) && !empty($supertypes) ? "&set_id=" . urlencode($supertypes) : "";
    $base_url .= isset($subtypes) && !empty($subtypes) ? "&set_id=" . urlencode($subtypes) : "";

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


    foreach ($results as $card)
    {
        echo "<a href='card.php" . "?ID=" . $card['id'] . "'>" . '<img width="250" height="350" src=' . $card['small_image'] . "" . " alt=" . '"' . $card['name'] . '"' . ">" . "</a>";
    }

    echo "<br>";

    // Pagination
    echo '<div class="pagination">';

    // Create the base URL for pagination links
    $base_url = "?search=search";

    // Append the parameters to the base URL if they are set and not empty
    // To add more search parameters, copy and modify the following line:
    // $base_url .= isset($parameter) && !empty($parameter) ? "&parameter=" . urlencode($parameter) : "";
    $base_url .= isset($cardname) && !empty($cardname) ? "&cardname=" . urlencode(strtolower($cardname)) : "";
    $base_url .= isset($set_id) && !empty($set_id) ? "&set_id=" . urlencode($set_id) : "";
    $base_url .= isset($type) && !empty($type) ? "&set_id=" . urlencode($type) : "";
    $base_url .= isset($weakness) && !empty($weakness) ? "&set_id=" . urlencode($weakness) : "";
    $base_url .= isset($resistance) && !empty($resistance) ? "&set_id=" . urlencode($resistance) : "";
    $base_url .= isset($supertypes) && !empty($supertypes) ? "&set_id=" . urlencode($supertypes) : "";
    $base_url .= isset($subtypes) && !empty($subtypes) ? "&set_id=" . urlencode($subtypes) : "";

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

    // Encode the results and pagination information as a JSON string and output it
    // echo json_encode([
    //     'results' => $results,
    //     'page' => $page,
    //     'totalPages' => $total_pages,
    //     'hasPreviousPage' => $has_previous_page,
    //     'hasNextPage' => $has_next_page,
    // ]);
}
?>