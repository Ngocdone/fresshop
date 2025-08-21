<?php
session_start();
require_once '../model/database.php'; // Kết nối đến file database.php

// Kiểm tra xem có sản phẩm nào được thêm vào giỏ hàng không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Kiểm tra xem giỏ hàng đã tồn tại trong session chưa
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity; // Tăng số lượng
    } else {
        $_SESSION['cart'][$product_id] = $quantity; // Thêm sản phẩm mới
    }

    echo "Sản phẩm đã được thêm vào giỏ hàng!";
}
?>
