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
            <li class="active"><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học phần</a></li>
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
                    <input type="text" id="searchInput" placeholder="Tìm kiếm lớp học phần..." onkeyup="timKiemLopHocPhan()">
                    <button onclick="timKiemLopHocPhan()"><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>

                <table id="bangLopHocPhan">
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
                    <tbody></tbody>
                </table>
                
                <!-- Modal xem danh sách sinh viên -->
                <div id="studentListModal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn" onclick="dongModal()">×</span>
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
                    document.addEventListener('DOMContentLoaded', function () {
                        // Dữ liệu mẫu
                        const sampleData = {
                            lopHocPhanList: [
                                {
                                    maLHP: 'LHP001',
                                    tenHocPhan: 'Lập trình Web',
                                    giangVien: 'Nguyễn Văn A',
                                    soLuongSV: '40/50',
                                    thoiGian: 'Thứ 2 (7:30-9:30)',
                                    phongHoc: 'A2.01'
                                },
                                {
                                    maLHP: 'LHP002',
                                    tenHocPhan: 'Cơ sở dữ liệu',
                                    giangVien: 'Trần Thị B',
                                    soLuongSV: '35/45',
                                    thoiGian: 'Thứ 3 (9:30-11:30)',
                                    phongHoc: 'A3.02'
                                },
                                {
                                    maLHP: 'LHP003',
                                    tenHocPhan: 'Cấu trúc dữ liệu',
                                    giangVien: 'Lê Văn C',
                                    soLuongSV: '30/40',
                                    thoiGian: 'Thứ 4 (13:30-15:30)',
                                    phongHoc: 'B1.03'
                                },
                                {
                                    maLHP: 'LHP004',
                                    tenHocPhan: 'Hệ điều hành',
                                    giangVien: 'Phạm Thị D',
                                    soLuongSV: '25/50',
                                    thoiGian: 'Thứ 5 (15:30-17:30)',
                                    phongHoc: 'A1.04'
                                }
                            ],
                            sinhVienDangKyList: [
                                {
                                    maLHP: 'LHP001',
                                    sinhVien: [
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
                                        },
                                        {
                                            maSV: 'SV003',
                                            hoTen: 'Lê Văn Z',
                                            lop: 'CNTT1',
                                            email: 'z@example.com',
                                            sdt: '0912345678',
                                            trangThai: 'Đã đăng ký'
                                        }
                                    ]
                                },
                                {
                                    maLHP: 'LHP002',
                                    sinhVien: [
                                        {
                                            maSV: 'SV004',
                                            hoTen: 'Phạm Thị M',
                                            lop: 'CNTT3',
                                            email: 'm@example.com',
                                            sdt: '0934567890',
                                            trangThai: 'Đã đăng ký'
                                        },
                                        {
                                            maSV: 'SV005',
                                            hoTen: 'Hoàng Văn N',
                                            lop: 'CNTT2',
                                            email: 'n@example.com',
                                            sdt: '0923456789',
                                            trangThai: 'Đã đăng ký'
                                        }
                                    ]
                                },
                                {
                                    maLHP: 'LHP003',
                                    sinhVien: [
                                        {
                                            maSV: 'SV006',
                                            hoTen: 'Nguyễn Thị P',
                                            lop: 'CNTT4',
                                            email: 'p@example.com',
                                            sdt: '0945678901',
                                            trangThai: 'Đã đăng ký'
                                        }
                                    ]
                                },
                                {
                                    maLHP: 'LHP004',
                                    sinhVien: []
                                }
                            ]
                        };

                        // Lưu dữ liệu mẫu vào localStorage
                        localStorage.setItem('lopHocPhanList', JSON.stringify(sampleData.lopHocPhanList));
                        localStorage.setItem('sinhVienDangKyList', JSON.stringify(sampleData.sinhVienDangKyList));

                        // Tải dữ liệu lớp học phần khi trang được tải
                        loadLopHocPhan();
                    });

                    function loadLopHocPhan(filter = '') {
                        const lopHocPhanList = JSON.parse(localStorage.getItem('lopHocPhanList')) || [];
                        const tbody = document.querySelector('#bangLopHocPhan tbody');
                        tbody.innerHTML = '';

                        const filteredList = lopHocPhanList.filter(lhp => 
                            lhp.maLHP.toLowerCase().includes(filter) ||
                            lhp.tenHocPhan.toLowerCase().includes(filter) ||
                            lhp.giangVien.toLowerCase().includes(filter)
                        );

                        filteredList.forEach(lhp => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${lhp.maLHP}</td>
                                <td>${lhp.tenHocPhan}</td>
                                <td>${lhp.giangVien}</td>
                                <td>${lhp.soLuongSV}</td>
                                <td>${lhp.thoiGian}</td>
                                <td>${lhp.phongHoc}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="view-students-btn" onclick="xemDanhSachSV('${lhp.maLHP}')"><i class="fas fa-users"></i></button>
                                        <button class="edit-btn"><i class="fas fa-edit"></i></button>
                                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    }

                    function timKiemLopHocPhan() {
                        const searchInput = document.getElementById('searchInput').value.toLowerCase();
                        loadLopHocPhan(searchInput);
                    }

                    function xemDanhSachSV(maLHP) {
                        const lopHocPhanList = JSON.parse(localStorage.getItem('lopHocPhanList')) || [];
                        const sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];

                        // Tìm thông tin lớp học phần
                        const lopHocPhan = lopHocPhanList.find(lhp => lhp.maLHP === maLHP);
                        if (!lopHocPhan) return;

                        // Tìm danh sách sinh viên của lớp học phần này
                        const svList = sinhVienDangKyList.find(item => item.maLHP === maLHP);
                        const danhSachSV = svList ? svList.sinhVien : [];

                        // Hiển thị thông tin lớp học phần
                        document.getElementById('lopHocPhanInfo').innerHTML = `
                            <p><strong>Mã LHP:</strong> ${lopHocPhan.maLHP}</p>
                            <p><strong>Tên học phần:</strong> ${lopHocPhan.tenHocPhan}</p>
                            <p><strong>Giảng viên:</strong> ${lopHocPhan.giangVien}</p>
                        `;

                        // Hiển thị danh sách sinh viên
                        const tbody = document.getElementById('danhSachSV');
                        tbody.innerHTML = '';
                        if (danhSachSV.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="6">Chưa có sinh viên đăng ký.</td></tr>';
                        } else {
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
                        }

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
            </div>
        </main>
    </div>
</body>
</html>