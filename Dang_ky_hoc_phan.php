<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký học phần</title>
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
            margin-bottom: 1rem;
            background-color: #fff;
            padding: 1rem;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .filter-form select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }
        .filter-form button {
            padding: 8px 16px;
            background-color: #245139;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .filter-form button:hover {
            background-color: #1e4030;
        }
        .timetable-btn {
            padding: 8px 16px;
            background-color: #245139;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 1rem;
        }
        .timetable-btn:hover {
            background-color: #1e4030;
        }
        .timetable-section {
            display: none;
            margin-bottom: 2rem;
            background-color: #fff;
            padding: 1rem;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .timetable-section.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #245139;
            color: #fff;
        }
        .actions .register-btn {
            padding: 5px 10px;
            border: none;
            background-color: #2a4c96;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .actions .register-btn:hover {
            background-color: #230c67;
        }
        .actions .cancel-btn {
            padding: 5px 10px;
            border: none;
            background-color: #cc4c4c;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .actions .cancel-btn:hover {
            background-color: #6f0e0e;
        }
        .notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .notification.error {
            background-color: #cc4c4c;
        }
        .notification.active {
            display: block;
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
            .filter-form select {
                width: 100%;
            }
            .filter-form button {
                width: 100%;
            }
            .timetable-btn {
                width: 100%;
            }
            table {
                font-size: 0.9rem;
            }
            th, td {
                padding: 8px;
            }
            .actions {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
            .actions .register-btn, .actions .cancel-btn {
                padding: 4px 8px;
                font-size: 0.85rem;
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
            table {
                font-size: 0.8rem;
            }
            th, td {
                padding: 6px;
            }
            .actions .register-btn, .actions .cancel-btn {
                padding: 3px 6px;
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
                <div class="role">Nguyễn Văn A</div>
                <div>Sinh viên</div>
            </div>
        </div>
        <ul>
            <li class="active"><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem thời khóa biểu</a></li>
            <li><i class="fas fa-sign-out-alt"></i><a href="Controller/c_signout.php">Đăng xuất</a></li>
        </ul>
    </div>
    <div class="main">
        <header>
            <h1>ĐĂNG KÝ HỌC PHẦN</h1>
            <div class="login">
                Xin chào, Nguyễn Văn A |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <div class="container">
            <button class="timetable-btn" onclick="toggleTimetable()">Xem thời khóa biểu cá nhân</button>
            <div class="timetable-section" id="timetableSection">
                <h3>Thời khóa biểu cá nhân</h3>
                <table id="bangThoiKhoaBieu">
                    <thead>
                        <tr>
                            <th>Học phần</th>
                            <th>Học kỳ</th>
                            <th>Thời gian</th>
                            <th>Phòng học</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="filter-form">
                <select id="khoa">
                    <option value="" selected>Tất cả khoa</option>
                </select>
                <select id="nganh">
                    <option value="" selected>Tất cả ngành</option>
                </select>
                <select id="hocKy">
                    <option value="" selected>Tất cả học kỳ</option>
                </select>
                <button onclick="filterHocPhan()">Áp dụng</button>
            </div>
            <table id="bangDangKyHocPhan">
                <thead>
                    <tr>
                        <th>Khoa</th>
                        <th>Ngành</th>
                        <th>Học phần</th>
                        <th>Học kỳ</th>
                        <th>Thời gian</th>
                        <th>Phòng học</th>
                        <th>Số lượng tối đa</th>
                        <th>Số lượng hiện tại</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="notification" id="notification"></div>
    </div>
    <script>
        // Dữ liệu mẫu
        const sampleData = {
            khoaList: [
                { maKhoa: "CNTT", tenKhoa: "Công Nghệ Thông Tin" },
                { maKhoa: "SP", tenKhoa: "Sư Phạm" },
                { maKhoa: "KT", tenKhoa: "Kinh Tế" }
            ],
            nganhList: [
                { maNganh: "CNTT", tenNganh: "Công Nghệ Thông Tin", maKhoa: "CNTT" },
                { maNganh: "KHMT", tenNganh: "Khoa Học Máy Tính", maKhoa: "CNTT" },
                { maNganh: "SPNN", tenNganh: "Sư Phạm Ngữ Văn", maKhoa: "SP" },
                { maNganh: "KTQD", tenNganh: "Kinh Tế Quốc Dân", maKhoa: "KT" }
            ],
            hocPhanList: [
                {
                    ma: "IT101",
                    ten: "Lập trình cơ bản",
                    soTinChi: 3,
                    siSoToiDa: 50,
                    dieuKienTienQuyet: null,
                    khoa: "CNTT",
                    nganh: "CNTT",
                    hocKy: "2025-1",
                    trangThai: "Đã công bố"
                },
                {
                    ma: "IT102",
                    ten: "Cấu trúc dữ liệu",
                    soTinChi: 4,
                    siSoToiDa: 40,
                    dieuKienTienQuyet: "IT101",
                    khoa: "CNTT",
                    nganh: "CNTT",
                    hocKy: "2025-1",
                    trangThai: "Đã công bố"
                },
                {
                    ma: "SP101",
                    ten: "Ngữ văn 1",
                    soTinChi: 3,
                    siSoToiDa: 45,
                    dieuKienTienQuyet: null,
                    khoa: "SP",
                    nganh: "SPNN",
                    hocKy: "2025-1",
                    trangThai: "Đã công bố"
                },
                {
                    ma: "KT101",
                    ten: "Kinh tế vi mô",
                    soTinChi: 3,
                    siSoToiDa: 60,
                    dieuKienTienQuyet: null,
                    khoa: "KT",
                    nganh: "KTQD",
                    hocKy: "2025-1",
                    trangThai: "Đã công bố"
                }
            ],
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
            completedCourses: [
                { maSinhVien: "SV001", maHP: "IT101", status: "Đã qua" }
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
            // Đảm bảo xóa dữ liệu cũ trong localStorage trước khi lưu dữ liệu mới
            Object.keys(sampleData).forEach(key => {
                localStorage.removeItem(key);
                localStorage.setItem(key, JSON.stringify(sampleData[key]));
            });

            // Giả lập mã sinh viên
            if (!sessionStorage.getItem('maSinhVien')) {
                sessionStorage.setItem('maSinhVien', 'SV001');
            }

            loadKhoa();
            loadNganh();
            loadHocKy();
            loadHocPhan();
            loadThoiKhoaBieu();
        });

        const registrationPeriod = {
            start: new Date('2025-05-01T00:00:00'),
            end: new Date('2025-05-30T23:59:59')
        };

        function loadKhoa() {
            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
            const selectKhoa = document.getElementById('khoa');
            selectKhoa.innerHTML = '<option value="" selected>Tất cả khoa</option>';
            khoaList.forEach(khoa => {
                const option = document.createElement('option');
                option.value = khoa.maKhoa;
                option.text = khoa.tenKhoa;
                selectKhoa.appendChild(option);
            });
        }

        function loadNganh() {
            const nganhList = JSON.parse(localStorage.getItem('nganhList')) || [];
            const selectNganh = document.getElementById('nganh');
            const selectedKhoa = document.getElementById('khoa').value;
            selectNganh.innerHTML = '<option value="" selected>Tất cả ngành</option>';
            nganhList.filter(nganh => !selectedKhoa || nganh.maKhoa === selectedKhoa).forEach(nganh => {
                const option = document.createElement('option');
                option.value = nganh.maNganh;
                option.text = nganh.tenNganh;
                selectNganh.appendChild(option);
            });
        }

        function loadHocKy() {
            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            const hocKyList = [...new Set(dangKyHocPhanList.map(dk => dk.hocKy))];
            const selectHocKy = document.getElementById('hocKy');
            selectHocKy.innerHTML = '<option value="" selected>Tất cả học kỳ</option>';
            hocKyList.forEach(hocKy => {
                const option = document.createElement('option');
                option.value = hocKy;
                option.text = hocKy;
                selectHocKy.appendChild(option);
            });
        }

        function loadHocPhan() {
            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
            const nganhList = JSON.parse(localStorage.getItem('nganhList')) || [];
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const toaNhaList = JSON.parse(localStorage.getItem('toaNhaList')) || [];
            const phongHocList = JSON.parse(localStorage.getItem('phongHocList')) || [];
            const sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];
            const maSinhVien = sessionStorage.getItem('maSinhVien');

            const selectedKhoa = document.getElementById('khoa').value;
            const selectedNganh = document.getElementById('nganh').value;
            const selectedHocKy = document.getElementById('hocKy').value;

            const tbody = document.getElementById('bangDangKyHocPhan').querySelector('tbody');
            tbody.innerHTML = '';

            // Kiểm tra dữ liệu
            if (!dangKyHocPhanList.length || !hocPhanList.length) {
                showNotification('Không có dữ liệu lớp học phần để hiển thị.', true);
                return;
            }

            const filteredHocPhan = dangKyHocPhanList
                .filter(dk => {
                    const hp = hocPhanList.find(item => item.ma === dk.maHP && item.hocKy === dk.hocKy);
                    if (!hp) return false;
                    const matchTrangThai = hp.trangThai === 'Đã công bố';
                    const matchKhoa = !selectedKhoa || dk.khoa === selectedKhoa;
                    const matchNganh = !selectedNganh || dk.nganh === selectedNganh;
                    const matchHocKy = !selectedHocKy || dk.hocKy === selectedHocKy;
                    return matchTrangThai && matchKhoa && matchNganh && matchHocKy;
                });

            if (!filteredHocPhan.length) {
                showNotification('Không tìm thấy lớp học phần phù hợp với bộ lọc.', true);
                return;
            }

            filteredHocPhan.forEach(dk => {
                const tenKhoa = khoaList.find(k => k.maKhoa === dk.khoa)?.tenKhoa || dk.khoa;
                const tenNganh = nganhList.find(n => n.maNganh === dk.nganh)?.tenNganh || dk.nganh;
                const hp = hocPhanList.find(item => item.ma === dk.maHP);
                const tenToa = toaNhaList.find(t => t.maToa === dk.toaNha)?.tenToa || dk.toaNha;
                const phong = phongHocList.find(p => p.maPhong === dk.maPhong);
                const tenHP = hp ? `${dk.maHP} - ${hp.ten}` : dk.maHP;
                const tenPhong = phong ? `${dk.maPhong} - ${phong.tenPhong}` : dk.maPhong;

                const thuText = {
                    '2': 'Thứ 2', '3': 'Thứ 3', '4': 'Thứ 4', '5': 'Thứ 5',
                    '6': 'Thứ 6', '7': 'Thứ 7', '8': 'Chủ nhật'
                }[dk.thu];

                const tietTime = {
                    '1': '6:30 - 7:20', '2': '7:20 - 8:10', '3': '8:10 - 9:00', '4': '9:00 - 9:50',
                    '5': '9:50 - 10:40', '6': '10:40 - 11:30', '7': '12:30 - 13:20', '8': '13:20 - 14:10',
                    '9': '14:10 - 15:00', '10': '15:00 - 15:50', '11': '15:50 - 16:40', '12': '16:40 - 17:30'
                };

                const thoiGian = `${thuText}, Tiết ${dk.tietBatDau} - ${dk.tietKetThuc} (${tietTime[dk.tietBatDau].split(' - ')[0]} - ${tietTime[dk.tietKetThuc].split(' - ')[1]})`;

                const soLuongDangKy = sinhVienDangKyList.filter(sv => sv.maHP === dk.maHP && sv.hocKy === dk.hocKy).length;
                const siSoToiDa = dk.siSoToiDa;

                const isRegistered = sinhVienDangKyList.some(sv => sv.maSinhVien === maSinhVien && sv.maHP === dk.maHP && sv.hocKy === dk.hocKy);

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${tenKhoa}</td>
                    <td>${tenNganh}</td>
                    <td>${tenHP}</td>
                    <td>${dk.hocKy}</td>
                    <td>${thoiGian}</td>
                    <td>${tenToa} - ${tenPhong}</td>
                    <td>${siSoToiDa}</td>
                    <td>${soLuongDangKy}</td>
                    <td class="actions">
                        ${isRegistered ?
                            `<button class="cancel-btn" onclick="huyDangKy('${dk.maHP}', '${dk.hocKy}')"><i class="fas fa-times"></i></button>` :
                            soLuongDangKy < siSoToiDa ?
                                `<button class="register-btn" onclick="dangKyHocPhan('${dk.maHP}', '${dk.hocKy}')"><i class="fas fa-check"></i></button>` :
                                `<button class="register-btn" disabled><i class="fas fa-ban"></i></button>`
                        }
                    </td>
                `;
                tbody.appendChild(newRow);
            });

            showNotification(`Đã hiển thị ${filteredHocPhan.length} lớp học phần.`);
        }

        function loadThoiKhoaBieu() {
            const sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];
            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const toaNhaList = JSON.parse(localStorage.getItem('toaNhaList')) || [];
            const phongHocList = JSON.parse(localStorage.getItem('phongHocList')) || [];
            const maSinhVien = sessionStorage.getItem('maSinhVien');

            const tbody = document.getElementById('bangThoiKhoaBieu').querySelector('tbody');
            tbody.innerHTML = '';

            sinhVienDangKyList
                .filter(sv => sv.maSinhVien === maSinhVien)
                .forEach(sv => {
                    const dk = dangKyHocPhanList.find(item => item.maHP === sv.maHP && item.hocKy === sv.hocKy);
                    if (!dk) return;

                    const hp = hocPhanList.find(item => item.ma === sv.maHP);
                    const tenHP = hp ? `${sv.maHP} - ${hp.ten}` : sv.maHP;
                    const tenToa = toaNhaList.find(t => t.maToa === dk.toaNha)?.tenToa || dk.toaNha;
                    const phong = phongHocList.find(p => p.maPhong === dk.maPhong);
                    const tenPhong = phong ? `${dk.maPhong} - ${phong.tenPhong}` : dk.maPhong;

                    const thuText = {
                        '2': 'Thứ 2', '3': 'Thứ 3', '4': 'Thứ 4', '5': 'Thứ 5',
                        '6': 'Thứ 6', '7': 'Thứ 7', '8': 'Chủ nhật'
                    }[dk.thu];

                    const tietTime = {
                        '1': '6:30 - 7:20', '2': '7:20 - 8:10', '3': '8:10 - 9:00', '4': '9:00 - 9:50',
                        '5': '9:50 - 10:40', '6': '10:40 - 11:30', '7': '12:30 - 13:20', '8': '13:20 - 14:10',
                        '9': '14:10 - 15:00', '10': '15:00 - 15:50', '11': '15:50 - 16:40', '12': '16:40 - 17:30'
                    };

                    const thoiGian = `${thuText}, Tiết ${dk.tietBatDau} - ${dk.tietKetThuc} (${tietTime[dk.tietBatDau].split(' - ')[0]} - ${tietTime[dk.tietKetThuc].split(' - ')[1]})`;

                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${tenHP}</td>
                        <td>${sv.hocKy}</td>
                        <td>${thoiGian}</td>
                        <td>${tenToa} - ${tenPhong}</td>
                    `;
                    tbody.appendChild(newRow);
                });
        }

        function toggleTimetable() {
            const timetableSection = document.getElementById('timetableSection');
            timetableSection.classList.toggle('active');
            loadThoiKhoaBieu();
        }

        function filterHocPhan() {
            loadNganh();
            loadHocPhan();
        }

        function showNotification(message, isError = false) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${isError ? 'error' : ''} active`;
            setTimeout(() => {
                notification.className = 'notification';
            }, 3000);
        }

        function isRegistrationPeriod() {
            const now = new Date();
            return now >= registrationPeriod.start && now <= registrationPeriod.end;
        }

        function dangKyHocPhan(maHP, hocKy) {
            if (!isRegistrationPeriod()) {
                showNotification('Ngoài thời gian đăng ký học phần.', true);
                return;
            }

            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            const sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const completedCourses = JSON.parse(localStorage.getItem('completedCourses')) || [];
            const maSinhVien = sessionStorage.getItem('maSinhVien');

            const dk = dangKyHocPhanList.find(item => item.maHP === maHP && item.hocKy === hocKy);
            if (!dk) {
                showNotification('Học phần không tồn tại.', true);
                return;
            }

            const soLuongDangKy = sinhVienDangKyList.filter(sv => sv.maHP === maHP && sv.hocKy === hocKy).length;
            if (soLuongDangKy >= dk.siSoToiDa) {
                showNotification('Học phần đã hết chỗ.', true);
                return;
            }

            if (sinhVienDangKyList.some(sv => sv.maSinhVien === maSinhVien && sv.maHP === maHP && sv.hocKy === hocKy)) {
                showNotification('Bạn đã đăng ký học phần này.', true);
                return;
            }

            const hp = hocPhanList.find(item => item.ma === maHP);
            if (hp?.dieuKienTienQuyet) {
                const completed = completedCourses.some(c => c.maSinhVien === maSinhVien && c.maHP === hp.dieuKienTienQuyet && c.status === 'Đã qua');
                if (!completed) {
                    const tienQuyetHP = hocPhanList.find(item => item.ma === hp.dieuKienTienQuyet);
                    showNotification(`Bạn cần hoàn thành "${tienQuyetHP?.ten || hp.dieuKienTienQuyet}" trước khi đăng ký.`, true);
                    return;
                }
            }

            const conflict = sinhVienDangKyList.some(sv => 
                sv.maSinhVien === maSinhVien &&
                sv.hocKy === hocKy &&
                dangKyHocPhanList.some(otherDk => 
                    otherDk.maHP === sv.maHP &&
                    otherDk.hocKy === hocKy &&
                    otherDk.thu === dk.thu &&
                    (parseInt(otherDk.tietBatDau) <= parseInt(dk.tietKetThuc) && parseInt(otherDk.tietKetThuc) >= parseInt(dk.tietBatDau))
                )
            );
            if (conflict) {
                showNotification('Thời gian học phần này trùng với một học phần đã đăng ký.', true);
                return;
            }

            sinhVienDangKyList.push({ maSinhVien, maHP, hocKy });
            localStorage.setItem('sinhVienDangKyList', JSON.stringify(sinhVienDangKyList));
            showNotification('Đăng ký học phần thành công!');
            loadHocPhan();
            loadThoiKhoaBieu();
        }

        function huyDangKy(maHP, hocKy) {
            if (!isRegistrationPeriod()) {
                showNotification('Ngoài thời gian hủy đăng ký.', true);
                return;
            }

            const maSinhVien = sessionStorage.getItem('maSinhVien');
            let sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];
            sinhVienDangKyList = sinhVienDangKyList.filter(sv => !(sv.maSinhVien === maSinhVien && sv.maHP === maHP && sv.hocKy === hocKy));
            localStorage.setItem('sinhVienDangKyList', JSON.stringify(sinhVienDangKyList));
            showNotification('Hủy đăng ký thành công!');
            loadHocPhan();
            loadThoiKhoaBieu();
        }

        function dangXuat() {
            sessionStorage.removeItem('maSinhVien');
            window.location.href = 'Dang_Nhap.php';
        }
    </script>
</body>
</html>