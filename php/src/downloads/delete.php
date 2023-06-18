<?php
session_start();
require_once 'config/db_file.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}
    if (empty($_POST['file'])) {
        $_SESSION['error'] = "Please select a file to delete.";
        header("Location: admin.php");
        exit;
    }
    if (isset($_POST['file'])) {
        $file_name = $_POST['file'];
        
        // Get the ID of the file from the database
        $stmt = $conn->prepare("SELECT id FROM files WHERE name = ?");
        $stmt->execute([$file_name]);
        $id = $stmt->fetchColumn();

        // Delete the file from the database
        $stmt = $conn->prepare("DELETE FROM files WHERE id = ?");
        if ($stmt->execute([$id])) {
            $_SESSION['success'] = "The file information has been deleted to the database.";
        } else {
            $_SESSION['error'] = "The file information hasn't been deleted to the database.";
        }
        // Redirect to admin page
        // header('Location: admin.php');
        echo "<script>window.location.href = 'admin.php';</script>";
        exit();
    }
?>