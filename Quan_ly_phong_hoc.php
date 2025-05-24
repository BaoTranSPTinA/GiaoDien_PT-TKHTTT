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
    <title>Quản lý phòng học</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table td input, table td select {
            width: 100%;
            padding: 0;
            border: none;
            background: transparent;
            font-size: 1rem;
            font-family: inherit;
        }
        table td input:focus, table td select:focus {
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
            background-color: #4CAF50;
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
            background-color: #f44336;
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
            <div class="avatar"></div>
            <div class="details">
                <div class="role"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
                <div><?php echo htmlspecialchars($_SESSION['role']); ?></div>
            </div>
        </div>
        <ul>
            <li><i class="fas fa-book"></i><a href="Quan_ly_hoc_phan.php">Quản lý học phần</a></li>
            <li><i class="fas fa-graduation-cap"></i><a href="Quan_ly_LHP.php">Quản lý lớp học phần</a></li>
            <li><i class="fas fa-chalkboard-teacher"></i><a href="Phan_cong_GV.php">Phân công giảng viên</a></li>
            <li class="active"><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li><i class="fas fa-users"></i><a href="Quan_ly_ND.php">Quản lý người dùng</a></li>
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem thời khóa biểu</a></li>
            <li><i class="fas fa-chart-bar"></i><a href="Thongke_Baocao.php">Thống kê báo cáo</a></li>
            <li><i class="fas fa-sign-out-alt"></i><a href="Controller/c_signout.php">Đăng xuất</a></li>
        </ul>
    </div>
    <div class="main">
        <header>
            <h1>QUẢN LÝ PHÒNG HỌC</h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <div class="container">
            <div class="add-form">
                <h3>Thêm phòng học mới</h3>
                <select id="toaNha">
                    <option value="" disabled selected>Chọn tòa nhà</option>
                </select>
                <input type="text" id="maPhong" placeholder="Mã phòng học (VD: P101)">
                <input type="text" id="tenPhong" placeholder="Tên phòng học (VD: Phòng học A1)">
                <input type="number" id="sucChua" placeholder="Sức chứa (VD: 50)" min="1">
                <button onclick="themPhongHoc()">Thêm</button>
            </div>
            <table id="bangPhongHoc">
                <thead>
                    <tr>
                        <th>Tòa nhà</th>
                        <th>Mã phòng học</th>
                        <th>Tên phòng học</th>
                        <th>Sức chứa</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tòa A</td>
                        <td>P101</td>
                        <td>Phòng học A1</td>
                        <td>50</td>
                        <td class="actions">
                            <button class="edit-btn" onclick="chinhSuaDong(this)"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" onclick="xoaDong(this)"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Dữ liệu mẫu cho tòa nhà
        const toaNhaList = [
            { maToa: 'T01', tenToa: 'Tòa A' },
            { maToa: 'T02', tenToa: 'Tòa B' },
            { maToa: 'T03', tenToa: 'Tòa C' }
        ];

        // Lấy dữ liệu từ localStorage khi tải trang
        document.addEventListener('DOMContentLoaded', function () {
            if (!localStorage.getItem('toaNhaList')) {
                localStorage.setItem('toaNhaList', JSON.stringify(toaNhaList));
            }
            loadToaNha();
            const data = JSON.parse(localStorage.getItem('phongHocList')) || [];
            data.forEach(ph => themDongVaoBang(ph.toaNha, ph.maPhong, ph.tenPhong, ph.sucChua));
        });

        function loadToaNha() {
            const toaNhaList = JSON.parse(localStorage.getItem('toaNhaList')) || [];
            const selectToaNha = document.getElementById('toaNha');
            toaNhaList.forEach(toa => {
                const option = document.createElement('option');
                option.value = toa.maToa;
                option.text = toa.tenToa;
                selectToaNha.appendChild(option);
            });
        }

        function dangXuat() {
            window.location.href = 'Dang_Nhap.php';
        }

        function themPhongHoc() {
            const toaNha = document.getElementById('toaNha').value;
            const maPhong = document.getElementById('maPhong').value.trim();
            const tenPhong = document.getElementById('tenPhong').value.trim();
            const sucChua = document.getElementById('sucChua').value.trim();

            if (!toaNha || !maPhong || !tenPhong || !sucChua) {
                alert("Vui lòng nhập đầy đủ thông tin.");
                return;
            }

            if (isNaN(sucChua) || sucChua <= 0) {
                alert("Sức chứa phải là số dương.");
                return;
            }

            // Kiểm tra mã phòng học trùng lặp trong cùng tòa nhà
            const phongHocList = JSON.parse(localStorage.getItem('phongHocList')) || [];
            if (phongHocList.some(ph => ph.toaNha === toaNha && ph.maPhong === maPhong)) {
                alert("Mã phòng học đã tồn tại trong tòa nhà này.");
                return;
            }

            // Lưu vào localStorage
            phongHocList.push({ toaNha, maPhong, tenPhong, sucChua: parseInt(sucChua) });
            localStorage.setItem('phongHocList', JSON.stringify(phongHocList));

            themDongVaoBang(toaNha, maPhong, tenPhong, sucChua);

            document.getElementById('toaNha').value = '';
            document.getElementById('maPhong').value = '';
            document.getElementById('tenPhong').value = '';
            document.getElementById('sucChua').value = '';
        }

        function themDongVaoBang(toaNha, maPhong, tenPhong, sucChua) {
            const toaNhaList = JSON.parse(localStorage.getItem('toaNhaList')) || [];
            const tenToa = toaNhaList.find(t => t.maToa === toaNha)?.tenToa || toaNha;

            const tbody = document.getElementById('bangPhongHoc').querySelector('tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${tenToa}</td>
                <td>${maPhong}</td>
                <td>${tenPhong}</td>
                <td>${sucChua}</td>
                <td>
                    <div class="action-buttons">
                        <button class="edit-btn" onclick="chinhSuaDong(this)"><i class="fas fa-edit"></i></button>
                        <button class="delete-btn" onclick="xoaDong(this)"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            `;
            tbody.appendChild(newRow);
        }

        function chinhSuaDong(button) {
            const row = button.parentElement.parentElement;
            const cells = row.querySelectorAll('td');

            const tenToa = cells[0].innerText;
            const maPhong = cells[1].innerText;
            const tenPhong = cells[2].innerText;
            const sucChua = cells[3].innerText;

            const toaNhaList = JSON.parse(localStorage.getItem('toaNhaList')) || [];
            const maToa = toaNhaList.find(t => t.tenToa === tenToa)?.maToa || '';

            let toaNhaOptions = '<option value="" disabled>Chọn tòa nhà</option>';
            toaNhaList.forEach(toa => {
                const selected = toa.maToa === maToa ? 'selected' : '';
                toaNhaOptions += `<option value="${toa.maToa}" ${selected}>${toa.tenToa}</option>`;
            });

            cells[0].innerHTML = `<select id="editToaNha">${toaNhaOptions}</select>`;
            cells[1].innerHTML = `<input type="text" value="${maPhong}" style="width: 100%;">`;
            cells[2].innerHTML = `<input type="text" value="${tenPhong}" style="width: 100%;">`;
            cells[3].innerHTML = `<input type="number" value="${sucChua}" min="1" style="width: 100%;">`;

            button.innerHTML = '<i class="fas fa-save"></i>';
            button.onclick = function () {
                const select = row.querySelector('select');
                const inputs = row.querySelectorAll('input');
                const newToaNha = select.value;
                const newMaPhong = inputs[0].value.trim();
                const newTenPhong = inputs[1].value.trim();
                const newSucChua = inputs[2].value.trim();

                if (!newToaNha || !newMaPhong || !newTenPhong || !newSucChua) {
                    alert("Vui lòng nhập đầy đủ thông tin.");
                    return;
                }

                if (isNaN(newSucChua) || newSucChua <= 0) {
                    alert("Sức chứa phải là số dương.");
                    return;
                }

                // Kiểm tra mã phòng học trùng lặp, ngoại trừ dòng hiện tại
                const phongHocList = JSON.parse(localStorage.getItem('phongHocList')) || [];
                if (phongHocList.some(ph => ph.toaNha === newToaNha && ph.maPhong === newMaPhong && (ph.toaNha !== maToa || ph.maPhong !== maPhong))) {
                    alert("Mã phòng học đã tồn tại trong tòa nhà này.");
                    return;
                }

                const newTenToa = toaNhaList.find(t => t.maToa === newToaNha)?.tenToa || newToaNha;

                cells[0].innerText = newTenToa;
                cells[1].innerText = newMaPhong;
                cells[2].innerText = newTenPhong;
                cells[3].innerText = newSucChua;

                // Cập nhật localStorage
                const index = phongHocList.findIndex(item => item.toaNha === maToa && item.maPhong === maPhong);
                if (index !== -1) {
                    phongHocList[index] = { toaNha: newToaNha, maPhong: newMaPhong, tenPhong: newTenPhong, sucChua: parseInt(newSucChua) };
                    localStorage.setItem('phongHocList', JSON.stringify(phongHocList));
                }

                this.innerHTML = '<i class="fas fa-edit"></i>';
                this.onclick = () => chinhSuaDong(this);
            };
        }

        function xoaDong(button) {
            const row = button.parentElement.parentElement;
            const cells = row.querySelectorAll('td');
            const maPhong = cells[1].innerText;

            // Kiểm tra phòng học có đang được sử dụng
            const dangKyHocPhanList = JSON.parse(localStorage.getItem('dangKyHocPhanList')) || [];
            if (dangKyHocPhanList.some(dk => dk.maPhong === maPhong)) {
                alert("Không thể xóa phòng học vì đang được sử dụng trong đăng ký học phần.");
                return;
            }

            // Xóa khỏi localStorage
            let phongHocList = JSON.parse(localStorage.getItem('phongHocList')) || [];
            phongHocList = phongHocList.filter(item => item.maPhong !== maPhong);
            localStorage.setItem('phongHocList', JSON.stringify(phongHocList));

            row.remove();
        }
    </script>
</body>
</html>