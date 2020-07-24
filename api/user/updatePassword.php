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
    if (isset($data->old_password) && isset($data->new_password) && isset($data->confirm_password)) {
        if (empty($data->old_password) || empty($data->new_password) || empty($data->confirm_password)) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please enter all the required fields')
            );
        } else {
            $user->password = $data->new_password;
            $result = $user->checkPassword($data->old_password);
            $row_count = $result->rowCount();
            if ($row_count <= 0) {
                http_response_code(400);
                echo json_encode(
                    array('message' => 'Incorrect password! Please enter a correct password')
                );
            } else if ($data->new_password != $data->confirm_password) {
                http_response_code(400);
                echo json_encode(
                    array('message' => 'Your passwords do not match')
                );
            } else if ($user->updateUserPassword()) {
                http_response_code(200);
                echo json_encode(
                    array('message' => 'Details Updated Successfully')
                );
                header('Location: logout.php');
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