<?php 
    session_start();
    require_once("./functions/db.php") ;
    $customer_name = $_POST['cus_name'];
    $customer_email = $_POST['user_email'];
    $customer_phone = $_POST['telephone'];
    $customer_address = $_POST['shipping_address'];
    $payment_method = $_POST['payment_method'];

    $item = getCartItem();
    if(count($item) == 0){
        header('location: cart.php');
        die;
    }
    $grand_total = 0;
    foreach($item as $product){
        $grand_total += $product['price'] * $product['quantity'];
    }
    $now = date('Y-m-d H:i:s');
    function getCartItem(){
        if(isset($_SESSION['cart'])){
            return $_SESSION['cart'];
        }else{
            return array();
        }
    }
    function countCartItem(){
        if(isset($_SESSION['cart'])){
            return count($_SESSION['cart']);
        }else{
            return 0;
        }
    }

?>