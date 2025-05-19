<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân công giảng viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
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
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table td select, table td input {
            width: 100%;
            padding: 0;
            border: none;
            background: transparent;
            font-size: 1rem;
            font-family: inherit;
        }
        table td select:focus, table td input:focus {
            outline: none;
            border-bottom: 1px solid #245139;
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
        .actions .edit-btn {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            background-color: #2a4c96;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .actions .edit-btn:hover {
            background-color: #230c67;
        }
        .actions .delete-btn {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            background-color: #cc4c4c;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .actions .delete-btn:hover {
            background-color: #6f0e0e;
        }
        .add-form {
            margin-bottom: 2rem;
            background-color: #fff;
            padding: 1rem;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .add-form select, .add-form input {
            margin: 0.5rem 1rem 0.5rem 0;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 1rem);
        }
        .add-form button {
            padding: 8px 16px;
            background-color: #245139;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-form button:hover {
            background-color: #1e4030;
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
            .add-form {
                padding: 0.5rem;
            }
            .add-form select, .add-form input {
                width: 100%;
                margin: 0.25rem 0;
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
            .actions .edit-btn,
            .actions .delete-btn {
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
            .actions .edit-btn,
            .actions .delete-btn {
                padding: 3px 6px;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="user-info">
            <div class="avatar"><img src="avatar-15.png" alt="avatar"></div>
            <div class="details"><div class="role">Quản trị viên</div></div>
        </div>
        <ul>
            <li><i class="fas fa-book"></i><a href="Quan_ly_hoc_phan.html">Quản lý học phần</a></li>
            <li class="active"><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.html">Phân công giảng viên</a></li>
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.html">Quản lý phòng học</a></li>
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.html">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-alt"></i><a href="#">Tra cứu lịch học</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="#">Xem thời khóa biểu</a></li>
            <li><i class="fas fa-sign-out-alt"></i><a href="#" onclick="dangXuat()">Đăng xuất</a></li>
        </ul>
    </div>
    <div class="main">
        <header>
            <h1>PHÂN CÔNG GIẢNG VIÊN</h1>
            <div class="login">
                Xin chào, Quản trị viên |
                <a href="#" style="color: white;" onclick="dangXuat()"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <div class="container">
            <div class="add-form">
                <h3>Phân công giảng viên</h3>
                <select id="khoa" required>
                    <option value="" disabled selected>Chọn khoa</option>
                </select>
                <select id="maHP" required>
                    <option value="" disabled selected>Chọn học phần</option>
                </select>
                <input type="text" id="maLop" placeholder="Mã lớp (VD: HP001_01)" required>
                <select id="maGV" required>
                    <option value="" disabled selected>Chọn giảng viên</option>
                </select>
                <select id="hocKy" required>
                    <option value="" disabled selected>Chọn học kỳ</option>
                </select>
                <select id="thu" required>
                    <option value="" disabled selected>Chọn thứ</option>
                    <option value="2">Thứ 2</option>
                    <option value="3">Thứ 3</option>
                    <option value="4">Thứ 4</option>
                    <option value="5">Thứ 5</option>
                    <option value="6">Thứ 6</option>
                    <option value="7">Thứ 7</option>
                    <option value="8">Chủ nhật</option>
                </select>
                <select id="tietBatDau" required>
                    <option value="" disabled selected>Chọn tiết bắt đầu</option>
                    <option value="1">Tiết 1 (6:30 - 7:20)</option>
                    <option value="2">Tiết 2 (7:20 - 8:10)</option>
                    <option value="3">Tiết 3 (8:10 - 9:00)</option>
                    <option value="4">Tiết 4 (9:00 - 9:50)</option>
                    <option value="5">Tiết 5 (9:50 - 10:40)</option>
                    <option value="6">Tiết 6 (10:40 - 11:30)</option>
                    <option value="7">Tiết 7 (12:30 - 13:20)</option>
                    <option value="8">Tiết 8 (13:20 - 14:10)</option>
                    <option value="9">Tiết 9 (14:10 - 15:00)</option>
                    <option value="10">Tiết 10 (15:00 - 15:50)</option>
                    <option value="11">Tiết 11 (15:50 - 16:40)</option>
                    <option value="12">Tiết 12 (16:40 - 17:30)</option>
                </select>
                <select id="tietKetThuc" required>
                    <option value="" disabled selected>Chọn tiết kết thúc</option>
                    <option value="1">Tiết 1 (6:30 - 7:20)</option>
                    <option value="2">Tiết 2 (7:20 - 8:10)</option>
                    <option value="3">Tiết 3 (8:10 - 9:00)</option>
                    <option value="4">Tiết 4 (9:00 - 9:50)</option>
                    <option value="5">Tiết 5 (9:50 - 10:40)</option>
                    <option value="6">Tiết 6 (10:40 - 11:30)</option>
                    <option value="7">Tiết 7 (12:30 - 13:20)</option>
                    <option value="8">Tiết 8 (13:20 - 14:10)</option>
                    <option value="9">Tiết 9 (14:10 - 15:00)</option>
                    <option value="10">Tiết 10 (15:00 - 15:50)</option>
                    <option value="11">Tiết 11 (15:50 - 16:40)</option>
                    <option value="12">Tiết 12 (16:40 - 17:30)</option>
                </select>
                <button onclick="phanCongGiangVien()">Phân công</button>
            </div>
            <table id="bangPhanCong">
                <thead>
                    <tr>
                        <th>Khoa</th>
                        <th>Học phần</th>
                        <th>Mã lớp</th>
                        <th>Giảng viên</th>
                        <th>Học kỳ</th>
                        <th>Thời gian</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="notification" id="notification"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Khởi tạo dữ liệu mẫu
            const giangVienList = JSON.parse(localStorage.getItem('giangVienList')) || [
                { maGV: 'GV001', tenGV: 'Nguyễn Văn A' },
                { maGV: 'GV002', tenGV: 'Trần Thị B' }
            ];
            localStorage.setItem('giangVienList', JSON.stringify(giangVienList));

            loadKhoa();
            loadHocPhan();
            loadGiangVien();
            loadHocKy();
            loadPhanCong();

            // Gắn sự kiện change cho học kỳ và khoa
            document.getElementById('hocKy').addEventListener('change', function() {
                const currentMaHP = document.getElementById('maHP').value;
                loadHocPhan(currentMaHP);
            });
            document.getElementById('khoa').addEventListener('change', function() {
                const currentMaHP = document.getElementById('maHP').value;
                loadHocPhan(currentMaHP);
            });
        });

        function loadKhoa() {
            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
            const selectKhoa = document.getElementById('khoa');
            selectKhoa.innerHTML = '<option value="" disabled selected>Chọn khoa</option>';
            khoaList.forEach(khoa => {
                const option = document.createElement('option');
                option.value = khoa.maKhoa;
                option.text = khoa.tenKhoa;
                selectKhoa.appendChild(option);
            });
        }

        function loadHocPhan(selectedMaHP = '') {
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const selectHocPhan = document.getElementById('maHP');
            const selectedKhoa = document.getElementById('khoa').value;
            const selectedHocKy = document.getElementById('hocKy').value;

            const currentMaHP = selectedMaHP || selectHocPhan.value;
            selectHocPhan.innerHTML = '<option value="" disabled selected>Chọn học phần</option>';
            const filteredHocPhan = hocPhanList.filter(hp => 
                hp.trangThai === 'Đã công bố' && 
                (!selectedKhoa || hp.khoa === selectedKhoa) && 
                (!selectedHocKy || hp.hocKy === selectedHocKy)
            );

            filteredHocPhan.forEach(hp => {
                const option = document.createElement('option');
                option.value = hp.ma;
                option.text = `${hp.ma} - ${hp.ten}`;
                if (hp.ma === currentMaHP && (!selectedHocKy || hp.hocKy === selectedHocKy)) {
                    option.selected = true;
                }
                selectHocPhan.appendChild(option);
            });

            if (currentMaHP && !filteredHocPhan.some(hp => hp.ma === currentMaHP)) {
                selectHocPhan.value = '';
            }
        }

        function loadGiangVien() {
            const giangVienList = JSON.parse(localStorage.getItem('giangVienList')) || [];
            const selectGiangVien = document.getElementById('maGV');
            selectGiangVien.innerHTML = '<option value="" disabled selected>Chọn giảng viên</option>';
            giangVienList.forEach(gv => {
                const option = document.createElement('option');
                option.value = gv.maGV;
                option.text = `${gv.maGV} - ${gv.tenGV}`;
                selectGiangVien.appendChild(option);
            });
        }

        function loadHocKy() {
            const hocKyList = JSON.parse(localStorage.getItem('hocKyList')) || [];
            const selectHocKy = document.getElementById('hocKy');
            selectHocKy.innerHTML = '<option value="" disabled selected>Chọn học kỳ</option>';
            hocKyList.forEach(hocKy => {
                const option = document.createElement('option');
                option.value = hocKy;
                option.text = hocKy;
                selectHocKy.appendChild(option);
            });
        }

        function showNotification(message, isError = false) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${isError ? 'error' : ''} active`;
            setTimeout(() => {
                notification.className = 'notification';
            }, 3000);
        }

        function phanCongGiangVien() {
            const khoa = document.getElementById('khoa').value;
            const maHP = document.getElementById('maHP').value;
            const maLop = document.getElementById('maLop').value;
            const maGV = document.getElementById('maGV').value;
            const hocKy = document.getElementById('hocKy').value;
            const thu = document.getElementById('thu').value;
            const tietBatDau = document.getElementById('tietBatDau').value;
            const tietKetThuc = document.getElementById('tietKetThuc').value;

            if (!khoa || !maHP || !maLop || !maGV || !hocKy || !thu || !tietBatDau || !tietKetThuc) {
                showNotification("Vui lòng nhập đầy đủ thông tin.", true);
                return;
            }

            if (!/^\d{4}-\d$/.test(hocKy)) {
                showNotification("Học kỳ phải có định dạng YYYY-N (VD: 2024-1).", true);
                return;
            }

            if (!/^[A-Z0-9]+_\d{2}$/.test(maLop)) {
                showNotification("Mã lớp phải có định dạng HPXXX_NN (VD: HP001_01).", true);
                return;
            }

            if (parseInt(tietKetThuc) < parseInt(tietBatDau)) {
                showNotification("Tiết kết thúc phải lớn hơn hoặc bằng tiết bắt đầu.", true);
                return;
            }

            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const hp = hocPhanList.find(item => item.ma === maHP && item.hocKy === hocKy);
            if (!hp || hp.trangThai !== 'Đã công bố') {
                showNotification("Học phần chưa được công bố hoặc không tồn tại.", true);
                return;
            }

            const phanCongList = JSON.parse(localStorage.getItem('phanCongList')) || [];
            if (phanCongList.some(item => item.maLop === maLop && item.hocKy === hocKy)) {
                showNotification("Mã lớp này đã được phân công trong học kỳ này.", true);
                return;
            }

            const conflict = phanCongList.some(item => 
                item.maGV === maGV && 
                item.thu === thu && 
                item.hocKy === hocKy &&
                (parseInt(item.tietBatDau) <= parseInt(tietKetThuc) && parseInt(item.tietKetThuc) >= parseInt(tietBatDau))
            );
            if (conflict) {
                showNotification("Giảng viên đã được phân công trong khoảng thời gian này.", true);
                return;
            }

            const phanCong = { khoa, maHP, maLop, maGV, hocKy, thu, tietBatDau, tietKetThuc };
            phanCongList.push(phanCong);
            localStorage.setItem('phanCongList', JSON.stringify(phanCongList));

            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            dangKyHocPhanList.push({
                maHP,
                maLop,
                tenHP: hp.ten,
                soTinChi: hp.soTinChi,
                siSoToiDa: hp.siSoToiDa,
                dieuKienTienQuyet: hp.dieuKienTienQuyet || null,
                khoa,
                hocKy,
                maGV,
                thu,
                tietBatDau,
                tietKetThuc,
                siSoHienTai: 0
            });
            localStorage.setItem('dangKyHocPhanList', JSON.stringify(dangKyHocPhanList));

            themDongVaoBang(khoa, maHP, maLop, maGV, hocKy, thu, tietBatDau, tietKetThuc);

            showNotification("Phân công giảng viên thành công!");
            document.getElementById('khoa').value = '';
            document.getElementById('maHP').value = '';
            document.getElementById('maLop').value = '';
            document.getElementById('maGV').value = '';
            document.getElementById('hocKy').value = '';
            document.getElementById('thu').value = '';
            document.getElementById('tietBatDau').value = '';
            document.getElementById('tietKetThuc').value = '';
            loadHocPhan();
        }

        function themDongVaoBang(khoa, maHP, maLop, maGV, hocKy, thu, tietBatDau, tietKetThuc) {
            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const giangVienList = JSON.parse(localStorage.getItem('giangVienList')) || [];
            const tenKhoa = khoaList.find(k => k.maKhoa === khoa)?.tenKhoa || khoa;
            const hp = hocPhanList.find(item => item.ma === maHP);
            const gv = giangVienList.find(item => item.maGV === maGV);
            const tenHP = hp ? `${maHP} - ${hp.ten}` : maHP;
            const tenGV = gv ? `${gv.tenGV}` : maGV;

            const thuText = {
                '2': 'Thứ 2',
                '3': 'Thứ 3',
                '4': 'Thứ 4',
                '5': 'Thứ 5',
                '6': 'Thứ 6',
                '7': 'Thứ 7',
                '8': 'Chủ nhật'
            }[thu];

            const tietTime = {
                '1': '6:30 - 7:20',
                '2': '7:20 - 8:10',
                '3': '8:10 - 9:00',
                '4': '9:00 - 9:50',
                '5': '9:50 - 10:40',
                '6': '10:40 - 11:30',
                '7': '12:30 - 13:20',
                '8': '13:20 - 14:10',
                '9': '14:10 - 15:00',
                '10': '15:00 - 15:50',
                '11': '15:50 - 16:40',
                '12': '16:40 - 17:30'
            };

            const thoiGian = `${thuText}, Tiết ${tietBatDau} - ${tietKetThuc} (${tietTime[tietBatDau].split(' - ')[0]} - ${tietTime[tietKetThuc].split(' - ')[1]})`;

            const tbody = document.getElementById('bangPhanCong').querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${tenKhoa}</td>
                <td>${tenHP}</td>
                <td>${maLop}</td>
                <td>${tenGV}</td>
                <td>${hocKy}</td>
                <td>${thoiGian}</td>
                <td class="actions">
                    <button class="edit-btn" onclick="chinhSuaDong(this)">Chỉnh sửa</button>
                    <button class="delete-btn" onclick="xoaDong(this)">Xóa</button>
                </td>
            `;
            tbody.appendChild(newRow);
        }

        function loadPhanCong() {
            const phanCongList = JSON.parse(localStorage.getItem('phanCongList')) || [];
            const tbody = document.getElementById('bangPhanCong').querySelector('tbody');
            tbody.innerHTML = '';
            phanCongList.forEach(pc => {
                themDongVaoBang(pc.khoa, pc.maHP, pc.maLop, pc.maGV, pc.hocKy, pc.thu, pc.tietBatDau, pc.tietKetThuc);
            });
        }

        function chinhSuaDong(button) {
            const row = button.parentElement.parentElement;
            const cells = row.querySelectorAll('td');

            const tenKhoa = cells[0].innerText;
            const maHPText = cells[1].innerText.split(' - ')[0];
            const maLop = cells[2].innerText;
            const tenGV = cells[3].innerText;
            const hocKy = cells[4].innerText;
            const thoiGian = cells[5].innerText;
            const thuText = thoiGian.split(', ')[0];
            const tietText = thoiGian.split(', ')[1].split(' (')[0].split(' - ');
            const tietBatDau = tietText[0].split(' ')[1];
            const tietKetThuc = tietText[1];

            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const giangVienList = JSON.parse(localStorage.getItem('giangVienList')) || [];
            const hocKyList = JSON.parse(localStorage.getItem('hocKyList')) || [];
            const maKhoa = khoaList.find(k => k.tenKhoa === tenKhoa)?.maKhoa || '';
            const maGV = giangVienList.find(gv => gv.tenGV === tenGV)?.maGV || '';

            const thuValue = {
                'Thứ 2': '2',
                'Thứ 3': '3',
                'Thứ 4': '4',
                'Thứ 5': '5',
                'Thứ 6': '6',
                'Thứ 7': '7',
                'Chủ nhật': '8'
            }[thuText];

            let khoaOptions = '<option value="" disabled>Chọn khoa</option>';
            khoaList.forEach(khoa => {
                const selected = khoa.maKhoa === maKhoa ? 'selected' : '';
                khoaOptions += `<option value="${khoa.maKhoa}" ${selected}>${khoa.tenKhoa}</option>`;
            });

            let hpOptions = '<option value="" disabled>Chọn học phần</option>';
            hocPhanList.filter(hp => hp.trangThai === 'Đã công bố' && (!maKhoa || hp.khoa === maKhoa)).forEach(hp => {
                const selected = hp.ma === maHPText ? 'selected' : '';
                hpOptions += `<option value="${hp.ma}" ${selected}>${hp.ma} - ${hp.ten}</option>`;
            });

            let gvOptions = '<option value="" disabled>Chọn giảng viên</option>';
            giangVienList.forEach(gv => {
                const selected = gv.maGV === maGV ? 'selected' : '';
                gvOptions += `<option value="${gv.maGV}" ${selected}>${gv.maGV} - ${gv.tenGV}</option>`;
            });

            let hocKyOptions = '<option value="" disabled>Chọn học kỳ</option>';
            hocKyList.forEach(hk => {
                const selected = hk === hocKy ? 'selected' : '';
                hocKyOptions += `<option value="${hk}" ${selected}>${hk}</option>`;
            });

            let thuOptions = '<option value="" disabled>Chọn thứ</option>';
            const thuList = [
                { value: '2', text: 'Thứ 2' },
                { value: '3', text: 'Thứ 3' },
                { value: '4', text: 'Thứ 4' },
                { value: '5', text: 'Thứ 5' },
                { value: '6', text: 'Thứ 6' },
                { value: '7', text: 'Thứ 7' },
                { value: '8', text: 'Chủ nhật' }
            ];
            thuList.forEach(thu => {
                const selected = thu.value === thuValue ? 'selected' : '';
                thuOptions += `<option value="${thu.value}" ${selected}>${thu.text}</option>`;
            });

            let tietBatDauOptions = '<option value="" disabled>Chọn tiết bắt đầu</option>';
            let tietKetThucOptions = '<option value="" disabled>Chọn tiết kết thúc</option>';
            const tietList = [
                { value: '1', text: 'Tiết 1 (6:30 - 7:20)' },
                { value: '2', text: 'Tiết 2 (7:20 - 8:10)' },
                { value: '3', text: 'Tiết 3 (8:10 - 9:00)' },
                { value: '4', text: 'Tiết 4 (9:00 - 9:50)' },
                { value: '5', text: 'Tiết 5 (9:50 - 10:40)' },
                { value: '6', text: 'Tiết 6 (10:40 - 11:30)' },
                { value: '7', text: 'Tiết 7 (12:30 - 13:20)' },
                { value: '8', text: 'Tiết 8 (13:20 - 14:10)' },
                { value: '9', text: 'Tiết 9 (14:10 - 15:00)' },
                { value: '10', text: 'Tiết 10 (15:00 - 15:50)' },
                { value: '11', text: 'Tiết 11 (15:50 - 16:40)' },
                { value: '12', text: 'Tiết 12 (16:40 - 17:30)' }
            ];
            tietList.forEach(tiet => {
                const selectedBatDau = tiet.value === tietBatDau ? 'selected' : '';
                const selectedKetThuc = tiet.value === tietKetThuc ? 'selected' : '';
                tietBatDauOptions += `<option value="${tiet.value}" ${selectedBatDau}>${tiet.text}</option>`;
                tietKetThucOptions += `<option value="${tiet.value}" ${selectedKetThuc}>${tiet.text}</option>`;
            });

            cells[0].innerHTML = `<select id="editKhoa">${khoaOptions}</select>`;
            cells[1].innerHTML = `<select id="editMaHP">${hpOptions}</select>`;
            cells[2].innerHTML = `<input id="editMaLop" value="${maLop}" placeholder="Mã lớp (VD: HP001_01)">`;
            cells[3].innerHTML = `<select id="editMaGV">${gvOptions}</select>`;
            cells[4].innerHTML = `<select id="editHocKy">${hocKyOptions}</select>`;
            cells[5].innerHTML = `
                <select id="editThu">${thuOptions}</select>
                <select id="editTietBatDau">${tietBatDauOptions}</select>
                <select id="editTietKetThuc">${tietKetThucOptions}</select>
            `;

            const updateHocPhan = () => {
                const selectedKhoa = document.getElementById('editKhoa').value;
                const selectedHocKy = document.getElementById('editHocKy').value;
                const currentMaHP = document.getElementById('editMaHP').value;
                const editMaHP = document.getElementById('editMaHP');
                editMaHP.innerHTML = '<option value="" disabled selected>Chọn học phần</option>';
                hocPhanList.filter(hp => 
                    hp.trangThai === 'Đã công bố' && 
                    (!selectedKhoa || hp.khoa === selectedKhoa) && 
                    (!selectedHocKy || hp.hocKy === selectedHocKy)
                ).forEach(hp => {
                    const option = document.createElement('option');
                    option.value = hp.ma;
                    option.text = `${hp.ma} - ${hp.ten}`;
                    if (hp.ma === currentMaHP && (!selectedHocKy || hp.hocKy === selectedHocKy)) {
                        option.selected = true;
                    }
                    editMaHP.appendChild(option);
                });
            };

            document.getElementById('editKhoa').addEventListener('change', updateHocPhan);
            document.getElementById('editHocKy').addEventListener('change', updateHocPhan);

            button.textContent = 'Lưu';
            button.onclick = function () {
                const newKhoa = document.getElementById('editKhoa').value;
                const newMaHP = document.getElementById('editMaHP').value;
                const newMaLop = document.getElementById('editMaLop').value;
                const newMaGV = document.getElementById('editMaGV').value;
                const newHocKy = document.getElementById('editHocKy').value;
                const newThu = document.getElementById('editThu').value;
                const newTietBatDau = document.getElementById('editTietBatDau').value;
                const newTietKetThuc = document.getElementById('editTietKetThuc').value;

                if (!newKhoa || !newMaHP || !newMaLop || !newMaGV || !newHocKy || !newThu || !newTietBatDau || !newTietKetThuc) {
                    showNotification("Vui lòng nhập đầy đủ thông tin.", true);
                    return;
                }

                if (!/^[A-Z0-9]+_\d{2}$/.test(newMaLop)) {
                    showNotification("Mã lớp phải có định dạng HPXXX_NN (VD: HP001_01).", true);
                    return;
                }

                if (parseInt(newTietKetThuc) < parseInt(newTietBatDau)) {
                    showNotification("Tiết kết thúc phải lớn hơn hoặc bằng tiết bắt đầu.", true);
                    return;
                }

                const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
                const hp = hocPhanList.find(item => item.ma === newMaHP && item.hocKy === newHocKy);
                if (!hp || hp.trangThai !== 'Đã công bố') {
                    showNotification("Học phần chưa được công bố hoặc không tồn tại.", true);
                    return;
                }

                let phanCongList = JSON.parse(localStorage.getItem('phanCongList')) || [];
                if (phanCongList.some(item => 
                    item.maLop === newMaLop && 
                    item.hocKy === newHocKy && 
                    (item.maLop !== maLop || item.hocKy !== hocKy)
                )) {
                    showNotification("Mã lớp này đã được phân công trong học kỳ này.", true);
                    return;
                }

                const conflict = phanCongList.some(item => 
                    item.maGV === newMaGV && 
                    item.thu === newThu && 
                    item.hocKy === newHocKy &&
                    (item.maLop !== maLop || item.hocKy !== hocKy) &&
                    (parseInt(item.tietBatDau) <= parseInt(newTietKetThuc) && parseInt(item.tietKetThuc) >= parseInt(newTietBatDau))
                );
                if (conflict) {
                    showNotification("Giảng viên đã được phân công trong khoảng thời gian này.", true);
                    return;
                }

                // Cập nhật phanCongList
                const index = phanCongList.findIndex(item => item.maLop === maLop && item.hocKy === hocKy);
                if (index !== -1) {
                    phanCongList[index] = { 
                        khoa: newKhoa, 
                        maHP: newMaHP, 
                        maLop: newMaLop, 
                        maGV: newMaGV, 
                        hocKy: newHocKy, 
                        thu: newThu, 
                        tietBatDau: newTietBatDau, 
                        tietKetThuc: newTietKetThuc 
                    };
                    localStorage.setItem('phanCongList', JSON.stringify(phanCongList));
                } else {
                    showNotification("Không tìm thấy phân công để cập nhật.", true);
                    return;
                }

                // Cập nhật dangKyHocPhanList
                let dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
                const dkIndex = dangKyHocPhanList.findIndex(dk => dk.maLop === maLop && dk.hocKy === hocKy);
                if (dkIndex !== -1) {
                    dangKyHocPhanList[dkIndex] = {
                        maHP: newMaHP,
                        maLop: newMaLop,
                        tenHP: hp.ten,
                        soTinChi: hp.soTinChi,
                        siSoToiDa: hp.siSoToiDa,
                        dieuKienTienQuyet: hp.dieuKienTienQuyet || null,
                        khoa: newKhoa,
                        hocKy: newHocKy,
                        maGV: newMaGV,
                        thu: newThu,
                        tietBatDau: newTietBatDau,
                        tietKetThuc: newTietKetThuc,
                        siSoHienTai: dangKyHocPhanList[dkIndex].siSoHienTai
                    };
                    localStorage.setItem('dangKyHocPhanList', JSON.stringify(dangKyHocPhanList));
                } else {
                    showNotification("Không tìm thấy đăng ký học phần để cập nhật.", true);
                    return;
                }

                // Cập nhật giao diện
                const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
                const giangVienList = JSON.parse(localStorage.getItem('giangVienList')) || [];
                const newTenKhoa = khoaList.find(k => k.maKhoa === newKhoa)?.tenKhoa || newKhoa;
                const newGV = giangVienList.find(gv => gv.maGV === newMaGV);
                const thuText = thuList.find(item => item.value === newThu).text;
                const tietTime = tietList.reduce((acc, tiet) => ({
                    ...acc,
                    [tiet.value]: tiet.text.split(' (')[1].slice(0, -1)
                }), {});
                const thoiGian = `${thuText}, Tiết ${newTietBatDau} - ${newTietKetThuc} (${tietTime[newTietBatDau].split(' - ')[0]} - ${tietTime[newTietKetThuc].split(' - ')[1]})`;

                cells[0].innerText = newTenKhoa;
                cells[1].innerText = `${newMaHP} - ${hp.ten}`;
                cells[2].innerText = newMaLop;
                cells[3].innerText = newGV ? `${newGV.tenGV}` : newMaGV;
                cells[4].innerText = newHocKy;
                cells[5].innerText = thoiGian;

                showNotification("Cập nhật phân công thành công!");
                button.textContent = 'Chỉnh sửa';
                button.onclick = () => chinhSuaDong(button);
            };
        }

        function xoaDong(button) {
            const row = button.parentElement.parentElement;
            const cells = row.querySelectorAll('td');
            const maLop = cells[2].innerText;
            const hocKy = cells[4].innerText;

            const sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];
            if (sinhVienDangKyList.some(sv => sv.maLop === maLop && sv.hocKy === hocKy)) {
                showNotification("Không thể xóa phân công vì đã có sinh viên đăng ký.", true);
                return;
            }

            // Xóa khỏi phanCongList
            let phanCongList = JSON.parse(localStorage.getItem('phanCongList')) || [];
            const phanCongIndex = phanCongList.findIndex(item => item.maLop === maLop && item.hocKy === hocKy);
            if (phanCongIndex !== -1) {
                phanCongList.splice(phanCongIndex, 1);
                localStorage.setItem('phanCongList', JSON.stringify(phanCongList));
            } else {
                showNotification("Không tìm thấy phân công để xóa.", true);
                return;
            }

            // Xóa khỏi dangKyHocPhanList
            let dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            const dkIndex = dangKyHocPhanList.findIndex(dk => dk.maLop === maLop && dk.hocKy === hocKy);
            if (dkIndex !== -1) {
                dangKyHocPhanList.splice(dkIndex, 1);
                localStorage.setItem('dangKyHocPhanList', JSON.stringify(dangKyHocPhanList));
            }

            // Xóa hàng khỏi bảng
            row.remove();
            showNotification("Xóa phân công thành công!");
        }

        function dangXuat() {
            window.location.href = 'Dang_Nhap.html';
        }
    </script>
</body>
</html>