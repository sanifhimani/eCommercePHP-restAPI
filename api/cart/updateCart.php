<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/cart.php';
include_once '../../models/user.php';
include_once '../../models/product.php';

$cart = new Cart($db);
$user = new User($db);
$product = new Product($db);

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
                array('message' => 'Please provide an integer for product id')
            );
        } else if (is_int($data->quantity) != 1) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please provide an integer for quantity')
            );
        } else {
            $product->id = $data->product_id;
            $product_result = $product->getAvailableQuantity();
            $product_row_count = $product_result->rowCount();
            if ($product_row_count > 0) {
                $product_arr = array();
                $product_arr['data'] = array();
                extract($product_result->fetch(PDO::FETCH_ASSOC));
                $product->quantity_available = $quantity_available;
                if ($data->quantity < $product->quantity_available) {
                    $cart->product_id = $data->product_id;
                    $cart->quantity = $data->quantity;
                    if ($cart->quantity > 0) {
                        if($user->isLoggedIn()) {
                            $cart->user_id = $_SESSION['id'];
                            $cart_result = $cart->updateUserCart();
                        } else {
                            $cart->ip_address = $ip_address;
                            $cart_result = $cart->updateCart();
                        }
                        $cart_count = $cart_result->rowCount();
                        if ($cart_count > 0) {
                            http_response_code(201);
                            echo json_encode(
                                array('message' => 'Cart updated')
                            );
                        } else {
                            http_response_code(404);
                            echo json_encode(
                                array('message' => 'Could not find the product in your cart')
                            );
                        }
                    } else {
                        http_response_code(422);
                        echo json_encode(
                            array('message' => 'Please enter quantity greater than 0')
                        );
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(
                        array('message' => "Please enter quantity less than " . $product->quantity_available)
                    );
                }
            } else {
                http_response_code(404);
                echo json_encode(
                    array('message' => 'Product not available')
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