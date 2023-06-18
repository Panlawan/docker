<?php
session_start();
require_once 'config/db_file.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fileToUpload = $_FILES["fileToUpload"];

    // Check if file field is empty
    if (empty($fileToUpload["tmp_name"]) || !is_uploaded_file($fileToUpload["tmp_name"])) {
        $_SESSION['error'] = "Please select a file to upload.";
        header("Location: admin.php");
        exit;
    }

    // Check for errors
    if ($fileToUpload["error"] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Error uploading file. Please try again.";
        header("Location: admin.php");
        exit;
    }

    // Validate file size
    $maxFileSize = 500000; // Maximum file size in bytes
    if ($fileToUpload["size"] > $maxFileSize) {
        $_SESSION['error'] = "File size exceeds the maximum limit (500 KB).";
        header("Location: admin.php");
        exit;
    }

    // Get file data
    $name = $_FILES["fileToUpload"]["name"];
    $type = $_FILES["fileToUpload"]["type"];
    $size = $_FILES["fileToUpload"]["size"];
    $data = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);

    // Prepare and execute the INSERT statement
    $stmt = $conn->prepare("INSERT INTO files (name, type, size, data) VALUES (:name, :type, :size, :data)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":size", $size);
    $stmt->bindParam(":data", $data, PDO::PARAM_LOB);

    if ($stmt->execute()) {
        $_SESSION['success'] = "File uploaded successfully.";
    } else {
        $_SESSION['error'] = "Error uploading file. Please try again.";
    }

    header("Location: admin.php");
    exit;
}
?>
