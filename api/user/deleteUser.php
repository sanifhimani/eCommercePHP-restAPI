<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');

include_once '../../core/init.php';
include_once '../../models/user.php';

$user = new User($db);

if ($user->isLoggedIn()) {
    if ($user->deleteUser()) {
        http_response_code(200);
        echo json_encode(
            array('message' => 'User deleted successfully')
        );
        header('Location: logout.php');
    } else {
        http_response_code(500);
        echo json_encode(
            array('message' => 'Something went wrong')
        );
    }
} else {
    http_response_code(401);
    echo json_encode(
        array('message' => 'Please login to access')
    );
}
?>