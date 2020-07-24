<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/product.php';

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    if(empty($data->id)) {
        http_response_code(422);
        echo json_encode(
            array('message' => 'Please select a product')
        );
    } else {
        if(is_int($data->id) != 1) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please provide an integer value for product id')
            );
        } else {
            $product->id = $data->id;
            $result = $product->getSingleProduct();
            $row_count = $result->rowCount();
            if ($row_count > 0) {
                $product_arr = array();
                $product_arr['data'] = array();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $product = array(
                        'id' => $id,
                        'product_name' => $product_name,
                        'product_description' => $product_description,
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
                    array('message' => 'No product to display.')
                );
            }
        }
    }
} else {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Please select a product')
    );
}
?>