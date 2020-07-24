<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');

include_once '../../core/init.php';
include_once '../../models/category.php';

$category = new Category($db);

$result = $category->getCategory();
$row_count = $result->rowCount();

if ($row_count > 0) {
    $category_arr = array();
    $category_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $category = array(
            'id' => $id,
            'category_name' => $category_name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'deleted_at' => $deleted_at,
        );
        array_push($category_arr['data'], $category);
    }
    echo json_encode($category_arr);
} else {
    echo json_encode(
        array('message' => 'No categories to display.')
    );
}
