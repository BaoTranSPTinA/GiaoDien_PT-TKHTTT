<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: Dang_Nhap.php");
    exit();
}

// Lấy role của người dùng
$userRole = $_SESSION['role'];
$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userRole === 'Giảng viên' ? 'Lịch dạy' : 'Thời khóa biểu'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="CSS/style_TrangChuAdmin.css"/>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ecf0f1;
            display: flex;
            flex-wrap: wrap;
            min-height: 100vh;
        }
        .sidebar {
            flex: 0 0 240px;
            background-color: #245139;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .user-info {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: 15px;
            overflow: hidden;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .details .role {
            font-weight: bold;
        }
        .sidebar ul {
            width: 100%;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            padding: 12px 0;
            display: flex;
            align-items: center;
        }
        .sidebar ul li i {
            margin-right: 10px;
            width: 20px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }
        .sidebar ul li:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            cursor: pointer;
        }
        .sidebar ul li a:hover {
            text-decoration: underline;
        }
        .sidebar ul li.active {
            background-color: #ffffff;
            border-radius: 4px;
        }
        .sidebar ul li.active a {
            color: #245139;
        }
        .sidebar ul li.active i {
            color: #245139;
        }
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            margin-left: 1px;
            background-color: #d1e5dd;
        }
        header {
            background-color: #245139;
            color: white;
            padding: 1rem 2rem;
            margin-left: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex-wrap: wrap;
        }
        header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        header .login {
            font-size: 0.9rem;
        }
        .container {
            padding: 2rem;
        }
        .filter-form {
            margin-bottom: 2rem;
            background-color: #fff;
            padding: 1rem;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .filter-form select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex: 1;
            min-width: 200px;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .schedule-table th,
        .schedule-table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .schedule-table th {
            background-color: #245139;
            color: #fff;
        }
        .schedule-table td {
            height: 100px;
            vertical-align: top;
        }
        .class-item {
            background-color: #e3f2fd;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .class-item:hover {
            background-color: #bbdefb;
            transform: translateY(-2px);
        }
        .class-item .subject {
            font-weight: bold;
            margin-bottom: 4px;
        }
        .class-item .room {
            color: #666;
            font-size: 0.8rem;
        }
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                flex: 0 0 auto;
                width: 100%;
                padding: 10px;
            }
            .user-info {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px;
            }
            .avatar {
                margin-right: 0;
                margin-bottom: 10px;
            }
            .sidebar ul li {
                padding: 8px 0;
            }
            .main {
                margin-left: 0;
            }
            header {
                margin-left: 0;
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
            }
            header h1 {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }
            .container {
                padding: 1rem;
            }
            .filter-form {
                flex-direction: column;
            }
            .filter-form select {
                width: 100%;
            }
            .schedule-table th,
            .schedule-table td {
                padding: 8px;
                font-size: 0.9rem;
            }
            .class-item {
                padding: 6px;
                font-size: 0.8rem;
            }
        }
        @media (max-width: 480px) {
            .sidebar {
                padding: 5px;
            }
            .user-info {
                padding: 8px;
            }
            .avatar {
                width: 40px;
                height: 40px;
            }
            .sidebar ul li a {
                font-size: 0.9rem;
            }
            header h1 {
                font-size: 1rem;
            }
            .container {
                padding: 0.5rem;
            }
            .schedule-table th,
            .schedule-table td {
                padding: 6px;
                font-size: 0.8rem;
            }
            .class-item {
                padding: 4px;
                font-size: 0.75rem;
            }
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
            <li><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học phần</a></li>
            <li><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.php">Phân công giảng viên</a></li>
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li><i class="fas fa-users"></i><a href="Quan_ly_ND.php">Quản lý người dùng</a></li>
            <li><i class="fas fa-chart-bar"></i><a href="Thongke_Baocao.php">Thống kê báo cáo</a></li>
        <?php } elseif ($_SESSION['role'] === 'Sinh viên') { ?>
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li class="active"><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem thời khóa biểu</a></li>
        <?php } elseif ($_SESSION['role'] === 'Giảng viên') { ?>
            <li><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học</a></li>
            <li class="active"><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem lịch dạy</a></li>
        <?php } ?>
            <li><i class="fas fa-sign-out-alt"></i><a href="Controller/c_signout.php">Đăng xuất</a></li>
        </ul>
    </div>
    <div class="main">
        <header>
            <h1><?php echo $userRole === 'Giảng viên' ? 'LỊCH DẠY' : 'THỜI KHÓA BIỂU'; ?></h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <div class="container">
            <div class="filter-form">
                <select id="hocKy" onchange="loadHocKy()">
                    <option value="" selected>Chọn học kỳ</option>
                </select>
                <select id="tuan" onchange="loadTKB()">
                    <option value="" selected>Chọn tuần</option>
                </select>
            </div>
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Thứ 2</th>
                        <th>Thứ 3</th>
                        <th>Thứ 4</th>
                        <th>Thứ 5</th>
                        <th>Thứ 6</th>
                        <th>Thứ 7</th>
                        <th>Chủ nhật</th>
                    </tr>
                </thead>
                <tbody id="tkbBody">
                    <tr>
                        <td>Tiết 1<br/>(6:30-7:20)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 2<br/>(7:20-8:10)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 3<br/>(8:10-9:00)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 4<br/>(9:00-9:50)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 5<br/>(9:50-10:40)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 6<br/>(10:40-11:30)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 7<br/>(12:30-13:20)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 8<br/>(13:20-14:10)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 9<br/>(14:10-15:00)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 10<br/>(15:00-15:50)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 11<br/>(15:50-16:40)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tiết 12<br/>(16:40-17:30)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Dữ liệu mẫu
        const sampleData = {
            dangKyHocPhanList: [
                {
                    maHP: "IT101",
                    maLop: "HP001_01",
                    tenHP: "Lập trình cơ bản",
                    soTinChi: 3,
                    siSoToiDa: 50,
                    dieuKienTienQuyet: null,
                    khoa: "CNTT",
                    nganh: "CNTT",
                    hocKy: "2025-1",
                    maGV: "GV001",
                    thu: "2",
                    tietBatDau: "1",
                    tietKetThuc: "3",
                    siSoHienTai: 0,
                    toaNha: "T01",
                    maPhong: "P101"
                },
                {
                    maHP: "IT102",
                    maLop: "HP002_01",
                    tenHP: "Cấu trúc dữ liệu",
                    soTinChi: 4,
                    siSoToiDa: 40,
                    dieuKienTienQuyet: "IT101",
                    khoa: "CNTT",
                    nganh: "CNTT",
                    hocKy: "2025-1",
                    maGV: "GV002",
                    thu: "3",
                    tietBatDau: "4",
                    tietKetThuc: "6",
                    siSoHienTai: 0,
                    toaNha: "T02",
                    maPhong: "P201"
                },
                {
                    maHP: "SP101",
                    maLop: "HP003_01",
                    tenHP: "Ngữ văn 1",
                    soTinChi: 3,
                    siSoToiDa: 45,
                    dieuKienTienQuyet: null,
                    khoa: "SP",
                    nganh: "SPNN",
                    hocKy: "2025-1",
                    maGV: "GV003",
                    thu: "4",
                    tietBatDau: "7",
                    tietKetThuc: "9",
                    siSoHienTai: 0,
                    toaNha: "T03",
                    maPhong: "P301"
                },
                {
                    maHP: "KT101",
                    maLop: "HP004_01",
                    tenHP: "Kinh tế vi mô",
                    soTinChi: 3,
                    siSoToiDa: 60,
                    dieuKienTienQuyet: null,
                    khoa: "KT",
                    nganh: "KTQD",
                    hocKy: "2025-1",
                    maGV: "GV004",
                    thu: "5",
                    tietBatDau: "1",
                    tietKetThuc: "3",
                    siSoHienTai: 0,
                    toaNha: "T01",
                    maPhong: "P101"
                }
            ],
            sinhVienDangKyList: [
                { maSinhVien: "SV001", maHP: "IT101", hocKy: "2025-1" },
                { maSinhVien: "SV002", maHP: "IT101", hocKy: "2025-1" },
                { maSinhVien: "SV001", maHP: "SP101", hocKy: "2025-1" }
            ],
            giangVienList: [
                { maGV: "GV001", tenGV: "Nguyễn Văn A" },
                { maGV: "GV002", tenGV: "Trần Thị B" },
                { maGV: "GV003", tenGV: "Lê Văn C" },
                { maGV: "GV004", tenGV: "Phạm Thị D" }
            ],
            phanCongGiangVienList: [
                { maGV: "GV001", maLop: "HP001_01", hocKy: "2025-1", tuan: "1-15" },
                { maGV: "GV002", maLop: "HP002_01", hocKy: "2025-1", tuan: "1-15" },
                { maGV: "GV003", maLop: "HP003_01", hocKy: "2025-1", tuan: "1-15" },
                { maGV: "GV004", maLop: "HP004_01", hocKy: "2025-1", tuan: "1-15" }
            ],
            lopHocPhanList: [
                { maLop: "HP001_01", tenLop: "CNTT1", maHP: "IT101" },
                { maLop: "HP002_01", tenLop: "CNTT2", maHP: "IT102" },
                { maLop: "HP003_01", tenLop: "SPNN1", maHP: "SP101" },
                { maLop: "HP004_01", tenLop: "KTQD1", maHP: "KT101" }
            ],
            toaNhaList: [
                { maToa: "T01", tenToa: "Tòa A" },
                { maToa: "T02", tenToa: "Tòa B" },
                { maToa: "T03", tenToa: "Tòa C" }
            ],
            phongHocList: [
                { toaNha: "T01", maPhong: "P101", tenPhong: "Phòng học A1", sucChua: 50 },
                { toaNha: "T02", maPhong: "P201", tenPhong: "Phòng học B1", sucChua: 40 },
                { toaNha: "T03", maPhong: "P301", tenPhong: "Phòng học C1", sucChua: 30 }
            ]
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Lưu dữ liệu mẫu vào localStorage nếu chưa có
            Object.keys(sampleData).forEach(key => {
                if (!localStorage.getItem(key)) {
                    localStorage.setItem(key, JSON.stringify(sampleData[key]));
                }
            });

            // Tạo danh sách tuần
            const tuanSelect = document.getElementById('tuan');
            for (let i = 1; i <= 15; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Tuần ${i}`;
                tuanSelect.appendChild(option);
            }

            // Tải danh sách học kỳ
            loadHocKy();
        });

        function loadHocKy() {
            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            const hocKyList = [...new Set(dangKyHocPhanList.map(dk => dk.hocKy))];
            const selectHocKy = document.getElementById('hocKy');
            selectHocKy.innerHTML = '<option value="" selected>Chọn học kỳ</option>';
            hocKyList.forEach(hocKy => {
                const option = document.createElement('option');
                option.value = hocKy;
                option.text = hocKy;
                selectHocKy.appendChild(option);
            });

            // Tải thời khóa biểu nếu đã chọn học kỳ
            loadTKB();
        }

        function loadTKB() {
            const hocKy = document.getElementById('hocKy').value;
            const tuan = document.getElementById('tuan').value;
            const userRole = '<?php echo $userRole; ?>';
            const userId = '<?php echo $userId; ?>';

            if (!hocKy || !tuan) {
                // Xóa dữ liệu cũ nếu không đủ thông tin
                const cells = document.querySelectorAll('.schedule-table td:not(:first-child)');
                cells.forEach(cell => cell.innerHTML = '');
                return;
            }

            // Lấy dữ liệu từ localStorage
            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            const sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];
            const giangVienList = JSON.parse(localStorage.getItem('giangVienList')) || [];
            const phanCongGiangVienList = JSON.parse(localStorage.getItem('phanCongGiangVienList')) || [];
            const lopHocPhanList = JSON.parse(localStorage.getItem('lopHocPhanList')) || [];
            const toaNhaList = JSON.parse(localStorage.getItem('toaNhaList')) || [];
            const phongHocList = JSON.parse(localStorage.getItem('phongHocList')) || [];

            // Xóa dữ liệu cũ
            const cells = document.querySelectorAll('.schedule-table td:not(:first-child)');
            cells.forEach(cell => cell.innerHTML = '');

            const tietTime = {
                '1': '6:30 - 7:20', '2': '7:20 - 8:10', '3': '8:10 - 9:00', '4': '9:00 - 9:50',
                '5': '9:50 - 10:40', '6': '10:40 - 11:30', '7': '12:30 - 13:20', '8': '13:20 - 14:10',
                '9': '14:10 - 15:00', '10': '15:00 - 15:50', '11': '15:50 - 16:40', '12': '16:40 - 17:30'
            };

            let scheduleData = {};

            if (userRole === 'Sinh viên') {
                // Lấy danh sách học phần mà sinh viên đã đăng ký
                const registeredClasses = sinhVienDangKyList
                    .filter(sv => sv.maSinhVien === userId && sv.hocKy === hocKy)
                    .map(sv => {
                        const dk = dangKyHocPhanList.find(item => item.maHP === sv.maHP && item.hocKy === sv.hocKy);
                        if (dk) {
                            const tenGV = giangVienList.find(gv => gv.maGV === dk.maGV)?.tenGV || dk.maGV;
                            const tenToa = toaNhaList.find(t => t.maToa === dk.toaNha)?.tenToa || dk.toaNha;
                            const phong = phongHocList.find(p => p.maPhong === dk.maPhong);
                            const tenPhong = phong ? `${dk.maPhong} - ${phong.tenPhong}` : dk.maPhong;
                            const day = {
                                '2': 'Thứ 2', '3': 'Thứ 3', '4': 'Thứ 4', '5': 'Thứ 5',
                                '6': 'Thứ 6', '7': 'Thứ 7', '8': 'Chủ nhật'
                            }[dk.thu];
                            return {
                                day: day,
                                subject: dk.tenHP,
                                room: `${tenToa} - ${tenPhong}`,
                                teacher: tenGV,
                                time: `${tietTime[dk.tietBatDau].split(' - ')[0]}-${tietTime[dk.tietKetThuc].split(' - ')[1]}`,
                                tietBatDau: parseInt(dk.tietBatDau),
                                tietKetThuc: parseInt(dk.tietKetThuc)
                            };
                        }
                        return null;
                    })
                    .filter(item => item !== null);

                // Chuyển đổi dữ liệu thành định dạng scheduleData
                registeredClasses.forEach(classInfo => {
                    if (!scheduleData[classInfo.day]) {
                        scheduleData[classInfo.day] = [];
                    }
                    scheduleData[classInfo.day].push(classInfo);
                });
            } else if (userRole === 'Giảng viên') {
                // Lấy danh sách lớp học phần mà giảng viên được phân công
                const assignedClasses = phanCongGiangVienList
                    .filter(pc => pc.maGV === userId && pc.hocKy === hocKy)
                    .filter(pc => {
                        const [startWeek, endWeek] = pc.tuan.split('-').map(Number);
                        const selectedWeek = parseInt(tuan);
                        return selectedWeek >= startWeek && selectedWeek <= endWeek;
                    })
                    .map(pc => {
                        const dk = dangKyHocPhanList.find(item => item.maLop === pc.maLop && item.hocKy === pc.hocKy);
                        if (dk) {
                            const lop = lopHocPhanList.find(l => l.maLop === pc.maLop);
                            const tenToa = toaNhaList.find(t => t.maToa === dk.toaNha)?.tenToa || dk.toaNha;
                            const phong = phongHocList.find(p => p.maPhong === dk.maPhong);
                            const tenPhong = phong ? `${dk.maPhong} - ${phong.tenPhong}` : dk.maPhong;
                            const day = {
                                '2': 'Thứ 2', '3': 'Thứ 3', '4': 'Thứ 4', '5': 'Thứ 5',
                                '6': 'Thứ 6', '7': 'Thứ 7', '8': 'Chủ nhật'
                            }[dk.thu];
                            return {
                                day: day,
                                subject: dk.tenHP,
                                room: `${tenToa} - ${tenPhong}`,
                                class: lop?.tenLop || 'Không xác định',
                                time: `${tietTime[dk.tietBatDau].split(' - ')[0]}-${tietTime[dk.tietKetThuc].split(' - ')[1]}`,
                                tietBatDau: parseInt(dk.tietBatDau),
                                tietKetThuc: parseInt(dk.tietKetThuc)
                            };
                        }
                        return null;
                    })
                    .filter(item => item !== null);

                // Chuyển đổi dữ liệu thành định dạng scheduleData
                assignedClasses.forEach(classInfo => {
                    if (!scheduleData[classInfo.day]) {
                        scheduleData[classInfo.day] = [];
                    }
                    scheduleData[classInfo.day].push(classInfo);
                });
            }

            // Hiển thị thời khóa biểu
            for (const [day, classes] of Object.entries(scheduleData)) {
                classes.forEach(classInfo => {
                    const dayCol = document.querySelector(`th:contains('${day}')`);
                    if (dayCol) {
                        const colIndex = dayCol.cellIndex;
                        const rowIndex = classInfo.tietBatDau;

                        for (let i = rowIndex; i <= classInfo.tietKetThuc; i++) {
                            const cell = document.querySelector(`.schedule-table tr:nth-child(${i}) td:nth-child(${colIndex + 1})`);
                            if (cell && i === rowIndex) {
                                const classElement = document.createElement('div');
                                classElement.className = 'class-item';
                                if (userRole === 'Sinh viên') {
                                    classElement.innerHTML = `
                                        <div class="subject">${classInfo.subject}</div>
                                        <div class="room">Phòng: ${classInfo.room}</div>
                                        <div class="teacher">GV: ${classInfo.teacher}</div>
                                    `;
                                } else {
                                    classElement.innerHTML = `
                                        <div class="subject">${classInfo.subject}</div>
                                        <div class="room">Phòng: ${classInfo.room}</div>
                                        <div class="class">Lớp: ${classInfo.class}</div>
                                    `;
                                }
                                classElement.style.height = `${(classInfo.tietKetThuc - classInfo.tietBatDau + 1) * 100}px`;
                                cell.appendChild(classElement);
                            }
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>