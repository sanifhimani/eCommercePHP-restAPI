<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');

include_once '../../core/init.php';
include_once '../../models/product.php';

$product = new Product($db);

$result = $product->getAllProducts();
$row_count = $result->rowCount();
if ($row_count > 0) {
    $product_arr = array();
    $product_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product = array(
            'id' => $id,
            'product_name' => $product_name,
            'product_image' => $product_image,
            'cost' => $cost,
            'quantity_available' => $quantity_available,
        );
        array_push($product_arr['data'], $product);
    }
    echo json_encode($product_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'No products to display')
    );
}
?>