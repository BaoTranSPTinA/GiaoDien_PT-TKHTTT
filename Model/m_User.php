<?php
require_once 'database.php';

class User extends Database
{
    public function create_1_User($full_name, $username, $password, $email, $phone_number, $role)
    {
        // Kiểm tra vai trò hợp lệ
        if (!in_array($role, ['Quản trị viên', 'Giảng viên', 'Sinh viên'])) {
            throw new Exception("Vai trò không hợp lệ");
        }

        // Sử dụng mật khẩu plaintext thay vì mã hóa
        $sql = "INSERT INTO Users (full_name, username, password, email, phone_number, role) VALUES (?, ?, ?, ?, ?, ?)";
        $this->set_query($sql);
        $this->bind_params("ssssss", $full_name, $username, $password, $email, $phone_number, $role);
        $this->execute_query();
    }

    public function delete_1_User($full_name)
    {
        // Xóa dữ liệu liên quan từ bảng DangKyHocPhan (nếu là Sinh viên)
        $sql_dangky = "DELETE FROM DangKyHocPhan WHERE user_id IN (SELECT user_id FROM Users WHERE full_name = ?)";
        $this->set_query($sql_dangky);
        $this->bind_params("s", $full_name);
        $this->execute_query();

        // Xóa dữ liệu liên quan từ bảng GiangVien (nếu là Giảng viên)
        $sql_giangvien = "DELETE FROM GiangVien WHERE user_id IN (SELECT user_id FROM Users WHERE full_name = ?)";
        $this->set_query($sql_giangvien);
        $this->bind_params("s", $full_name);
        $this->execute_query();

        // Xóa từ bảng Users
        $sql_user = "DELETE FROM Users WHERE full_name = ?";
        $this->set_query($sql_user);
        $this->bind_params("s", $full_name);
        $this->execute_query();
    }

    public function update_1_user($id, $full_name, $username, $password, $email, $phone_number, $role)
    {
        // Kiểm tra vai trò hợp lệ
        if (!in_array($role, ['Quản trị viên', 'Giảng viên', 'Sinh viên'])) {
            throw new Exception("Vai trò không hợp lệ");
        }

        // Sử dụng mật khẩu plaintext thay vì mã hóa
        $sql = "UPDATE Users SET full_name = ?, username = ?, password = ?, email = ?, phone_number = ?, role = ? WHERE user_id = ?";
        $this->set_query($sql);
        $this->bind_params("ssssssi", $full_name, $username, $password, $email, $phone_number, $role, $id);
        $this->execute_query();
    }

    public function list_all_user($role = null)
    {
        if ($role && !in_array($role, ['Quản trị viên', 'Giảng viên', 'Sinh viên'])) {
            throw new Exception("Vai trò không hợp lệ");
        }

        $sql = $role ? "SELECT * FROM Users WHERE role = ?" : "SELECT * FROM Users";
        $this->set_query($sql);
        if ($role) {
            $this->bind_params("s", $role);
        }
        if ($this->execute_query()) {
            return $this->fetch_all_rows();
        }
        return [];
    }

    public function get_user_by_id($id)
    {
        $sql = "SELECT user_id, full_name, username, email, phone_number, role FROM Users WHERE user_id = ?";
        $this->set_query($sql);
        $this->bind_params("i", $id);
        if ($this->execute_query()) {
            return $this->fetch_row();
        }
        return null;
    }

    public function update_user_by_id($id, $full_name, $email, $phone_number, $role)
    {
        // Kiểm tra vai trò hợp lệ
        if (!in_array($role, ['Quản trị viên', 'Giảng viên', 'Sinh viên'])) {
            throw new Exception("Vai trò không hợp lệ");
        }

        $sql = "UPDATE Users SET full_name = ?, email = ?, phone_number = ?, role = ? WHERE user_id = ?";
        $this->set_query($sql);
        $this->bind_params("ssssi", $full_name, $email, $phone_number, $role, $id);
        return $this->execute_query();
    }
}
?>