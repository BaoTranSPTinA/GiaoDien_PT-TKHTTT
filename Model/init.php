<?php
require_once("database.php");

/*----------Tạo bảng Users------------*/
class initDatabaseUsers extends Database {
    public function create_structure() {
        $sql = "CREATE TABLE IF NOT EXISTS Users (
            user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            phone_number VARCHAR(20) NOT NULL UNIQUE,
            role ENUM('Quản trị viên', 'Giảng viên', 'Sinh viên') NOT NULL,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->set_query($sql);
        $this->execute_query();

        echo "INIT Users COMPLETE\n";
    }
}

$myinit = new initDatabaseUsers();
$myinit->create_structure();

/*----------Tạo bảng Khoa------------*/
class initDatabaseKhoa extends Database {
    public function create_structure() {
        $sql = "CREATE TABLE IF NOT EXISTS Khoa (
            ma_khoa VARCHAR(10) PRIMARY KEY,
            ten_khoa VARCHAR(100) NOT NULL,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->set_query($sql);
        $this->execute_query();

        echo "INIT Khoa COMPLETE\n";
    }
}

$myinit = new initDatabaseKhoa();
$myinit->create_structure();

/*----------Tạo bảng HocKy------------*/
class initDatabaseHocKy extends Database {
    public function create_structure() {
        $sql = "CREATE TABLE IF NOT EXISTS HocKy (
            hoc_ky VARCHAR(10) PRIMARY KEY,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->set_query($sql);
        $this->execute_query();

        echo "INIT HocKy COMPLETE\n";
    }
}

$myinit = new initDatabaseHocKy();
$myinit->create_structure();

/*----------Tạo bảng HocPhan------------*/
class initDatabaseHocPhan extends Database {
    public function create_structure() {
        $sql = "CREATE TABLE IF NOT EXISTS HocPhan (
            ma_hp VARCHAR(10) PRIMARY KEY,
            ten_hp VARCHAR(100) NOT NULL,
            so_tin_chi INT NOT NULL,
            si_so_toi_da INT NOT NULL,
            dieu_kien_tien_quyet VARCHAR(50),
            ma_khoa VARCHAR(10) NOT NULL,
            hoc_ky VARCHAR(10) NOT NULL,
            trang_thai ENUM('Chưa công bố', 'Đã công bố') NOT NULL DEFAULT 'Chưa công bố',
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (ma_khoa) REFERENCES Khoa(ma_khoa),
            FOREIGN KEY (hoc_ky) REFERENCES HocKy(hoc_ky)
        )";

        $this->set_query($sql);
        $this->execute_query();

        echo "INIT HocPhan COMPLETE\n";
    }
}

$myinit = new initDatabaseHocPhan();
$myinit->create_structure();

/*----------Tạo bảng GiangVien------------*/
class initDatabaseGiangVien extends Database {
    public function create_structure() {
        $sql = "CREATE TABLE IF NOT EXISTS GiangVien (
            ma_gv VARCHAR(10) PRIMARY KEY,
            ten_gv VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            phone_number VARCHAR(20) NOT NULL UNIQUE,
            ma_khoa VARCHAR(10) NOT NULL,
            user_id INT(6) UNSIGNED NOT NULL,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (ma_khoa) REFERENCES Khoa(ma_khoa),
            FOREIGN KEY (user_id) REFERENCES Users(user_id)
        )";

        $this->set_query($sql);
        $this->execute_query();

        echo "INIT GiangVien COMPLETE\n";
    }
}

$myinit = new initDatabaseGiangVien();
$myinit->create_structure();

/*----------Tạo bảng PhanCong------------*/
class initDatabasePhanCong extends Database {
    public function create_structure() {
        $sql = "CREATE TABLE IF NOT EXISTS PhanCong (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            ma_khoa VARCHAR(10) NOT NULL,
            ma_hp VARCHAR(10) NOT NULL,
            ma_lop VARCHAR(20) NOT NULL UNIQUE,
            ma_gv VARCHAR(10) NOT NULL,
            hoc_ky VARCHAR(10) NOT NULL,
            thu INT NOT NULL,
            tiet_bat_dau INT NOT NULL,
            tiet_ket_thuc INT NOT NULL,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (ma_khoa) REFERENCES Khoa(ma_khoa),
            FOREIGN KEY (ma_hp) REFERENCES HocPhan(ma_hp),
            FOREIGN KEY (ma_gv) REFERENCES GiangVien(ma_gv),
            FOREIGN KEY (hoc_ky) REFERENCES HocKy(hoc_ky)
        )";

        $this->set_query($sql);
        $this->execute_query();

        echo "INIT PhanCong COMPLETE\n";
    }
}

$myinit = new initDatabasePhanCong();
$myinit->create_structure();

/*----------Tạo bảng DangKyHocPhan------------*/
class initDatabaseDangKyHocPhan extends Database {
    public function create_structure() {
        $sql = "CREATE TABLE IF NOT EXISTS DangKyHocPhan (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) UNSIGNED NOT NULL,
            ma_hp VARCHAR(10) NOT NULL,
            ma_lop VARCHAR(20) NOT NULL,
            hoc_ky VARCHAR(10) NOT NULL,
            create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            FOREIGN KEY (ma_hp) REFERENCES HocPhan(ma_hp),
            FOREIGN KEY (ma_lop) REFERENCES PhanCong(ma_lop),
            FOREIGN KEY (hoc_ky) REFERENCES HocKy(hoc_ky)
        )";

        $this->set_query($sql);
        $this->execute_query();

        echo "INIT DangKyHocPhan COMPLETE\n";
    }
}

$myinit = new initDatabaseDangKyHocPhan();
$myinit->create_structure();
?>