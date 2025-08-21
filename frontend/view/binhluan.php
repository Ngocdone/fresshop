<?php
require_once '../model/database.php'; // Kết nối đến file database.php

// Kiểm tra xem form đã được gửi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    // Kết nối đến cơ sở dữ liệu
    $db = Database::getInstance();
    
    // Câu lệnh SQL để chèn bình luận
    $sql = "INSERT INTO binhluan (name, comment) VALUES (:name, :comment)";
    $params = [
        ':name' => $name,
        ':comment' => $comment
    ];

    // Thực thi câu lệnh
    if ($db->execute($sql, $params)) {
        echo "Bình luận đã được gửi thành công!";
    } else { 
        echo "Có lỗi xảy ra khi gửi bình luận.";
    }
}
?>

<!-- Form bình luận -->
<form method="POST" action="">
    <input type="text" name="name" placeholder="Tên của bạn" required>
    <textarea name="comment" placeholder="Bình luận của bạn" required></textarea>
    <button type="submit">Gửi bình luận</button>
</form>
