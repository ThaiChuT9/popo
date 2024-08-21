<?php
session_start();

require_once("./functions/db.php");
require_once("./functions/paypal.php");

$order_id = $_GET['order_id'];
$payment_id = $_GET['paymentId'];
$payer_id = $_GET['PayerID'];

// Generate an access token using PayPal credentials
$client_id = "AZwKNLaFfdHYEHVMo68ScZzhue2u8eEoaH-4mX0n_nNfqA7xxEu93sRtSfHTP8vP1BLpez0HNT9qKnQg";
$client_secret = "EEwZzi7fxP7owiuyOV43JtDeobTjePdFKwqZ0NBOjvfB2t1KAU069AWFO2dJe44IvBDHMJl0um-TLM-q";
$access_token = get_access_token($client_id, $client_secret);

// Execute the payment
$result = execute_payment($access_token, $payment_id, $payer_id);

if ($result['state'] === 'approved') {
    // Payment successful, update the orders table
    $sql = "UPDATE `orders` SET `paid` = '1' WHERE `orders_id` = $order_id";
    insert($sql); 
    header("Location: thank_you.php");
    unset($_SESSION['cart']);
} else {
    // Log the response for debugging
    error_log(print_r($result, true));
    header("Location: fail_paypal.php?order_id=$order_id");
}
