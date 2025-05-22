<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: Dang_Nhap.php");
    exit();
}

// Chỉ cho phép Quản trị viên và Giảng viên truy cập trang này
if ($_SESSION['role'] !== 'Quản trị viên' && $_SESSION['role'] !== 'Giảng viên') {
    header("Location: Dang_Nhap.php");
    exit();
}

// Kiểm tra role để hiển thị giao diện phù hợp
$isAdmin = $_SESSION['role'] === 'Quản trị viên';
$isLecturer = $_SESSION['role'] === 'Giảng viên';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý lớp học phần</title>
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

        .delete-btn {
            background-color: #f44336;
            color: white;
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
    </style>
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
            <?php if ($isAdmin): ?>
            <li><i class="fas fa-book"></i><a href="Quan_ly_hoc_phan.php">Quản lý học phần</a></li>
            <?php endif; ?>
            
            <?php if ($isAdmin || $isLecturer): ?>
            <li class="active"><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học phần</a></li>
            <?php endif; ?>
            
            <?php if ($isAdmin): ?>
            <li><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.php">Phân công giảng viên</a></li>
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li><i class="fas fa-users"></i><a href="Quan_ly_ND.php">Quản lý người dùng</a></li>
            <?php endif; ?>
            
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-alt"></i><a href="#">Tra cứu lịch học</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem thời khóa biểu</a></li>
            <li><i class="fas fa-chart-bar"></i><a href="Thongke_Baocao.php">Thống kê báo cáo</a></li>
            <li><i class="fas fa-sign-out-alt"></i><a href="Controller/c_signout.php">Đăng xuất</a></li>
        </ul>
    </div>

    <div class="main">
        <header>
            <h1>QUẢN LÝ LỚP HỌC PHẦN</h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <main>
            <div class="content">
                <button class="add-btn"><i class="fas fa-plus"></i> Thêm lớp học phần mới</button>
                
                <div class="search-bar">
                    <input type="text" placeholder="Tìm kiếm lớp học phần...">
                    <button><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>

                <style>
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

                    .delete-btn {
                        background-color: #f44336;
                        color: white;
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
                    .view-students-btn {
                        background-color: #2196F3;
                        color: white;
                    }

                    .modal {
                        display: none;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0,0,0,0.5);
                        z-index: 1000;
                    }

                    .modal-content {
                        background-color: white;
                        margin: 10% auto;
                        padding: 20px;
                        width: 80%;
                        max-width: 800px;
                        border-radius: 8px;
                        position: relative;
                    }

                    .close-btn {
                        position: absolute;
                        right: 20px;
                        top: 10px;
                        font-size: 24px;
                        cursor: pointer;
                    }

                    .student-list-table {
                        width: 100%;
                        margin-top: 20px;
                    }

                    .student-list-table th,
                    .student-list-table td {
                        padding: 10px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }
                </style>
                <table>
                    <thead>
                        <tr>
                            <th>Mã LHP</th>
                            <th>Tên học phần</th>
                            <th>Giảng viên</th>
                            <th>Số lượng SV</th>
                            <th>Thời gian</th>
                            <th>Phòng học</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>LHP001</td>
                            <td>Lập trình Web</td>
                            <td>Nguyễn Văn A</td>
                            <td>40/50</td>
                            <td>Thứ 2 (7:30-9:30)</td>
                            <td>A2.01</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="view-students-btn" onclick="xemDanhSachSV('LHP001')"><i class="fas fa-users"></i></button>
                                    <button class="edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="delete-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>LHP002</td>
                            <td>Cơ sở dữ liệu</td>
                            <td>Trần Thị B</td>
                            <td>35/45</td>
                            <td>Thứ 3 (9:30-11:30)</td>
                            <td>A3.02</td>
                            <td>
                                <div class="action-buttons">
                                <button class="view-students-btn" onclick="xemDanhSachSV('LHP002')"><i class="fas fa-users"></i></button>
                                    <button class="edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="delete-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Modal xem danh sách sinh viên -->
                <div id="studentListModal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn" onclick="dongModal()">&times;</span>
                        <h2>Danh sách sinh viên đăng ký</h2>
                        <div id="lopHocPhanInfo"></div>
                        <table class="student-list-table">
                            <thead>
                                <tr>
                                    <th>Mã SV</th>
                                    <th>Họ và tên</th>
                                    <th>Lớp</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody id="danhSachSV"></tbody>
                        </table>
                    </div>
                </div>
                
                <script>
                function xemDanhSachSV(maLHP) {
                    // Giả lập dữ liệu sinh viên (sau này sẽ lấy từ database)
                    const danhSachSV = [
                        {
                            maSV: 'SV001',
                            hoTen: 'Nguyễn Văn X',
                            lop: 'CNTT1',
                            email: 'x@example.com',
                            sdt: '0123456789',
                            trangThai: 'Đã đăng ký'
                        },
                        {
                            maSV: 'SV002',
                            hoTen: 'Trần Thị Y',
                            lop: 'CNTT2',
                            email: 'y@example.com',
                            sdt: '0987654321',
                            trangThai: 'Đã đăng ký'
                        }
                        // Thêm sinh viên khác...
                    ];
                
                    // Hiển thị thông tin lớp học phần
                    document.getElementById('lopHocPhanInfo').innerHTML = `
                        <p><strong>Mã LHP:</strong> ${maLHP}</p>
                        <p><strong>Tên học phần:</strong> Lập trình Web</p>
                        <p><strong>Giảng viên:</strong> Nguyễn Văn A</p>
                    `;
                
                    // Hiển thị danh sách sinh viên
                    const tbody = document.getElementById('danhSachSV');
                    tbody.innerHTML = '';
                    danhSachSV.forEach(sv => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${sv.maSV}</td>
                                <td>${sv.hoTen}</td>
                                <td>${sv.lop}</td>
                                <td>${sv.email}</td>
                                <td>${sv.sdt}</td>
                                <td>${sv.trangThai}</td>
                            </tr>
                        `;
                    });
                
                    // Hiển thị modal
                    document.getElementById('studentListModal').style.display = 'block';
                }

                function dongModal() {
                    document.getElementById('studentListModal').style.display = 'none';
                }

                // Đóng modal khi click bên ngoài
                window.onclick = function(event) {
                    const modal = document.getElementById('studentListModal');
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                }
                </script>