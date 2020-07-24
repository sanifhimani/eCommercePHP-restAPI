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
    $issetCondition = isset($data->flat_number) && isset($data->street_number) && isset($data->street_name) && isset($data->city) && isset($data->province) && isset($data->postal_code);
    $emptyCondition = empty($data->flat_number) || empty($data->street_number) || empty($data->street_name) || empty($data->city) || empty($data->province) || empty($data->postal_code);
    if ($issetCondition) {
        if ($emptyCondition) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please enter all the required fields')
            );
        } else {
            if (is_int($data->street_number) != 1) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please enter an integer value for street number')
                );
            } else if (strlen($data->postal_code) > 6) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please enter a valid postal code')
                );
            } else {
                $address->flat_number = $data->flat_number;
                $address->street_number = $data->street_number;
                $address->street_name = $data->street_name;
                $address->city = $data->city;
                $address->province = $data->province;
                $address->postal_code = $data->postal_code;
                $user_address->user_id = $_SESSION['id'];
                $address_result = $address->addressExists();
                $address_row_count = $address_result->rowCount();
                if ($address_row_count > 0) {
                    $row = $address_result->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    $address->id = $id;
                    $user_address->address_id = $id;
                    $mapping_result = $user_address->checkMappingExists();
                    $mapping_row_count = $mapping_result->rowCount();
                    if ($mapping_row_count > 0) {
                        http_response_code(200);
                        echo json_encode(
                            array('message' => 'Address already exists')
                        );
                    } else {
                        $address_mapping_result = $user_address->setAddressMapping();
                        $address_mapping_row_count = $address_mapping_result->rowCount();
                        if ($address_mapping_row_count > 0) {
                            http_response_code(201);
                            echo json_encode(
                                array('message' => 'New address added successfully')
                            );
                        } else {
                            http_response_code(500);
                            echo json_encode(
                                array('message' => 'Something went wrong')
                            );
                        }
                    }
                } else {
                    $last_id = $address->addAddressToDatabase();
                    if ($last_id == 0) {
                        http_response_code(500);
                        echo json_encode(
                            array('message' => 'Something went wrong')
                        );
                    } else {
                        $user_address->address_id = $last_id;
                        $mapping_result = $user_address->setAddressMapping();
                        $mapping_row_count = $mapping_result->rowCount();
                        if ($mapping_row_count > 0) {
                            http_response_code(201);
                            echo json_encode(
                                array('message' => 'New address added successfully')
                            );
                        } else {
                            http_response_code(500);
                            echo json_encode(
                                array('message' => 'Something went wrong')
                            );
                        }
                    }
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