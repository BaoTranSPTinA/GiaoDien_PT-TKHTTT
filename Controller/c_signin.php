<?php
session_start();
require_once '../Model/database.php'; // Đúng đường dẫn
require_once '../Model/m_User.php';

// Khởi tạo đối tượng Database
$db = new Database();

// Lấy dữ liệu từ form
$username = $_POST['UserName'] ?? '';
$password = $_POST['Password'] ?? '';

// Kiểm tra dữ liệu đầu vào
if (empty($username) || empty($password)) {
    header("Location: ../Dang_Nhap.php?error=Vui lòng nhập đầy đủ thông tin");
    exit();
}

// Kiểm tra kết nối cơ sở dữ liệu
if ($db->conn->connect_error) {
    header("Location: ../Dang_Nhap.php?error=Kết nối cơ sở dữ liệu thất bại");
    exit();
}

try {
    // Truy vấn kiểm tra username
    $sql = "SELECT user_id, username, password, full_name, role FROM Users WHERE username = ?";
    $db->set_query($sql);
    $db->bind_params("s", $username);
    $db->execute_query();
    $user = $db->fetch_row();

    // Kiểm tra user và mật khẩu (so sánh trực tiếp vì mật khẩu là plaintext)
    if ($user && $password === $user['password']) {
        // Lưu thông tin vào session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        // Chuyển hướng dựa trên vai trò
        switch ($user['role']) {
            case 'Quản trị viên':
                header("Location: ../Trang_chu_Admin.php");
                break;
            case 'Giảng viên':
                header("Location: ../Quan_ly_LHP.php");
                break;
            case 'Sinh viên':
                header("Location: ../Dang_ky_hoc_phan.php");
                break;
            default:
                header("Location: ../Dang_Nhap.php?error=Vai trò không hợp lệ");
        }
        exit();
    } else {
        header("Location: ../Dang_Nhap.php?error=Sai tên đăng nhập hoặc mật khẩu");
        exit();
    }
} catch (Exception $e) {
    header("Location: ../Dang_Nhap.php?error=Lỗi: " . urlencode($e->getMessage()));
    exit();
}
?>