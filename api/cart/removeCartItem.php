<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/cart.php';
include_once '../../models/user.php';

$cart = new Cart($db);
$user = new User($db);

$ip_address = getenv("REMOTE_ADDR");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    if (empty($data->id)) {
        http_response_code(422);
        echo json_encode(
            array('message' => 'Please enter all the required fields')
        );
    } else {
        if(is_int($data->id) != 1) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please provide and integer value for id')
            );
        } else {
            $cart->id = $data->id;
            if($user->isLoggedIn()) {
                $cart->user_id = $_SESSION['id'];
                $result = $cart->removeUserCartItem();
            } else {
                $cart->ip_address = $ip_address;
                $result = $cart->removeCartItem();
            }
            $row_count = $result->rowCount();
            if ($row_count > 0) {
                http_response_code(200);
                echo json_encode(
                    array('message' => 'Item removed')
                );
            } else {
                http_response_code(404);
                echo json_encode(
                    array('message' => 'No item found')
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