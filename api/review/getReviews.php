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
$reviews_arr = array();

$data = json_decode(file_get_contents("php://input"));
if (isset($data->product_id)) {
    if (empty($data->product_id)) {
        http_response_code(422);
        echo json_encode(
            array('message' => 'Please provide a product id')
        );
    } else {
        if(is_int($data->product_id) != 1) {
            http_response_code(422);
            echo json_encode(
                array('message' => 'Provide an integer for product id')
            );
        } else {
            $review->product_id = $data->product_id;
            $result = $review->getAllReviews();
            $row_count = $result->rowCount();
            if ($row_count > 0) {
                $reviews_arr['reviews'] = array();
                $review = array();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $user->id = $user_id;
                    $user_result = $user->getUserDetails();
                    $user_row_count = $user_result->rowCount();
                    $user_row = $user_result->fetch(PDO::FETCH_ASSOC);
                    array_push($reviews_arr['reviews'], array(
                        "id" => $id,
                        "product_id" => $product_id,
                        "user_id" => $user_id,
                        "rating" => $rating,
                        "image" => $image,
                        "comment" => $comment,
                        "first_name" => $user_row['first_name'],
                        "last_name" => $user_row['last_name'],
                        "created_at" => $created_at,
                    ));
                }
                echo json_encode($reviews_arr);
            } else {
                http_response_code(404);
                echo json_encode(
                    array('message' => 'No reviews found')
                );
            }
        }
    }
} else {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Please provide a product id')
    );
}
?>