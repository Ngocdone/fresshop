<?php 
require_once "header.php"; 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug: Print the entire data array
error_log("Statistics View Data: " . print_r($data, true));

if (!isset($data) || !is_array($data) || empty($data)) {
    echo "<div class='alert alert-danger'>Không có dữ liệu thống kê</div>";
    return;
}
?>

<!-- Main Content -->
<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1>Thống kê</h1>
        <div class="header-actions">
            <a href="index.php?page=thongke&action=exportReport" class="btn btn-primary">📊 Xuất báo cáo</a>
            <a href="index.php?page=thongke&action=exportExcel" class="btn btn-primary">📥 Tải về Excel</a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="table-container mb-4">
        <div class="table-header">
            <h3>Tổng quan</h3>
            <div class="d-flex gap-2">
                <select id="chartType" class="form-select">
                    <option value="line">Biểu đồ đường</option>
                    <option value="bar">Biểu đồ cột</option>
                </select>
                <select id="timeRange" class="form-select">
                    <option value="day">Theo ngày</option>
                    <option value="week">Theo tuần</option>
                    <option value="month">Theo tháng</option>
                </select>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-money-bill"></i>
                </div>
                <div class="stat-info">
                    <h4>Doanh thu</h4>
                    <h3><?= number_format($data['monthlyStats'][0]['doanh_thu'] ?? 0) ?>₫</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h4>Đơn hàng</h4>
                    <h3><?= $data['monthlyStats'][0]['so_don_hang'] ?? 0 ?></h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h4>Khách hàng</h4>
                    <h3><?= $data['totalCustomers'] ?? 0 ?></h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h4>Sản phẩm</h4>
                    <h3><?= count($data['topProducts'] ?? []) ?></h3>
                </div>
            </div>
        </div>

        <div class="chart-container mt-4">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="table-container mb-4">
        <div class="table-header">
            <h3>Sản phẩm bán chạy</h3>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng đã bán</th>
                    <th>Doanh thu</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['topProducts'] as $key => $product): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><img src="../public/img/<?= urlencode($product['image']) ?>" alt="Product" class="product-img" width="80"></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['total_sold'] ?></td>
                    <td><?= number_format($product['total_revenue']) ?>₫</td>
                    <td><span class="status active">Đang bán</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Orders Stats -->
    <div class="table-container mb-4">
        <div class="table-header">
            <h3>Thống kê đơn hàng</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Số đơn hàng</th>
                    <th>Doanh thu</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hôm nay</td>
                    <td><?= $data['dailyStats'][0]['so_don_hang'] ?? 0 ?></td>
                    <td><?= number_format($data['dailyStats'][0]['doanh_thu'] ?? 0) ?>₫</td>
                    <td><span class="status active">Hoàn thành</span></td>
                </tr>
                <tr>
                    <td>Tuần này</td>
                    <td><?= $data['weeklyStats'][0]['so_don_hang'] ?? 0 ?></td>
                    <td><?= number_format($data['weeklyStats'][0]['doanh_thu'] ?? 0) ?>₫</td>
                    <td><span class="status active">Hoàn thành</span></td>
                </tr>
                <tr>
                    <td>Tháng này</td>
                    <td><?= $data['monthlyStats'][0]['so_don_hang'] ?? 0 ?></td>
                    <td><?= number_format($data['monthlyStats'][0]['doanh_thu'] ?? 0) ?>₫</td>
                    <td><span class="status active">Hoàn thành</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.stat-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.stat-icon i {
    color: white;
    font-size: 24px;
}

.stat-info h4 {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.stat-info h3 {
    margin: 5px 0 0;
    font-size: 24px;
    font-weight: bold;
}

.bg-primary { background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%); }
.bg-success { background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%); }
.bg-warning { background: linear-gradient(135deg, #fb6340 0%, #fbb140 100%); }
.bg-info { background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%); }

.chart-container {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
}

.table-container {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.search-box {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 250px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background: #f9f9f9;
    font-weight: bold;
}

.status {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
}

.status.active {
    background: #2dce89;
    color: white;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<script>
let revenueChart = null;

function updateChart(timeRange, chartType) {
    let chartData = {
        labels: [],
        datasets: [{
            label: 'Doanh thu',
            data: [],
            fill: false,
            borderColor: '#5e72e4',
            backgroundColor: '#5e72e4',
            tension: 0.4
        }]
    };

    // Cập nhật dữ liệu dựa trên timeRange
    switch(timeRange) {
        case 'day':
            if (<?= json_encode($data['dailyStats'] ?? []) ?>.length > 0) {
                const dailyData = <?= json_encode($data['dailyStats']) ?>[0];
                chartData.labels = ['Hôm nay'];
                chartData.datasets[0].data = [dailyData.doanh_thu || 0];
            }
            break;
        case 'week':
            if (<?= json_encode($data['weeklyStats'] ?? []) ?>.length > 0) {
                const weeklyData = <?= json_encode($data['weeklyStats']) ?>[0];
                chartData.labels = ['Tuần này'];
                chartData.datasets[0].data = [weeklyData.doanh_thu || 0];
            }
            break;
        case 'month':
            if (<?= json_encode($data['monthlyStats'] ?? []) ?>.length > 0) {
                const monthlyData = <?= json_encode($data['monthlyStats']) ?>[0];
                chartData.labels = ['Tháng này'];
                chartData.datasets[0].data = [monthlyData.doanh_thu || 0];
            }
            break;
    }

    if (revenueChart) {
        revenueChart.destroy();
    }

    const ctx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(ctx, {
        type: chartType,
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Biểu đồ doanh thu ' + (timeRange === 'day' ? 'theo ngày' : timeRange === 'week' ? 'theo tuần' : 'theo tháng')
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(value);
                        }
                    }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateChart('day', 'line');

    document.getElementById('chartType').addEventListener('change', function(e) {
        updateChart(document.getElementById('timeRange').value, e.target.value);
    });

    document.getElementById('timeRange').addEventListener('change', function(e) {
        updateChart(e.target.value, document.getElementById('chartType').value);
    });
});
</script>

<?php require_once "footer.php"; ?>
