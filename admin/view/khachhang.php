<?php
require_once __DIR__ . '/../model/KhachHangModel.php';
$khachHangModel = new KhachHangModel();
$khachhangs = $khachHangModel->getAllKhachHang();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Khách Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/admin.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Quản Lý Khách Hàng</h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Khách Hàng</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Địa Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($khachhangs as $khachhang): ?>
                <tr>
                    <td><?= $khachhang['id'] ?></td>
                    <td><?= $khachhang['TenKhachHang'] ?></td>
                    <td><?= $khachhang['Email'] ?></td>
                    <td><?= $khachhang['SDT'] ?></td>
                    <td><?= $khachhang['DiaChi'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $khachhang['id'] ?>" class="btn btn-warning">Sửa</a>
                        <a href="delete.php?id=<?= $khachhang['id'] ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
