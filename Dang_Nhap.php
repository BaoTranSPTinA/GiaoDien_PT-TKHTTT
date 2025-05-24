<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Cổng đăng ký học phần</title>
    <link rel="stylesheet" href="CSS/style_DangNhap.css">
</head>
<body>
    <h1>CỔNG ĐĂNG KÝ HỌC PHẦN</h1>

    <div class="login-box">
        <h2>ĐĂNG NHẬP</h2>
        <p>Cổng đăng ký học phần</p>

        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>

        <form method="POST" action="Controller/c_signin.php">
            <label for="UserName">Tên đăng nhập</label>
            <input type="text" id="UserName" name="UserName" placeholder="Tên đăng nhập" required>

            <label for="Password">Mật khẩu</label>
            <div class="password-container">
                <input type="password" id="Password" name="Password" placeholder="Mật khẩu" required>
                <span class="toggle-password" onclick="togglePassword()" id="toggleIcon">👁️</span>
            </div>

            <label class="remember-me">
                <input type="checkbox" name="remember"> Nhớ mật khẩu
            </label>

            <button type="submit">Đăng nhập</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('Password');
            const icon = document.getElementById('toggleIcon');

            const start = passwordInput.selectionStart;
            const end = passwordInput.selectionEnd;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                icon.textContent = '👁️';
            }

            passwordInput.focus();
            passwordInput.setSelectionRange(start, end);
        }
    </script>
</body>
</html>