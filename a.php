<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlyhocphan";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Tránh SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Mã hóa mật khẩu
    $hashed_password = md5($password);

    // Kiểm tra theo vai trò
    switch($role) {
        case 'admin':
            $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$hashed_password'";
            $redirect = "Trang_chu_Admin.html";
            break;
        case 'student':
            $sql = "SELECT * FROM sinh_vien WHERE mssv = '$username' AND password = '$hashed_password'";
            $redirect = "Dang_ky_hoc_phan.html";
            break;
        case 'teacher':
            $sql = "SELECT * FROM giang_vien WHERE magv = '$username' AND password = '$hashed_password'";
            $redirect = "Phan_cong_GV.html";
            break;
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: $redirect");
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #245139;
            margin: 0;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #245139;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background-color: #245139;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: #1a3c2a;
        }

        .error-message {
            color: #cc4c4c;
            text-align: center;
            margin-bottom: 1rem;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 1rem;
                padding: 1rem;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>ĐĂNG NHẬP</h1>
        </div>
        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="role">Vai trò</label>
                <select id="role" name="role" required>
                    <option value="admin">Quản trị viên</option>
                    <option value="teacher">Giảng viên</option>
                    <option value="student">Sinh viên</option>
                </select>
            </div>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Đăng nhập</button>
        </form>
    </div>
</body>
</html>