<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/admin.css">
    <link rel="stylesheet" href="/duan1/public/css/admin.css">
 <!-- Chứa toàn bộ CSS bạn đã viết -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffffff;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Menu */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #ffffffff 0%, #000000ff 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 1);
        }

        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 1);
            margin-bottom: 20px;
        }

        .logo h2 {
            font-size: 24px;
            font-weight: 300;
            color: #000000ff;
        }

        .menu-item {
            padding: 15px 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            
        }

        .menu-item:hover {
            background-color: rgba(255,255,255,0.2);
            border-left-color: #fff;
        }

        .menu-item.active {
            background-color: rgba(255,255,255,0.2);
            border-left-color: #fff;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            color: white;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.9),
            transition: all 0.3s ease;
        }

        .menu-item:hover i {
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.9),
                         0 0 25px rgba(255, 255, 255, 0.7),
                         0 0 35px rgba(255, 255, 255, 0.5);
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.8));
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: rgba(0, 0, 0, 1);
            font-size: 28px;
            font-weight: 300;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #00d9ff 0%, #9b1690 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgb(0, 47, 255);
        }

        /* Product Table */
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 1);
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            color: #333;
            font-size: 20px;
            font-weight: 500;
        }

        .search-box {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #000000b4;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            font-size: 14px;
            color: #666;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            object-fit: cover;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status.active {
            background-color: #d4edda;
            color: #155724;
        }

        .status.inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 3px;
        }

        .btn-edit {
            background-color: #ffc107;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-view {
            background-color: #17a2b8;
            color: white;
        }

        .pagination {
            padding: 20px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .page-btn {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            border-radius: 3px;
        }

        .page-btn.active {
            background: linear-gradient(135deg, #088118b9 0%, #764ba2 100%);
            color: white;
            border-color: #02b90b;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .admin-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
            }
            
    .main-content {
        padding: 30px;
    }
    .product-img, img.rounded {
        object-fit: cover;
        border-radius: 8px;
    }
    .btn-sm {
        padding: 5px 10px;
    }

        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h2>ADMIN</h2>
            </div>
            <div class="menu-item <?= (($_GET['page'] ?? '') == 'category') ? 'active' : '' ?>">
                <a href="?page=category"><i>📊</i> Danh Mục</a>
            </div>
            <div class="menu-item <?= (($_GET['page'] ?? '') == 'product') ? 'active' : '' ?>">
                <a href="?page=product"><i>📦</i> Sản phẩm</a>
            </div>
            <div class="menu-item <?= (($_GET['page'] ?? '') == 'khachhang') ? 'active' : '' ?>">
                <a href="?page=khachhang"><i>👤</i> Khách hàng</a>
            </div>
            <div class="menu-item <?= (($_GET['page'] ?? '') == 'thongke') ? 'active' : '' ?>">
                <a href="?page=thongke"><i>📈</i> Thống kê</a>
            </div>
            <div class="menu-item <?= (($_GET['page'] ?? '') == 'donhang') ? 'active' : '' ?>">
                <a href="index.php?page=orders"><i>📋</i> Đơn hàng</a>
            </div>
            <div class="menu-item">
                <a href="logout.php"><i>🚪</i> Đăng xuất</a>
            </div>
        </div>
<i>🚪</i> Đăng xuất
        <!-- Main content start -->
        <div class="main-content">
