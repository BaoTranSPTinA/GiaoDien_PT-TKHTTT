<?php
session_start();
require_once '../Model/database.php';
require_once '../Model/m_User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Consider hashing the password
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $role = $_POST['role'];

    try {
        $user = new User();
        $user->create_1_User($full_name, $username, $password, $email, $phone_number, $role);
        header("Location: ../Quan_ly_ND.php?success=User added successfully");
    } catch (Exception $e) {
        header("Location: ../Quan_ly_ND.php?error=" . urlencode($e->getMessage()));
    }
    exit();
}
?>