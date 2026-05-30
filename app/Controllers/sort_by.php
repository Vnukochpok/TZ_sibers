<?php
/*File for sorting users in admin panel*/

// Function for get sort order based on query parameter
function getSortOrder($sort_by) {
    $allowed_sorts = ['id', 'login', 'name', 'surname', 'birthday'];
    
    if (!in_array($sort_by, $allowed_sorts)) {
        $sort_by = 'id';
    }
    
    if ($sort_by == 'pers_data') {
        $order_by = "ORDER BY JSON_EXTRACT(pers_data, '$.birthday') DESC";
    } else if ($sort_by == 'name') {
        $order_by = "ORDER BY JSON_EXTRACT(pers_data, '$.name') DESC";
    } else if ($sort_by == 'surname') {
        $order_by = "ORDER BY JSON_EXTRACT(pers_data, '$.surname') DESC";
    } else if ($sort_by == 'birthday') {
        $order_by = "ORDER BY JSON_EXTRACT(pers_data, '$.birthday') DESC";
    } else if ($sort_by == 'login') {
        $order_by = "ORDER BY login DESC";
    } else {
        $order_by = "ORDER BY $sort_by DESC";
    }
    
    return [
        'sort_by' => $sort_by,
        'order_by' => $order_by
    ];
}

function renderSortButtons($current_sort) {
    echo '<div style="margin: 20px 0;">';
    echo '<p>Sort by: ';
    echo '<a href="?sort=id&page=1">ID</a> | ';
    echo '<a href="?sort=login&page=1">Login</a> | ';
    echo '<a href="?sort=name&page=1">Name</a> | ';
    echo '<a href="?sort=surname&page=1">Surname</a> | ';
    echo '<a href="?sort=birthday&page=1">Birthday</a> | ';
    echo '</p></div>';
}
