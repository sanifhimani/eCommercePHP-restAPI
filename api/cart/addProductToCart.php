<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/cart.php';
include_once '../../models/user.php';

$user = new User($db);
$cart = new Cart($db);

$ip_address = getenv("REMOTE_ADDR");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->product_id) && isset($data->quantity)) {
    if (empty($data->product_id) || empty($data->quantity)) {
        http_response_code(422);
        echo json_encode(
            array('message' => 'Please enter all the required fields')
        );
    } else {
        if(is_int($data->product_id) != 1) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please enter an integer value for product id')
            );
        } else if (is_int($data->quantity) != 1) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please enter an integer value for quantity')
            );
        } else {
            $cart->product_id = $data->product_id;
            $cart->quantity = $data->quantity;
            $cart_result = false;
            if($user->isLoggedIn()) {
                $cart->user_id = $_SESSION['id'];
                $cart_result = $cart->addProductToUserCart();
            } else {
                $cart->ip_address = $ip_address;
                $cart_result = $cart->addProductToCart();
            }
            if ($cart_result) {
                http_response_code(201);
                echo json_encode(
                    array('message' => 'Product added to cart')
                );
            } else {
                http_response_code(500);
                echo json_encode(
                    array('message' => 'Failed to add product to cart')
                );
            }
        }
    }
} else {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Please enter all the required fields')
    );
}
?>