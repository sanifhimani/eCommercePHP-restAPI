<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/user.php';

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->email_address) && isset($data->password) && isset($data->first_name) && isset($data->last_name)) {
    if (empty($data->email_address) || empty($data->password) || empty($data->first_name) || empty($data->last_name)) {
        http_response_code(422);
        echo json_encode(
            array('message' => 'Please enter all the required fields')
        );
    } else {
        $user->email_address = $data->email_address;
        $user->password = $data->password;
        $user->first_name = $data->first_name;
        $user->last_name = $data->last_name;
        if ($user->isLoggedIn()) {
            http_response_code(400);
            echo json_encode(
                array('message' => 'You are currently logged in. Please logout')
            );
        } else {
            if (!$user->isEmailValid()) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please enter a valid email address')
                );
            } else if (strlen($user->password) < 8) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Your password must be at least 8 characters long.')
                );
            } else {
                $result = $user->isRegistered();
                $row_count = $result->rowCount();
                if ($row_count > 0) {
                    http_response_code(422);
                    echo json_encode(
                        array('message' => 'You\'ve already registered. Please try to login')
                    );
                } else {
                    if ($user->registerUser()) {
                        http_response_code(201);
                        echo json_encode(
                            array('message' => 'User Registered successfully')
                        );
                    } else {
                        http_response_code(500);
                        echo json_encode(
                            array('message' => 'User could not be registered')
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
?>