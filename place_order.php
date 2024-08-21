<?php
  session_start();

require_once("./functions/db.php");
require_once("./functions/cart.php");
require_once("./functions/paypal.php");
$customer_name = $_POST["cus_name"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];
$shipping_address = $_POST["shipping_address"];
$payment_method = $_POST["payment_method"];

$items = getCartItems();
if (count($items) == 0) {
  header("Location: cart.php");
  die();
}
$grand_total = 0;
foreach ($items as $item) {
  $grand_total += $item["price"] * $item["buy_qty"];
}
$now = date("Y-m-d H:i:s");
$sql = "INSERT INTO orders(
  created_at,
  grand_total,
  paid,
  payment_method,
  shipping_address,
  telephone,
  cus_name,
  email
  ) VALUES(
      '$now',
      '$grand_total',
      '0',
      '$payment_method',
      '$shipping_address',
      '$telephone',
      '$customer_name',
      '$email'
  )";


$order_id = insert($sql);
if ($order_id != null) {
  foreach ($items as $item) {
    $product_id = $item["id"];
    $buy_qty = $item["buy_qty"];
    $price = $item["price"];
    $sql = "insert into order_items(order_id,product_id,buy_qty,price)
             VALUES($order_id,$product_id, $buy_qty,$price)";
    insert($sql);
  }
  if($payment_method=="PAYPAL"){
    //Thông tin tài khoản paypal
    $client_id = "AZwKNLaFfdHYEHVMo68ScZzhue2u8eEoaH-4mX0n_nNfqA7xxEu93sRtSfHTP8vP1BLpez0HNT9qKnQg";
    $client_secret = "EEwZzi7fxP7owiuyOV43JtDeobTjePdFKwqZ0NBOjvfB2t1KAU069AWFO2dJe44IvBDHMJl0um-TLM-q";
    

    //url nhận kết quả
    $success_url = "http://localhost/popo/success_paypal.php?order_id=$order_id" ;
    $fail_url = "http://localhost/popo/fail_paypal.php?order_id=$order_id";
  }
  header("Location: /thankyou.php");
  die();
}
header("Location: /checkout.php");