<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../core/init.php';
include_once '../../models/user.php';
include_once '../../models/review.php';

$review = new Review($db);
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if ($user->isLoggedIn()) {
    if ((isset($data->product_id) && isset($data->rating))) {
        if (empty($data->product_id) && empty($data->rating)) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Please provide a product id and a rating')
            );
        } else {
            if (is_int($data->product_id) != 1) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please provide an integer value for product id')
                );
            } else if (is_int($data->rating) != 1) {
                http_response_code(422);
                echo json_encode(
                    array('message' => 'Please provide an integer value for rating')
                );
            } else {
                if ($data->rating > 0 && $data->rating <= 5) {
                    $review->product_id = $data->product_id;
                    $review->user_id = $_SESSION['id'];
                    $review->rating = $data->rating;
                    if(isset($data->image)) {
                        $review->image = $data->image;
                    }
                    if(isset($data->comment)) {
                        $review->comment = $data->comment;
                    }
                    if ($review->addReview()) {
                        http_response_code(201);
                        echo json_encode(
                            array('message' => 'Comment added successfully')
                        );
                    } else {
                        http_response_code(500);
                        echo json_encode(
                            array('message' => 'Something went wrong')
                        );
                    }
                } else {
                    http_response_code(422);
                    echo json_encode(
                        array('message' => 'Please provide a rating from 1 to 5')
                    );
                }
            }
        }
    } else {
        http_response_code(422);
        echo json_encode(
            array('message' => 'Please provide a product id and rating')
        );
    }
} else {
    http_response_code(401);
    echo json_encode(
        array("message" => "Please login to access")
    );
}
?>