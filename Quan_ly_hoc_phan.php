<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Quản trị viên') {
    header("Location: Dang_Nhap.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý học phần</title>
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
        .add-form {
            margin-bottom: 2rem;
            background-color: #fff;
            padding: 1rem;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .add-form input, .add-form select {
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
        .actions .publish-btn {
            padding: 5px 10px;
            border: none;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .actions .publish-btn:hover {
            background-color: #218838;
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
            .add-form input, .add-form select {
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
            .actions .edit-btn, .actions .delete-btn, .actions .publish-btn {
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
            .actions .edit-btn, .actions .delete-btn, .actions .publish-btn {
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
                <div class="role"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
                <div><?php echo htmlspecialchars($_SESSION['role']); ?></div>
            </div>
        </div>
        <ul>
            <li class="active"><i class="fas fa-book"></i><a href="Quan_ly_hoc_phan.php">Quản lý học phần</a></li>
            <li><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học phần</a></li>
            <li><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.php">Phân công giảng viên</a></li>
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li><i class="fas fa-users"></i><a href="Quan_ly_ND.php">Quản lý người dùng</a></li>
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-alt"></i><a href="#">Tra cứu lịch học</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem thời khóa biểu</a></li>
            <li><i class="fas fa-chart-bar"></i><a href="Thongke_Baocao.php">Thống kê báo cáo</a></li>
            <li><i class="fas fa-sign-out-alt"></i><a href="Controller/c_signout.php">Đăng xuất</a></li>
        </ul>
    </div>
    <div class="main">
        <header>
            <h1>QUẢN LÝ HỌC PHẦN</h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <div class="container">
            <div class="add-form">
                <h3>Thêm học phần</h3>
                <input type="text" id="maHP" placeholder="Mã học phần (VD: IT101)" pattern="[A-Z0-9]+" required>
                <input type="text" id="tenHP" placeholder="Tên học phần" required>
                <input type="number" id="soTinChi" placeholder="Số tín chỉ (VD: 3)" min="1" required>
                <input type="number" id="siSoToiDa" placeholder="Sĩ số tối đa (VD: 40)" min="1" required>
                <select id="dieuKienTienQuyet">
                    <option value="" selected>Không có điều kiện tiên quyết</option>
                </select>
                <select id="khoa" required>
                    <option value="" disabled selected>Chọn khoa</option>
                </select>
                <select id="nganh" required>
                    <option value="" disabled selected>Chọn ngành</option>
                </select>
                <select id="hocKy" required>
                    <option value="" disabled selected>Chọn học kỳ</option>
                </select>
                <button onclick="themHocPhan()">Thêm</button>
            </div>
            <table id="bangHocPhan">
                <thead>
                    <tr>
                        <th>Mã học phần</th>
                        <th>Tên học phần</th>
                        <th>Số tín chỉ</th>
                        <th>Sĩ số tối đa</th>
                        <th>Điều kiện tiên quyết</th>
                        <th>Khoa</th>
                        <th>Ngành</th>
                        <th>Học kỳ</th>
                        <th>Trạng thái</th>
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
            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [
                { maKhoa: 'CNTT', tenKhoa: 'Công Nghệ Thông Tin' }
            ];
            localStorage.setItem('khoaList', JSON.stringify(khoaList));

            const nganhList = JSON.parse(localStorage.getItem('nganhList')) || [
                { maNganh: 'CNTT', maKhoa: 'CNTT', tenNganh: 'Công Nghệ Thông Tin' },
                { maNganh: 'SPTH', maKhoa: 'CNTT', tenNganh: 'Sư Phạm Tin Học' }
            ];
            localStorage.setItem('nganhList', JSON.stringify(nganhList));

            const hocKyList = JSON.parse(localStorage.getItem('hocKyList')) || [
                '2024-1', '2024-2', '2025-1', '2025-2'
            ];
            localStorage.setItem('hocKyList', JSON.stringify(hocKyList));

            loadKhoa();
            loadNganh();
            loadHocKy();
            loadDieuKienTienQuyet();
            loadHocPhan();
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

        function loadNganh() {
            const nganhList = JSON.parse(localStorage.getItem('nganhList')) || [];
            const selectNganh = document.getElementById('nganh');
            selectNganh.innerHTML = '<option value="" disabled selected>Chọn ngành</option>';
            const selectedKhoa = document.getElementById('khoa').value;
            nganhList.filter(nganh => !selectedKhoa || nganh.maKhoa === selectedKhoa).forEach(nganh => {
                const option = document.createElement('option');
                option.value = nganh.maNganh;
                option.text = nganh.tenNganh;
                selectNganh.appendChild(option);
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

        function loadDieuKienTienQuyet() {
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const selectDieuKien = document.getElementById('dieuKienTienQuyet');
            selectDieuKien.innerHTML = '<option value="" selected>Không có điều kiện tiên quyết</option>';
            hocPhanList.forEach(hp => {
                const option = document.createElement('option');
                option.value = hp.ma;
                option.text = `${hp.ma} - ${hp.ten}`;
                selectDieuKien.appendChild(option);
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

        document.getElementById('khoa').addEventListener('change', loadNganh);
        document.getElementById('maHP').addEventListener('change', function () {
            const maHP = this.value.trim();
            const selectDieuKien = document.getElementById('dieuKienTienQuyet');
            const options = selectDieuKien.querySelectorAll('option');
            options.forEach(option => {
                option.disabled = option.value === maHP;
            });
        });

        function themHocPhan() {
            const maHP = document.getElementById('maHP').value.trim();
            const tenHP = document.getElementById('tenHP').value.trim();
            const soTinChi = document.getElementById('soTinChi').value;
            const siSoToiDa = document.getElementById('siSoToiDa').value;
            const dieuKienTienQuyet = document.getElementById('dieuKienTienQuyet').value;
            const khoa = document.getElementById('khoa').value;
            const nganh = document.getElementById('nganh').value;
            const hocKy = document.getElementById('hocKy').value;

            if (!maHP || !tenHP || !soTinChi || !siSoToiDa || !khoa || !nganh || !hocKy) {
                showNotification("Vui lòng nhập đầy đủ thông tin.", true);
                return;
            }

            if (!/^[A-Z0-9]+$/.test(maHP)) {
                showNotification("Mã học phần chỉ được chứa chữ cái in hoa và số.", true);
                return;
            }

            if (isNaN(soTinChi) || soTinChi <= 0) {
                showNotification("Số tín chỉ phải là số dương.", true);
                return;
            }

            if (isNaN(siSoToiDa) || siSoToiDa <= 0) {
                showNotification("Sĩ số tối đa phải là số dương.", true);
                return;
            }

            if (dieuKienTienQuyet === maHP) {
                showNotification("Học phần không thể là điều kiện tiên quyết của chính nó.", true);
                return;
            }

            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            if (hocPhanList.some(hp => hp.ma === maHP && hp.hocKy === hocKy)) {
                showNotification("Học phần này đã tồn tại trong học kỳ này.", true);
                return;
            }

            hocPhanList.push({
                ma: maHP,
                ten: tenHP,
                soTinChi: parseInt(soTinChi),
                siSoToiDa: parseInt(siSoToiDa),
                dieuKienTienQuyet: dieuKienTienQuyet || null,
                khoa,
                nganh,
                hocKy,
                trangThai: 'Chưa công bố'
            });
            localStorage.setItem('hocPhanList', JSON.stringify(hocPhanList));

            showNotification("Thêm học phần thành công!");
            loadHocPhan();
            loadDieuKienTienQuyet();

            document.getElementById('maHP').value = '';
            document.getElementById('tenHP').value = '';
            document.getElementById('soTinChi').value = '';
            document.getElementById('siSoToiDa').value = '';
            document.getElementById('dieuKienTienQuyet').value = '';
            document.getElementById('khoa').value = '';
            document.getElementById('nganh').value = '';
            document.getElementById('hocKy').value = '';
            loadNganh();
        }

        function loadHocPhan() {
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
            const nganhList = JSON.parse(localStorage.getItem('nganhList')) || [];

            const tbody = document.getElementById('bangHocPhan').querySelector('tbody');
            tbody.innerHTML = '';

            hocPhanList.forEach(hp => {
                const tenKhoa = khoaList.find(k => k.maKhoa === hp.khoa)?.tenKhoa || hp.khoa;
                const tenNganh = nganhList.find(n => n.maNganh === hp.nganh)?.tenNganh || hp.nganh;
                const dieuKienText = hp.dieuKienTienQuyet ? hocPhanList.find(h => h.ma === hp.dieuKienTienQuyet)?.ten || hp.dieuKienTienQuyet : 'Không có';

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${hp.ma}</td>
                    <td>${hp.ten}</td>
                    <td>${hp.soTinChi}</td>
                    <td>${hp.siSoToiDa}</td>
                    <td>${dieuKienText}</td>
                    <td>${tenKhoa}</td>
                    <td>${tenNganh}</td>
                    <td>${hp.hocKy}</td>
                    <td>${hp.trangThai}</td>
                    <td class="actions">
                        <button class="edit-btn" onclick="chinhSuaHocPhan(this)">Chỉnh sửa</button>
                        <button class="delete-btn" onclick="xoaHocPhan('${hp.ma}', '${hp.hocKy}')">Xóa</button>
                        ${hp.trangThai === 'Chưa công bố' ? 
                            `<button class="publish-btn" onclick="congBoHocPhan('${hp.ma}', '${hp.hocKy}')">Công bố</button>` : 
                            `<button class="publish-btn" disabled>Đã công bố</button>`}
                    </td>
                `;
                tbody.appendChild(newRow);
            });
        }

        function chinhSuaHocPhan(button) {
            const row = button.parentElement.parentElement;
            const cells = row.querySelectorAll('td');
            const maHP = cells[0].innerText;
            const tenHP = cells[1].innerText;
            const soTinChi = cells[2].innerText;
            const siSoToiDa = cells[3].innerText;
            const dieuKienTienQuyetText = cells[4].innerText;
            const khoaText = cells[5].innerText;
            const nganhText = cells[6].innerText;
            const hocKy = cells[7].innerText;

            const khoaList = JSON.parse(localStorage.getItem('khoaList')) || [];
            const nganhList = JSON.parse(localStorage.getItem('nganhList')) || [];
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];

            const hp = hocPhanList.find(h => h.ma === maHP && h.hocKy === hocKy);
            const maKhoa = khoaList.find(k => k.tenKhoa === khoaText)?.maKhoa || hp.khoa;
            const maNganh = nganhList.find(n => n.tenNganh === nganhText)?.maNganh || hp.nganh;

            let khoaOptions = '<option value="" disabled>Chọn khoa</option>';
            khoaList.forEach(khoa => {
                const selected = khoa.maKhoa === maKhoa ? 'selected' : '';
                khoaOptions += `<option value="${khoa.maKhoa}" ${selected}>${khoa.tenKhoa}</option>`;
            });

            let nganhOptions = '<option value="" disabled>Chọn ngành</option>';
            nganhList.filter(nganh => !maKhoa || nganh.maKhoa === maKhoa).forEach(nganh => {
                const selected = nganh.maNganh === maNganh ? 'selected' : '';
                nganhOptions += `<option value="${nganh.maNganh}" ${selected}>${nganh.tenNganh}</option>`;
            });

            let dieuKienOptions = '<option value="">Không có điều kiện tiên quyết</option>';
            hocPhanList.forEach(h => {
                const selected = h.ma === hp.dieuKienTienQuyet ? 'selected' : '';
                const disabled = h.ma === maHP ? 'disabled' : '';
                dieuKienOptions += `<option value="${h.ma}" ${selected} ${disabled}>${h.ma} - ${h.ten}</option>`;
            });

            let hocKyOptions = '<option value="" disabled>Chọn học kỳ</option>';
            const hocKyList = JSON.parse(localStorage.getItem('hocKyList')) || [];
            hocKyList.forEach(hk => {
                const selected = hk === hocKy ? 'selected' : '';
                hocKyOptions += `<option value="${hk}" ${selected}>${hk}</option>`;
            });

            cells[0].innerHTML = `<input type="text" value="${maHP}" pattern="[A-Z0-9]+" required>`;
            cells[1].innerHTML = `<input type="text" value="${tenHP}" required>`;
            cells[2].innerHTML = `<input type="number" value="${soTinChi}" min="1" required>`;
            cells[3].innerHTML = `<input type="number" value="${siSoToiDa}" min="1" required>`;
            cells[4].innerHTML = `<select id="editDieuKien">${dieuKienOptions}</select>`;
            cells[5].innerHTML = `<select id="editKhoa">${khoaOptions}</select>`;
            cells[6].innerHTML = `<select id="editNganh">${nganhOptions}</select>`;
            cells[7].innerHTML = `<select id="editHocKy">${hocKyOptions}</select>`;

            const updateNganh = () => {
                const selectedKhoa = document.getElementById('editKhoa').value;
                const editNganh = document.getElementById('editNganh');
                editNganh.innerHTML = '<option value="" disabled selected>Chọn ngành</option>';
                nganhList.filter(nganh => !selectedKhoa || nganh.maKhoa === selectedKhoa).forEach(nganh => {
                    const option = document.createElement('option');
                    option.value = nganh.maNganh;
                    option.text = nganh.tenNganh;
                    editNganh.appendChild(option);
                });
            };

            document.getElementById('editKhoa').addEventListener('change', updateNganh);

            button.textContent = 'Lưu';
            button.onclick = function () {
                const newMaHP = cells[0].querySelector('input').value.trim();
                const newTenHP = cells[1].querySelector('input').value.trim();
                const newSoTinChi = cells[2].querySelector('input').value;
                const newSiSoToiDa = cells[3].querySelector('input').value;
                const newDieuKien = cells[4].querySelector('select').value;
                const newKhoa = cells[5].querySelector('select').value;
                const newNganh = cells[6].querySelector('select').value;
                const newHocKy = cells[7].querySelector('select').value;

                if (!newMaHP || !newTenHP || !newSoTinChi || !newSiSoToiDa || !newKhoa || !newNganh || !newHocKy) {
                    showNotification("Vui lòng nhập đầy đủ thông tin.", true);
                    return;
                }

                if (!/^[A-Z0-9]+$/.test(newMaHP)) {
                    showNotification("Mã học phần chỉ được chứa chữ cái in hoa và số.", true);
                    return;
                }

                if (isNaN(newSoTinChi) || newSoTinChi <= 0) {
                    showNotification("Số tín chỉ phải là số dương.", true);
                    return;
                }

                if (isNaN(newSiSoToiDa) || newSiSoToiDa <= 0) {
                    showNotification("Sĩ số tối đa phải là số dương.", true);
                    return;
                }

                if (newDieuKien === newMaHP) {
                    showNotification("Học phần không thể là điều kiện tiên quyết của chính nó.", true);
                    return;
                }

                const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
                if (hocPhanList.some(hp => hp.ma === newMaHP && hp.hocKy === newHocKy && (hp.ma !== maHP || hp.hocKy !== hocKy))) {
                    showNotification("Học phần này đã tồn tại trong học kỳ này.", true);
                    return;
                }

                const index = hocPhanList.findIndex(h => h.ma === maHP && h.hocKy === hocKy);
                if (index !== -1) {
                    hocPhanList[index] = {
                        ma: newMaHP,
                        ten: newTenHP,
                        soTinChi: parseInt(newSoTinChi),
                        siSoToiDa: parseInt(newSiSoToiDa),
                        dieuKienTienQuyet: newDieuKien || null,
                        khoa: newKhoa,
                        nganh: newNganh,
                        hocKy: newHocKy,
                        trangThai: hocPhanList[index].trangThai
                    };
                    localStorage.setItem('hocPhanList', JSON.stringify(hocPhanList));
                }

                showNotification("Cập nhật học phần thành công!");
                loadHocPhan();
                loadDieuKienTienQuyet();
            };
        }

        function xoaHocPhan(maHP, hocKy) {
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const sinhVienDangKyList = JSON.parse(localStorage.getItem('sinhVienDangKyList')) || [];

            if (sinhVienDangKyList.some(sv => sv.maHP === maHP && sv.hocKy === hocKy)) {
                showNotification("Không thể xóa học phần vì đã có sinh viên đăng ký.", true);
                return;
            }

            if (hocPhanList.some(hp => hp.dieuKienTienQuyet === maHP)) {
                showNotification("Không thể xóa học phần vì nó là điều kiện tiên quyết của học phần khác.", true);
                return;
            }

            const newHocPhanList = hocPhanList.filter(hp => !(hp.ma === maHP && hp.hocKy === hocKy));
            localStorage.setItem('hocPhanList', JSON.stringify(newHocPhanList));

            showNotification("Xóa học phần thành công!");
            loadHocPhan();
            loadDieuKienTienQuyet();
        }

        function congBoHocPhan(maHP, hocKy) {
            const hocPhanList = JSON.parse(localStorage.getItem('hocPhanList')) || [];
            const index = hocPhanList.findIndex(hp => hp.ma === maHP && hp.hocKy === hocKy);
            if (index !== -1) {
                hocPhanList[index].trangThai = 'Đã công bố';
                localStorage.setItem('hocPhanList', JSON.stringify(hocPhanList));
                showNotification("Công bố học phần thành công!");
                loadHocPhan();
            }
        }

        function dangXuat() {
            window.location.href = 'Dang_Nhap.php';
        }
    </script>
</body>
</html>