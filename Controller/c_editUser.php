<?php
session_start();
require_once '../Model/database.php';
require_once '../Model/m_User.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    try {
        $userModel = new User();
        $user = $userModel->get_user_by_id($_GET['user_id']);
        
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $role = $_POST['role'];

    try {
        $userModel = new User();
        $userModel->update_user_by_id($user_id, $full_name, $email, $phone_number, $role);
        header("Location: ../Quan_ly_ND.php?success=User updated successfully");
    } catch (Exception $e) {
        header("Location: ../Quan_ly_ND.php?error=" . urlencode($e->getMessage()));
    }
    exit();
}
?>