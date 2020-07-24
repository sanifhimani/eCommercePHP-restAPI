<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');

include_once '../../core/init.php';
include_once '../../models/user.php';
include_once '../../models/userAddress.php';
include_once '../../models/address.php';

$user = new User($db);
$user_address = new UserAddress($db);
$address = new Address($db);
$user_details_arr = array();

if ($user->isLoggedIn()) {
    $user->id = $_SESSION['id'];
    $user_result = $user->getUserDetails();
    $user_row_count = $user_result->rowCount();
    if ($user_row_count > 0) {
        $user_details_arr['userData'] = array();
        $user_row = $user_result->fetch(PDO::FETCH_ASSOC);
        extract($user_row);
        $user_arr = array(
            'id' => $id,
            'email_address' => $email_address,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'deleted_at' => $deleted_at,
        );
        $user_address->user_id = $id;
        $user_address_result = $user_address->getUserAddressDetails();
        $user_address_row_count = $user_address_result->rowCount();
        if ($user_address_row_count > 0) {
            $user_details_arr['addresses'] = array();
            while ($user_address_row = $user_address_result->fetch(PDO::FETCH_ASSOC)) {
                extract($user_address_row);
                $address->id = $address_id;
                $address_result = $address->getAddressDetails();
                $address_row_count = $address_result->rowCount();
                if ($address_row_count > 0) {
                    $address_row = $address_result->fetch(PDO::FETCH_ASSOC);
                    extract($address_row);
                    $address_arr = array(
                        'mapping_id' => $mapping_id,
                        'id' => $id,
                        'flat_number' => $flat_number,
                        'street_number' => $street_number,
                        'street_name' => $street_name,
                        'city' => $city,
                        'province' => $province,
                        'postal_code' => $postal_code,
                    );
                }
                array_push($user_details_arr['addresses'], $address_arr);
            }
        } else {
            $user_details_arr['message'] = array(
                "message" => "No addresses found",
            );
        }
        array_push($user_details_arr['userData'], $user_arr);
    }

    echo json_encode($user_details_arr);
} else {
    http_response_code(401);
    echo json_encode(
        array("message" => "Please login to access")
    );
}
?>