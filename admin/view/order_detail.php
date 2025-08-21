<div class="main-content">
    <div class="header">
        <h1>Chi tiết đơn hàng #<?= $order['id'] ?></h1>
        <a href="index.php?page=orders"><button class="btn btn-secondary">⬅ Quay lại</button></a>
    </div>

    <h3>Thông tin khách hàng</h3>
    <p><strong>Họ tên:</strong> <?= $order['TenKhachHang'] ?></p>
    <p><strong>Email:</strong> <?= $order['Email'] ?></p>
    <p><strong>SĐT:</strong> <?= $order['SDT'] ?></p>
    <p><strong>Địa chỉ:</strong> <?= $order['DiaChi'] ?></p>
    <p><strong>Ghi chú:</strong> <?= $order['Ghichu'] ?></p>

    <h3>Sản phẩm trong đơn hàng</h3>
    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Ảnh</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $tong = 0;
            foreach($order_items as $key => $item) { 
                $thanhtien = $item['Gia'] * $item['SoLuong'];
                $tong += $thanhtien;
            ?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= $item['TenSanPham'] ?></td>
                <td><img src="../public/img/<?= $item['HinhAnh'] ?>" width="80"></td>
                <td><?= $item['SoLuong'] ?></td>
                <td><?= number_format($item['Gia'], 0, ',', '.') ?> đ</td>
                <td><?= number_format($thanhtien, 0, ',', '.') ?> đ</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3>Tổng tiền: <?= number_format($tong, 0, ',', '.') ?> đ</h3>
</div>
