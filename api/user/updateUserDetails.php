<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/user.php';

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if ($user->isLoggedIn()) {
    if (isset($data->first_name) && isset($data->last_name)) {
        if (empty($data->first_name) || empty($data->last_name)) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please enter all the required fields')
            );
        } else {
            $user->first_name = $data->first_name;
            $user->last_name = $data->last_name;
            if ($user->updateUserDetails()) {
                http_response_code(200);
                echo json_encode(
                    array('message' => 'Details Updated Successfully')
                );
            } else {
                http_response_code(500);
                echo json_encode(
                    array('message' => 'Could not process the request. Please try after sometime.')
                );
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
        array("message" => "Please login to access")
    );
}
?>