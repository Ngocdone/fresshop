<div class="header">
    <h1>Quản lý đơn hàng</h1>
</div>
<table class="table table-bordered text-center align-middle">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order) { ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['TenKhachHang'] ?></td>
                <td><?= $order['Email'] ?></td>
                <td><?= $order['SDT'] ?></td>
                <td>
                    <?php if ($order['TrangThaiThanhToan'] == 0) { ?>
                        <span class="badge bg-warning">Chưa thanh toán</span>
                    <?php } else { ?>
                        <span class="badge bg-success">Đã thanh toán</span>
                    <?php } ?>
                </td>
                <td><?= $order['GhiChuDonHang'] ?></td>
                <td>
                    <!-- Nút Xem chi tiết -->
                    <a href="index.php?page=order_detail&id=<?= $order['id'] ?>" class="btn btn-info btn-sm">
                        Xem chi tiết
                    </a>

                    <!-- Nút Hoàn thành -->
                    <a href="index.php?page=completeOrder&order_id=<?= $order['id'] ?>" class="btn btn-success btn-sm"
                        onclick="return confirm('Bạn có chắc muốn hoàn thành và xóa đơn hàng này?');">
                        Hoàn thành
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>