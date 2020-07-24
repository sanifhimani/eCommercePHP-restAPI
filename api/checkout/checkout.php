<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/cart.php';
include_once '../../models/user.php';
include_once '../../models/userAddress.php';
include_once '../../models/product.php';
include_once '../../models/order.php';

$user = new User($db);
$user_address = new UserAddress($db);
$cart = new Cart($db);
$product = new Product($db);
$order = new Order($db);

$order_number = rand(pow(10, 9), pow(10, 10)-1);

if($user->isLoggedIn()) {
    $cart->user_id = $_SESSION['id'];
    $cart_result = $cart->getUserCart();
    $cart_row_count = $cart_result->rowCount();
    if($cart_row_count > 0) {
        $user_address->user_id = $_SESSION['id'];
        $user_address_result = $user_address->getUserAddressDetails();
        $user_address_count = $user_address_result->rowCount();
        if($user_address_count > 0) {
            $user_address_row = $user_address_result->fetch(PDO::FETCH_ASSOC);
            $order->order_number = $order_number;
            $order->user_id = $_SESSION['id'];
            $order->address_id = $user_address_row['address_id'];
            $order->order_status = 'Order Confirmed';
            $response_array = array();
            while($cart_row = $cart_result->fetch(PDO::FETCH_ASSOC)) {
                $cart->id = $cart_row['id'];
                $product->id = $cart_row['product_id'];
                $product_result = $product->getProductCost();
                $product_result_count = $product_result->rowCount();
                if($product_result_count > 0) {
                    $product_row = $product_result->fetch(PDO::FETCH_ASSOC);
                    $order->product_id = $cart_row['product_id'];
                    $order->quantity = $cart_row['quantity'];
                    $order->product_cost = $product_row['cost'];
                    if ($order->addOrder()) {
                        $product->id = $cart_row['product_id'];
                        $quantity_result = $product->getAvailableQuantity();
                        $quantity_count = $quantity_result->rowCount();
                        if($quantity_count > 0) {
                            $quantity_row = $quantity_result->fetch(PDO::FETCH_ASSOC);
                            $product->quantity_available = $quantity_row['quantity_available'] - $cart_row['quantity'];
                            $product->changeAvailableQuantity();
                        }
                        $remove_result = $cart->removeUserCartItem();
                        $remove_count = $remove_result->rowCount();
                        if($remove_count > 0) {
                            http_response_code(201);
                            $response_array = array('message' => 'Order placed successfully!');
                        } else {
                            http_response_code(500);
                            $response_array = array('message' => 'Something went wrong');
                        }
                    } else {
                        http_response_code(500);
                        $response_array = array('message' => 'Something went wrong');
                    }
                } else {
                    http_response_code(500);
                    $response_array = array("message" => "Something went wrong. Product could not be found");
                }
            }
            echo json_encode($response_array);
        } else {
            http_response_code(404);
            echo json_encode(
                array('message' => 'No addresses found! Please add an address to checkout')
            );
        }
    } else {
        http_response_code(404);
        echo json_encode(
            array('message' => 'Cart is empty! Add products to cart to checkout')
        );
    }
} else {
    http_response_code(401);
    echo json_encode(
        array('message' => 'Please login to checkout')
    );
}
?>