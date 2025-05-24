<?php
require_once 'database.php';

class User extends Database
{
    public function create_1_User($full_name, $username, $password, $email, $phone_number, $role)
    {
        if (!in_array($role, ['Quản trị viên', 'Giảng viên', 'Sinh viên'])) {
            throw new Exception("Vai trò không hợp lệ");
        }

        $sql = "INSERT INTO Users (full_name, username, password, email, phone_number, role) 
                VALUES ('$full_name', '$username', '$password', '$email', '$phone_number', '$role')";
        $this->set_query($sql);
        $this->execute_query();
    }

    public function delete_user($user_id)
    {
        $sql = "DELETE FROM Users WHERE user_id=$user_id";
        $this->set_query($sql);
        $this->execute_query();

        $sql_dangky = "DELETE FROM DangKyHocPhan WHERE user_id=$user_id";
        $this->set_query($sql_dangky);
        $this->execute_query();

        $sql_giangvien = "DELETE FROM GiangVien WHERE user_id=$user_id";
        $this->set_query($sql_giangvien);
        $this->execute_query();
    }

    public function update_1_user($id, $full_name, $username, $password, $email, $phone_number, $role)
    {
        if (!in_array($role, ['Quản trị viên', 'Giảng viên', 'Sinh viên'])) {
            throw new Exception("Vai trò không hợp lệ");
        }

        $sql = "UPDATE Users SET full_name='$full_name', username='$username', password='$password', 
                email='$email', phone_number='$phone_number', role='$role' WHERE user_id=$id";
        $this->set_query($sql);
        $this->execute_query();
    }

    public function list_all_user($role = null)
    {
        $sql = "SELECT user_id, full_name, username, email, role FROM Users";
        if ($role) {
            $sql .= " WHERE role='$role'";
        }
        $this->set_query($sql);
        if ($this->execute_query()) {
            return $this->fetch_all_rows();
        }
        return [];
    }

    public function get_user_by_id($id)
    {
        $sql = "SELECT user_id, full_name, username, email, phone_number, role FROM Users WHERE user_id=$id";
        $this->set_query($sql);
        if ($this->execute_query()) {
            return $this->fetch_row();
        }
        return null;
    }

    public function update_user_by_id($id, $full_name, $email, $phone_number, $role)
    {
        if (!in_array($role, ['Quản trị viên', 'Giảng viên', 'Sinh viên'])) {
            throw new Exception("Vai trò không hợp lệ");
        }

        $sql = "UPDATE Users SET full_name='$full_name', email='$email', phone_number='$phone_number', 
                role='$role' WHERE user_id=$id";
        $this->set_query($sql);
        return $this->execute_query();
    }
}
?>