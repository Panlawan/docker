<?php
session_start();
require_once 'config/db_file.php';

if (!isset($_SESSION['admin_login']) && !isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}

if (isset($_GET['file'])) {
    $file_name = $_GET['file'];

    $stmt = $conn->prepare("SELECT id FROM files WHERE name = ?");
    $stmt->execute([$file_name]);
    $id = $stmt->fetchColumn();

    if ($id) {
        // Send file to user for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($file['content']));
        echo $file['content'];

        // Now update downloads count
        $stmt = $conn->prepare("UPDATE files SET downloads=downloads+1 WHERE name=?");
        if($stmt->execute([$file_name])){
            $_SESSION['success'] = "The file has download on database.";
        } else {
            $_SESSION['error'] = "The file hasn't download on database.";
        }

        exit;
    }

}
?>
