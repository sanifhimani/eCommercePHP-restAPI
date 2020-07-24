<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/order.php';
include_once '../../models/user.php';
include_once '../../models/product.php';
include_once '../../models/address.php';

$user = new User($db);
$order = new Order($db);
$product = new Product($db);
$address = new Address($db);

$data = json_decode(file_get_contents("php://input"));

if ($user->isLoggedIn()) {
    if (isset($data->id)) {
        if (empty($data->id)) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please enter all the required fields')
            );
        } else {
            if (is_int($data->id) != 1) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please provide an integer value for id')
                );
            } else {
                $order->id = $data->id;
                $order->user_id = $_SESSION['id'];
                $order_result = $order->viewParticularPurchaseHistory();
                $order_row_count = $order_result->rowCount();
                if ($order_row_count > 0) {
                    $order_arr = array();
                    $order_arr['orderData'] = array();
                    $address_arr = array();
                    $product_arr = array();
                    while ($order_row = $order_result->fetch(PDO::FETCH_ASSOC)) {
                        extract($order_row);
                        $address->id = $address_id;
                        $address_result = $address->getAddressDetails();
                        $address_row_count = $address_result->rowCount();
                        if ($address_row_count > 0) {
                            $address_row = $address_result->fetch(PDO::FETCH_ASSOC);
                            $address_arr = $address_row;
                        } else {
                            echo json_encode(
                                array('message' => 'No address')
                            );
                        }
                        $product->id = $product_id;
                        $product_result = $product->getSingleProduct();
                        $product_row_count = $product_result->rowCount();
                        if ($product_row_count > 0) {
                            $product_row = $product_result->fetch(PDO::FETCH_ASSOC);
                            $product_arr = $product_row;
                        } else {
                            echo json_encode(
                                array('message' => 'No products.')
                            );
                        }
                        array_push($order_arr['orderData'], array(
                            'order_number' => $order_number,
                            'product_id' => $product_id,
                            'product_name' => $product_arr['product_name'],
                            'product_image' => $product_arr['product_image'],
                            'quatity' => $quantity,
                            'total' => $product_cost * $quantity,
                            'order_time' => $order_time,
                            'order_status' => $order_status,
                            'flat_number' => $address_arr['flat_number'],
                            'street_number' => $address_arr['street_number'],
                            'street_name' => $address_arr['street_name'],
                            'city' => $address_arr['city'],
                            'province' => $address_arr['province'],
                            'postal_code' => $address_arr['postal_code'],
                        ));
                    }
                    echo json_encode($order_arr);
                } else {
                    echo json_encode(
                        array('message' => 'Order not available')
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
} else {
    http_response_code(401);
    echo json_encode(
        array('message' => 'Please login to see the cart')
    );
}
?>