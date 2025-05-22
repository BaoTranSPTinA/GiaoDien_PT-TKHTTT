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
    <title>Thời khóa biểu</title>
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
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            margin-left: 1px;
            background-color: #d1e5dd;
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
            <li><i class="fas fa-school"></i><a href="Quan_ly_phong_hoc.php">Quản lý phòng học</a></li>
            <li><i class="fas fa-users"></i><a href="Quan_ly_ND.php">Quản lý người dùng</a></li>
            <li><i class="fas fa-clipboard-list"></i><a href="Dang_ky_hoc_phan.php">Đăng ký học phần</a></li>
            <li><i class="fas fa-calendar-alt"></i><a href="#">Tra cứu lịch học</a></li>
            <li class="active"><i class="fas fa-calendar-check"></i><a href="TKB.php">Xem thời khóa biểu</a></li>
            <li><i class="fas fa-chart-bar"></i><a href="Thongke_Baocao.php">Thống kê báo cáo</a></li>
            <li><i class="fas fa-sign-out-alt"></i><a href="Controller/c_signout.php">Đăng xuất</a></li>
        </ul>
    </div>
    <div class="main">
        <header>
            <h1>THỜI KHÓA BIỂU</h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <div class="container">
            <div class="filter-form">
                <select id="hocKy" onchange="loadTKB()">
                    <option value="" selected>Chọn học kỳ</option>
                    <option value="HK1-2023-2024">Học kỳ 1 - Năm học 2023-2024</option>
                    <option value="HK2-2023-2024">Học kỳ 2 - Năm học 2023-2024</option>
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
        function loadTKB() {
            const hocKy = document.getElementById('hocKy').value;
            const tuan = document.getElementById('tuan').value;
            const userRole = '<?php echo $userRole; ?>';
            const userId = '<?php echo $userId; ?>';

            if (!hocKy || !tuan) {
                alert('Vui lòng chọn học kỳ và tuần');
                return;
            }

            // Giả lập dữ liệu (sau này sẽ lấy từ database)
            let scheduleData;
            if (userRole === 'Sinh viên') {
                scheduleData = {
                    'Thứ 2': [
                        {
                            subject: 'Lập trình Web',
                            room: 'A2.01',
                            time: '7:30-9:30',
                            teacher: 'Nguyễn Văn A'
                        }
                    ],
                    'Thứ 3': [
                        {
                            subject: 'Cơ sở dữ liệu',
                            room: 'A3.02',
                            time: '9:30-11:30',
                            teacher: 'Trần Thị B'
                        }
                    ]
                };
            } else if (userRole === 'Giảng viên') {
                scheduleData = {
                    'Thứ 2': [
                        {
                            subject: 'Lập trình Web',
                            room: 'A2.01',
                            time: '7:30-9:30',
                            class: 'CNTT1'
                        }
                    ],
                    'Thứ 4': [
                        {
                            subject: 'Cơ sở dữ liệu',
                            room: 'A3.02',
                            time: '13:30-15:30',
                            class: 'CNTT2'
                        }
                    ]
                };
            }

            // Xóa dữ liệu cũ
            const cells = document.querySelectorAll('.schedule-table td:not(:first-child)');
            cells.forEach(cell => cell.innerHTML = '');

            // Hiển thị thời khóa biểu
            for (const [day, classes] of Object.entries(scheduleData)) {
                classes.forEach(classInfo => {
                    const dayCol = document.querySelector(`th:contains('${day}')`);
                    if (dayCol) {
                        const colIndex = dayCol.cellIndex;
                        const [startHour] = classInfo.time.split('-')[0].split(':');
                        const rowIndex = Math.floor((parseInt(startHour) - 6) / 1) + 1;
                        
                        const cell = document.querySelector(`.schedule-table tr:nth-child(${rowIndex}) td:nth-child(${colIndex + 1})`);
                        if (cell) {
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
                            
                            cell.appendChild(classElement);
                        }
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Tạo danh sách tuần
            const tuanSelect = document.getElementById('tuan');
            for (let i = 1; i <= 15; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Tuần ${i}`;
                tuanSelect.appendChild(option);
            }
        });
    </script>
</body>
</html>