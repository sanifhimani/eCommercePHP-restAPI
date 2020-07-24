<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');

include_once '../../core/init.php';
include_once '../../models/order.php';
include_once '../../models/user.php';
include_once '../../models/product.php';

$user = new User($db);
$order = new Order($db);
$product = new Product($db);

if ($user->isLoggedIn()) {
    $order_result = $order->viewPurchaseHistory();
    $order_row_count = $order_result->rowCount();
    if ($order_row_count > 0) {
        $order_arr = array();
        $order_arr['orderData'] = array();
        $address_arr = array();
        $product_arr = array();
        while ($order_row = $order_result->fetch(PDO::FETCH_ASSOC)) {
            extract($order_row);
            $product->id = $product_id;
            $product_result = $product->getSingleProduct();
            $product_row_count = $product_result->rowCount();
            if ($product_row_count > 0) {
                $product_row = $product_result->fetch(PDO::FETCH_ASSOC);
                $product_arr = $product_row;
            } else {
                http_response_code(404);
                echo json_encode(
                    array('message' => 'No products to display')
                );
            }
            array_push($order_arr['orderData'], array(
                'id' => $id,
                'order_number' => $order_number,
                'product_id' => $product_id,
                'user_id' => $user_id,
                'product_name' => $product_arr['product_name'],
                'product_image' => $product_arr['product_image'],
                'quatity' => $quantity,
                'total' => $product_cost * $quantity,
                'order_time' => $order_time,
                'order_status' => $order_status
            ));
        }
        echo json_encode($order_arr);
    } else {
        echo json_encode(
            array('message' => 'No previous order.')
        );
    }
} else {
    http_response_code(401);
    echo json_encode(
        array('message' => 'Please login to see the cart')
    );
}
?>