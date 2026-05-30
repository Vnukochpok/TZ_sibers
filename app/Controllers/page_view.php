<?php
/*File for calculate pagination and render pagination links*/

// Calculate pagination parameters
function calculatePagination($total_users, $users_per_page, $current_page) {
    $total_pages = ceil($total_users / $users_per_page);
    
    if ($current_page < 1) $current_page = 1;
    if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
    
    $offset = ($current_page - 1) * $users_per_page;
    
    return [
        'total_pages' => $total_pages,
        'current_page' => $current_page,
        'offset' => $offset
    ];
}

// Function for render pagination links
function renderPagination($total_pages, $current_page, $sort_by) {
    if ($total_pages <= 1) return;
    
    echo '<div style="margin: 20px 0;">';
    echo '<strong>Pages: </strong>';
    
    // Render first and previous buttons
    if ($current_page > 1) {
        echo '<a href="?page=1&sort=' . $sort_by . '">[First]</a> ';
        echo '<a href="?page=' . ($current_page - 1) . '&sort=' . $sort_by . '">[Previous]</a> ';
    }
    
    // Show 5 numbered page links around the current page
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $current_page + 2);
    
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            echo "<strong>[$i]</strong> ";
        } else {
            echo '<a href="?page=' . $i . '&sort=' . $sort_by . '">[' . $i . ']</a> ';
        }
    }
    
    // Render last and next buttons
    if ($current_page < $total_pages) {
        echo '<a href="?page=' . ($current_page + 1) . '&sort=' . $sort_by . '">[Next]</a> ';
        echo '<a href="?page=' . $total_pages . '&sort=' . $sort_by . '">[Last]</a>';
    }

    echo '</div>';
}