<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');

include_once '../../core/init.php';
include_once '../../models/user.php';

$user = new User($db);

if ($user->isLoggedIn()) {
    unset($_SESSION['id']);
    session_destroy();
    http_response_code(200);
    echo json_encode(
        array('message' => 'Logged out successfully')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'No active sessions to logout')
    );
}
?>