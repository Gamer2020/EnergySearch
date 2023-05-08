<?php
if (isset($_GET['search']) && ($_GET['search'] == "search")) {

    global $pdo;

    // Get the search query and page number from the URL and check if they are set and not empty
    $cardname = isset($_GET['cardname']) && !empty($_GET['cardname']) ? sanitizeInput($_GET['cardname']) : null;

    $page = isset($_GET['page']) && !empty($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = 40;
    $offset = ($page - 1) * $limit;

    // Prepare the SQL statement with optional conditions and pagination
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM es_cards WHERE 1=1";

    if ($cardname !== null) {
        $sql .= " AND name LIKE :cardname";
    }

    $sql .= " LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);

    if ($cardname !== null) {
        $stmt->bindValue(':cardname', '%' . $cardname . '%', PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of records
    $count_stmt = $pdo->query("SELECT FOUND_ROWS()");
    $total_records = (int) $count_stmt->fetchColumn();
    $total_pages = ceil($total_records / $limit);

    $has_previous_page = $page > 1;
    $has_next_page = $page < $total_pages;

    echo "<h2>Search Results: " . $total_records . " cards found!</h2>";
    echo "<br>";

    echo '<div style="text-align: center;">';

    echo '<div class="pagination">';

    if ($has_previous_page) {
        $previous_page = $page - 1;
        echo "<a href='?search=search&page={$previous_page}&cardname=" . urlencode(strtolower($cardname)) . "' style='margin-right: 10px;'>Previous</a>";
    }

    echo "Page {$page} of {$total_pages}";

    if ($has_next_page) {
        $next_page = $page + 1;
        echo "<a href='?search=search&page={$next_page}&cardname=" . urlencode(strtolower($cardname)) . "' style='margin-left: 10px;'>Next</a>";
    }

    echo '</div>';


    foreach ($results as $card) {
        echo "<a href='card.php" . "?ID=" . $card['id'] . "'>" . '<img width="250" height="350" src=' . $card['small_image'] . "" . " alt=" . '"' . $card['name'] . '"' . ">" . "</a>";

    }

    echo "<br>";

    echo '<div class="pagination">';

    if ($has_previous_page) {
        $previous_page = $page - 1;
        echo "<a href='?search=search&page={$previous_page}&cardname=" . urlencode(strtolower($cardname)) . "' style='margin-right: 10px;'>Previous</a>";
    }

    echo "Page {$page} of {$total_pages}";

    if ($has_next_page) {
        $next_page = $page + 1;
        echo "<a href='?search=search&page={$next_page}&cardname=" . urlencode(strtolower($cardname)) . "' style='margin-left: 10px;'>Next</a>";
    }

    echo '</div>';

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