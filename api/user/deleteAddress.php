<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/user.php';
include_once '../../models/address.php';
include_once '../../models/userAddress.php';

$user = new User($db);
$address = new Address($db);
$user_address = new UserAddress($db);

$data = json_decode(file_get_contents("php://input"));

if ($user->isLoggedIn()) {
    if (isset($data->address_id)) {
        if (empty($data->address_id)) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please enter all the required fields')
            );
        } else {
            if (is_int($data->address_id) != 1) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please enter an integer value')
                );
            } else {
                $address->id = $data->address_id;
                $user_address->user_id = $_SESSION['id'];
                $user_address->address_id = $data->address_id;
                $address_result = $address->checkAddressById();
                $address_row_count = $address_result->rowCount();
                if ($address_row_count > 0) {
                    $mapping_result = $user_address->deleteAddressMapping();
                    $mapping_count = $mapping_result->rowCount();
                    if ($mapping_count > 0) {
                        http_response_code(200);
                        echo json_encode(
                            array('message' => 'Address deleted successfully')
                        );
                    } else {
                        http_response_code(404);
                        echo json_encode(
                            array('message' => 'Could not find that address')
                        );
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(
                        array('message' => 'No address with this ID found. Please enter a valid address id')
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
        array('message' => 'Please login to access')
    );
}
?>