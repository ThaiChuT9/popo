<?php
session_start();

// Kiểm tra dữ liệu đầu vào
$product_id = isset($_POST["id"]) ? (int) $_POST["id"] : null;
$buy_qty = isset($_POST["buy_qty"]) ? (int) $_POST["buy_qty"] : null;

if ($product_id === null || $buy_qty === null || $buy_qty <= 0) {
    // Xử lý trường hợp dữ liệu đầu vào không hợp lệ
    header("Location: product.php?error=invalid_input");
    exit;
}

// Khởi tạo giỏ hàng nếu chưa tồn tại
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

$cart = &$_SESSION["cart"];

// Cập nhật giỏ hàng
if (isset($cart[$product_id])) {
    $cart[$product_id] += $buy_qty;
} else {
    $cart[$product_id] = $buy_qty;
}

// Chuyển hướng trở lại trang sản phẩm với thông báo thành công
header("Location: product.php?id=$product_id&success=added_to_cart");
exit;