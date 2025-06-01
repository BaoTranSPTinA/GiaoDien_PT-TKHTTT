<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Quản trị viên') {
        header("Location: Dang_Nhap.php");
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Trang chủ Quản trị viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="CSS/style_TrangChuAdmin.css"/>
</head>
<body>
    <div class="sidebar">
        <div class="user-info">
            <div class="avatar"></div>
            <div class="details">
                <div class="role"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
                <div><?php echo htmlspecialchars($_SESSION['role']); ?></div>
            </div>
        </div>
        <ul>
        <?php if ($_SESSION['role'] === 'Quản trị viên') { ?>
            <li><i class="fas fa-book"></i><a href="Quan_ly_hoc_phan.php">Quản lý học phần</a></li>
            <li><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học phần</a></li>
            <li><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.php">Phân công giảng viên</a></li>
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li><i class="fas fa-users"></i><a href="Quan_ly_ND.php">Quản lý người dùng</a></li>
            <li><i class="fas fa-chart-bar"></i><a href="Thongke_Baocao.php">Thống kê báo cáo</a></li>
        <?php } elseif ($_SESSION['role'] === 'Sinh viên') { ?>
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem thời khóa biểu</a></li>
        <?php } elseif ($_SESSION['role'] === 'Giảng viên') { ?>
            <li><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem lịch dạy</a></li>
        <?php } ?>
            <li><i class="fas fa-sign-out-alt"></i><a href="Controller/c_signout.php">Đăng xuất</a></li>
        </ul>
    </div>

    <div class="main">
        <header>
            <h1>HỆ THỐNG ĐĂNG KÝ HỌC PHẦN</h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <main>
            <h2>Chào mừng đến trang Quản trị hệ thống</h2>
        </main>
    </div>
</body>
</html>