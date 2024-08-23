<?php
session_start();

require_once("./functions/db.php");
require_once("./functions/cart.php");
require_once("./functions/paypal.php");
$customer_name = $_POST["customer_name"];
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
  customer_name,
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
        $product_id = $item["product_id"];
        $buy_qty = $item["buy_qty"];
        $price = $item["price"];
        $sql = "INSERT into order_items(order_id,product_id,buy_qty,price)
             VALUES($order_id,$product_id, $buy_qty,$price)";
        insert($sql);
    }
    // send email
    $from_email = "chimtokolo@gg.com";
    $header = "From: $from_email";
    $subject = "Order Confirmation $order_id";
    $message = "Thank you for your order!\n\n";
    $message .= "Order ID: $order_id\n";
    $message .= "Order Date: $now\n";
    $message .= "Grand Total: $grand_total\n\n";
    $message .= "Shipping Address: $shipping_address\n";
    $message .= "Telephone: $telephone\n";
    $message .= "Customer Name: $customer_name\n";
    mail($email, $subject, $message, $header);
    if ($payment_method == "PAYPAL") {
        // PayPal configuration
        $client_id = "AZwKNLaFfdHYEHVMo68ScZzhue2u8eEoaH-4mX0n_nNfqA7xxEu93sRtSfHTP8vP1BLpez0HNT9qKnQg";
        $client_secret = "EEwZzi7fxP7owiuyOV43JtDeobTjePdFKwqZ0NBOjvfB2t1KAU069AWFO2dJe44IvBDHMJl0um-TLM-q";

        // URLs for PayPal payment
        $success_url = "http://localhost/popo/success_paypal.php?order_id=$order_id";
        $cancel_url = "http://localhost/popo/fail_paypal.php?order_id=$order_id";

        // Get PayPal access token
        $access_token = get_access_token($client_id, $client_secret);

        // Create PayPal payment
        $payment = create_payment($access_token, $success_url, $cancel_url, $grand_total);

        // Check if the payment creation was successful and the links array exists
        if (!empty($payment['links'])) {
            foreach ($payment['links'] as $link) {
                if ($link['rel'] == 'approval_url') {
                    // Redirect the customer to the PayPal approval URL
                    header("Location: " . $link['href']);
                    exit;
                }
            }
        }

        // If no approval_url is found, redirect back to the checkout page
        header("Location: check_out.php?failed");
        exit;
    } else {
        // Non-PayPal payment, redirect to thank you page
        header("Location: thank_you.php");
        exit;
    }
}
