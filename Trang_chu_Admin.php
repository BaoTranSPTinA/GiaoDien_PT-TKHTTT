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
    <?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Quản trị viên') {
        header("Location: Dang_Nhap.php");
        exit();
    }
    ?>
    <div class="sidebar">
        <div class="user-info">
            <div class="avatar"></div>
            <div class="details">
                <div class="role"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
                <div>Quản trị viên</div>
            </div>
        </div>
        <ul>
            <li><i class="fas fa-book"></i><a href="Quan_ly_hoc_phan.php">Quản lý học phần</a></li>
            <li><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.php">Phân công giảng viên</a></li>
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-alt"></i><a href="#">Tra cứu lịch học</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="#">Xem thời khóa biểu</a></li>
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