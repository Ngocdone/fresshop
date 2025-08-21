<?php
session_start(); // Bắt đầu phiên làm việc
session_destroy(); // Xóa tất cả dữ liệu phiên
header("Location: ../frontend/view/login.php"); // Chuyển hướng về trang đăng nhập
exit();
?>
