<?php
session_start();
require_once '../Model/database.php';
require_once '../Model/m_User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; // Only user_id is needed for deletion

    try {
        $userModel = new User();
        $userModel->delete_user($user_id); // Correct method call
        header("Location: ../Quan_ly_ND.php?success=User deleted successfully");
    } catch (Exception $e) {
        header("Location: ../Quan_ly_ND.php?error=" . urlencode($e->getMessage()));
    }
    exit();
}