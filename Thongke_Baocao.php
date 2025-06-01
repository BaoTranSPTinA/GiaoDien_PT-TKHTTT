<?php
    session_start();
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Quản trị viên' && $_SESSION['role'] !== 'Giảng viên')) {
        header("Location: Dang_Nhap.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê báo cáo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="CSS/style_TrangChuAdmin.css"/>
    <style>
        /* CSS cho layout chính */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card i {
            font-size: 2.5em;
            color: #245139;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #245139;
            margin: 10px 0;
        }

        .stat-label {
            color: #666;
            font-size: 1.1em;
        }

        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .filter-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-section select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 200px;
        }

        .filter-section button {
            padding: 8px 16px;
            background-color: #245139;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-section button:hover {
            background-color: #1a3c2a;
        }

        .export-buttons {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .export-buttons button {
            padding: 8px 16px;
            background-color: #245139;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .export-buttons button:hover {
            background-color: #1a3c2a;
        }

        /* CSS cho bảng chi tiết */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .detail-table th,
        .detail-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .detail-table th {
            background-color: #245139;
            color: white;
        }

        .detail-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .detail-table tr:hover {
            background-color: #f5f5f5;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }

            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-section select {
                width: 100%;
            }

            .export-buttons {
                flex-direction: column;
                align-items: stretch;
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
            <li class="active"><i class="fas fa-chart-bar"></i><a href="Thongke_Baocao.php">Thống kê báo cáo</a></li>
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
            <h1>THỐNG KÊ BÁO CÁO</h1>
            <div class="login">
                Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?> |
                <a href="Controller/c_signout.php" style="color: white;"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </header>
        <div class="filter-section">
            <select id="hocKy">
                <option value="" disabled selected>Chọn học kỳ</option>
                <option value="1">Học kỳ 1</option>
                <option value="2">Học kỳ 2</option>
                <option value="3">Học kỳ hè</option>
            </select>
            <select id="namHoc">
                <option value="" disabled selected>Chọn năm học</option>
                <option value="2023">2023-2024</option>
                <option value="2022">2022-2023</option>
                <option value="2021">2021-2022</option>
            </select>
            <button onclick="capNhatThongKe()">Xem thống kê</button>
        </div>
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-user-graduate"></i>
                <div class="stat-number" id="soLuongSV">0</div>
                <div class="stat-label">Tổng số sinh viên</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-user-check"></i>
                <div class="stat-number" id="soLuongDK">0</div>
                <div class="stat-label">Số lượng đã đăng ký</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-user-times"></i>
                <div class="stat-number" id="soLuongChuaDK">0</div>
                <div class="stat-label">Số lượng chưa đăng ký</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-percentage"></i>
                <div class="stat-number" id="tyLeLapDay">0%</div>
                <div class="stat-label">Tỷ lệ lớp học phần được lấp đầy</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-book-dead"></i>
                <div class="stat-number" id="hocPhanRong">0</div>
                <div class="stat-label">Học phần không có đăng ký</div>
            </div>
        </div>
        <div class="chart-container">
            <h3>Thống kê đăng ký theo học phần</h3>
            <canvas id="thongKeChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Chi tiết tình hình đăng ký</h3>
            <table id="bangChiTiet" class="detail-table">
                <thead>
                    <tr>
                        <th>Mã học phần</th>
                        <th>Tên học phần</th>
                        <th>Sĩ số tối đa</th>
                        <th>Số lượng đăng ký</th>
                        <th>Tỷ lệ lấp đầy</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <!-- Thêm phần nút xuất báo cáo -->
            <div class="export-buttons">
                <button onclick="exportToExcel()">Xuất Excel</button>
                <button onclick="exportToPDF()">Xuất PDF</button>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Thêm thư viện SheetJS và jsPDF -->
        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
        <script>
            let thongKeChart;

            function capNhatThongKe() {
                const hocKy = document.getElementById('hocKy').value;
                const namHoc = document.getElementById('namHoc').value;

                if (!hocKy || !namHoc) {
                    alert('Vui lòng chọn đầy đủ học kỳ và năm học');
                    return;
                }

                // Giả lập dữ liệu thống kê
                const data = {
                    tongSV: Math.floor(Math.random() * 1000) + 500,
                    daDK: Math.floor(Math.random() * 800) + 200,
                    tyLeLapDay: Math.floor(Math.random() * 100),
                    hocPhanRong: Math.floor(Math.random() * 10),
                    chiTietHP: [
                        {
                            maHP: 'HP001',
                            tenHP: 'Lập trình web',
                            siSoToiDa: 50,
                            soLuongDK: 45
                        },
                        {
                            maHP: 'HP002',
                            tenHP: 'Cơ sở dữ liệu',
                            siSoToiDa: 40,
                            soLuongDK: 38
                        },
                        {
                            maHP: 'HP003',
                            tenHP: 'Cấu trúc dữ liệu',
                            siSoToiDa: 60,
                            soLuongDK: 52
                        }
                    ]
                };

                // Cập nhật số liệu
                document.getElementById('soLuongSV').textContent = data.tongSV;
                document.getElementById('soLuongDK').textContent = data.daDK;
                document.getElementById('soLuongChuaDK').textContent = data.tongSV - data.daDK;
                document.getElementById('tyLeLapDay').textContent = data.tyLeLapDay + '%';
                document.getElementById('hocPhanRong').textContent = data.hocPhanRong;

                // Cập nhật bảng chi tiết
                const tbody = document.querySelector('#bangChiTiet tbody');
                tbody.innerHTML = '';
                data.chiTietHP.forEach(hp => {
                    const tyLe = Math.round((hp.soLuongDK / hp.siSoToiDa) * 100);
                    tbody.innerHTML += `
                        <tr>
                            <td>${hp.maHP}</td>
                            <td>${hp.tenHP}</td>
                            <td>${hp.siSoToiDa}</td>
                            <td>${hp.soLuongDK}</td>
                            <td>${tyLe}%</td>
                        </tr>
                    `;
                });

                // Cập nhật biểu đồ
                const labels = data.chiTietHP.map(hp => hp.tenHP);
                const values = data.chiTietHP.map(hp => hp.soLuongDK);

                if (thongKeChart) {
                    thongKeChart.destroy();
                }

                const ctx = document.getElementById('thongKeChart').getContext('2d');
                thongKeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số lượng đăng ký',
                            data: values,
                            backgroundColor: '#245139'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 5
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Hàm xuất file Excel
            function exportToExcel() {
                const tbody = document.querySelector('#bangChiTiet tbody');
                const rows = [];
                const headers = ['Mã học phần', 'Tên học phần', 'Sĩ số tối đa', 'Số lượng đăng ký', 'Tỷ lệ lấp đầy'];

                // Lấy dữ liệu từ bảng
                tbody.querySelectorAll('tr').forEach(row => {
                    const cells = row.querySelectorAll('td');
                    rows.push({
                        'Mã học phần': cells[0].textContent,
                        'Tên học phần': cells[1].textContent,
                        'Sĩ số tối đa': cells[2].textContent,
                        'Số lượng đăng ký': cells[3].textContent,
                        'Tỷ lệ lấp đầy': cells[4].textContent
                    });
                });

                const ws = XLSX.utils.json_to_sheet(rows);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'ThongKeDangKy');
                XLSX.writeFile(wb, 'ThongKeDangKy.xlsx');
            }

            // Hàm xuất file PDF
            function exportToPDF() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                const tbody = document.querySelector('#bangChiTiet tbody');
                const rows = [];
                const headers = [['Mã học phần', 'Tên học phần', 'Sĩ số tối đa', 'Số lượng đăng ký', 'Tỷ lệ lấp đầy']];

                // Lấy dữ liệu từ bảng
                tbody.querySelectorAll('tr').forEach(row => {
                    const cells = row.querySelectorAll('td');
                    rows.push([
                        cells[0].textContent,
                        cells[1].textContent,
                        cells[2].textContent,
                        cells[3].textContent,
                        cells[4].textContent
                    ]);
                });

                doc.autoTable({
                    head: headers,
                    body: rows,
                    startY: 20,
                    theme: 'grid',
                    styles: { halign: 'center' },
                    headStyles: { fillColor: [36, 81, 57] }
                });

                doc.save('ThongKeDangKy.pdf');
            }
        </script>
    </div>
</body>
</html>