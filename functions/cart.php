<?php
require_once("./functions/db.php");
function getCartItems()
{
    $conn = connect();
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $cartItems = [];
    if (!empty($cart)) {
        $productIds = implode(',', array_keys($cart));
        $sql = "SELECT * FROM `products` WHERE product_id IN ($productIds)";
        $products = select($sql);
        foreach ($products as $product) {
            $cartItems[] = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                "buy_qty"=>$cart[$product["product_id"]],
                'total' => $cart[$product['product_id']] * $product['price'],
                "details" => $product["description"]
            ];
        }
    }
    return $cartItems;
}
