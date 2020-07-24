<?php
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');

include_once '../../core/init.php';
include_once '../../models/cart.php';
include_once '../../models/product.php';
include_once '../../models/user.php';

$user = new User($db);
$cart = new Cart($db);
$product = new Product($db);

$ip_address = getenv("REMOTE_ADDR");

if($user->isLoggedIn()) {
    $cart->user_id = $_SESSION['id'];
    $cart_result = $cart->getUserCart();
} else {
    $cart->ip_address = $ip_address;
    $cart_result = $cart->getCart();
}

$cart_row_count = $cart_result->rowCount();
if ($cart_row_count > 0) {
    $cart_arr = array();
    $cart_arr['cartData'] = array();
    while ($cart_row = $cart_result->fetch(PDO::FETCH_ASSOC)) {
        extract($cart_row);
        $product->id = $product_id;
        $product_result = $product->getSingleProduct();
        $product_row_count = $product_result->rowCount();
        if ($product_row_count > 0) {
            $product_row = $product_result->fetch(PDO::FETCH_ASSOC);
            $product_arr = array();
            extract($product_row);
            $total = round(($cost * floatval($quantity)), 2);
            $product_arr = array(
                'id' => $cart_row['id'],
                'product_name' => $product_name,
                'product_image' => $product_image,
                'cost' => $cost,
                'quatity' => $quantity,
                'total' => $total,
            );
        }
        array_push($cart_arr['cartData'], $product_arr);
    }
    echo json_encode($cart_arr);
} else {
    echo json_encode(
        array('message' => 'No products in cart.')
    );
}
?>