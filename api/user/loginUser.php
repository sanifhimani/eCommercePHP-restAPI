<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/user.php';

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->email_address) && isset($data->password)) {
    if (empty($data->email_address) || empty($data->password)) {
        http_response_code(422);
        echo json_encode(
            array('message' => 'Please enter all the required fields')
        );
    } else {
        $user->email_address = $data->email_address;
        $user->password = $data->password;
        if ($user->isLoggedIn()) {
            http_response_code(400);
            echo json_encode(
                array('message' => 'You are currently logged in.')
            );
        } else {
            if (!$user->isEmailValid()) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please enter a valid email address')
                );
            } else {
                $result = $user->loginUser();
                $row_count = $result->rowCount();
                if ($row_count > 0) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    $_SESSION['id'] = $id;
                    http_response_code(202);
                    echo json_encode(
                        array('message' => 'User logged in')
                    );
                } else {
                    echo json_encode(
                        array('message' => 'Could not find that email address. Please register first.')
                    );
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