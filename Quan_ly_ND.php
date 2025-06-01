<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="CSS/style_TrangChuAdmin.css"/>
    <style>
        .content {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-bar button {
            padding: 8px 15px;
            background-color: #245139;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #1a3c2a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #245139;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #230c67;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #6f0e0e;
        }

        .add-btn {
            background-color: #245139;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .add-btn:hover {
            background-color: #1a3c2a;
        }

        .role-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .role-admin {
            background-color: #ff9800;
            color: white;
        }

        .role-lecturer {
            background-color: #2196F3;
            color: white;
        }

        .role-student {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    require_once 'Model/database.php';
    require_once 'Model/m_User.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Quản trị viên') {
        header("Location: Dang_Nhap.php");
        exit();
    }
    $userModel = new User();
    $users = $userModel->list_all_user();
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
        <?php if ($_SESSION['role'] === 'Quản trị viên') { ?>
            <li><i class="fas fa-book"></i><a href="Quan_ly_hoc_phan.php">Quản lý học phần</a></li>
            <li><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học phần</a></li>
            <li><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.php">Phân công giảng viên</a></li>
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li class="active"><i class="fas fa-users"></i><a href="Quan_ly_ND.php">Quản lý người dùng</a></li>
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
            <h1>QUẢN LÝ NGƯỜI DÙNG</h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <main>
            <div class="content">
                <button class="add-btn" onclick="document.getElementById('addUserModal').style.display='block'"><i class="fas fa-user-plus"></i> Thêm người dùng mới</button>
                <div id="addUserModal" style="display:none;">
                    <form action="Controller/c_addUser.php" method="POST">
                        <input type="text" name="full_name" placeholder="Họ và tên" required>
                        <input type="text" name="username" placeholder="Tên đăng nhập" required>
                        <input type="password" name="password" placeholder="Mật khẩu" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="phone_number" placeholder="Số điện thoại" required>
                        <select name="role" required>
                            <option value="Quản trị viên">Quản trị viên</option>
                            <option value="Giảng viên">Giảng viên</option>
                            <option value="Sinh viên">Sinh viên</option>
                        </select>
                        <button type="submit">Thêm</button>
                        <button type="button" onclick="document.getElementById('addUserModal').style.display='none'">Hủy</button>
                    </form>
                </div>
                
                <div id="editUserModal" style="display:none;">
                    <form action="Controller/c_editUser.php" method="POST">
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <input type="text" name="full_name" id="edit_full_name" placeholder="Họ và tên" required>
                        <input type="text" name="username" id="edit_username" placeholder="Tên đăng nhập" required>
                        <input type="email" name="email" id="edit_email" placeholder="Email" required>
                        <input type="text" name="phone_number" id="edit_phone_number" placeholder="Số điện thoại" required>
                        <select name="role" id="edit_role" required>
                            <option value="Quản trị viên">Quản trị viên</option>
                            <option value="Giảng viên">Giảng viên</option>
                            <option value="Sinh viên">Sinh viên</option>
                        </select>
                        <button type="submit">Cập nhật</button>
                        <button type="button" onclick="document.getElementById('editUserModal').style.display='none'">Hủy</button>
                    </form>
                </div>
                <script>
                    function openEditModal(userId) {
                        fetch(`Controller/c_editUser.php?user_id=${userId}`)
                        .then(response => response.json())
                        .then(user => {
                            if (user.error) {
                                alert(user.error);
                            } else {
                                document.getElementById('edit_user_id').value = user.user_id;
                                document.getElementById('edit_full_name').value = user.full_name;
                                document.getElementById('edit_username').value = user.username;
                                document.getElementById('edit_email').value = user.email;
                                document.getElementById('edit_phone_number').value = user.phone_number;
                                document.getElementById('edit_role').value = user.role;
                                document.getElementById('editUserModal').style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching user data:', error);
                            alert('Failed to fetch user data.');
                        });
                    }
                </script>
                    
                <div class="search-bar">
                    <input type="text" placeholder="Tìm kiếm người dùng...">
                    <button><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Tên đăng nhập</th>
                            <th>Email</th>
                         <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="role-badge role-<?php echo strtolower($user['role']); ?>">
                                    <?php echo htmlspecialchars($user['role']); ?>
                                </span>
                            </td>
                            <td>Hoạt động</td>
                            <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="openEditModal(<?php echo htmlspecialchars($user['user_id']); ?>)"><i class="fas fa-edit"></i></button>
                                <form action="Controller/c_deleteUser.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                    <button class="delete-btn"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
</tbody>
<!-- Edit User Modal -->
