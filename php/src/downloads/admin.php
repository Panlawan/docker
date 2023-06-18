<?php
session_start();
require_once '../db_config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <title>Bootstrap 5 Example</title> -->
    <title>Admin</title>
    <link rel="icon" type="image/x-icon" href="http://localhost/php-downloads/icon/ces.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
    
        <?php
        if (isset($_SESSION['admin_login'])) {
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['warning'])) { ?>
            <div class="alert alert-warning" role="alert">
                <?php
                echo $_SESSION['warning'];
                unset($_SESSION['warning']);
                ?>
            </div>
        <?php } ?>

        <div class="container-fluid p-5 bg-primary text-white text-center">
            <h1>Welcome to admin page On download files</h1>
        </div>

        <div class="container mt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-4" style="width: 33%; height: 200px;">
                    <h3>Upload File</h3>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        Select file to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload file" name="submit">
                    </form>
                </div>

                <div class="col-sm-4" style="width: 33%; height: 200px;">
                    <style>
                        select {
                            width: 280px;
                            height: 35px;
                        }
                    </style>
                    <h3>Delete File</h3>
                    <form action="delete.php" method="post">
                        <select name="file">
                            <?php
                            require_once 'config/db_file.php';
                            $stmt = $conn->prepare("SELECT name FROM files");
                            $stmt->execute();
                            $files = $stmt->fetchAll();
                            foreach ($files as $file) {
                                echo '<option value="' . $file['name'] . '">' . $file['name'] . '</option>';
                            }
                            ?>
                        </select>
                        <br><br>
                        <button type="submit" class="btn btn-danger" value="Delete">Delete</button>
                    </form>
                </div>

                <div class="col-sm-4" style="width: 33%; height: 200px;">
                    <h3>Download Files</h3>
                    <?php
                    require_once 'config/db_file.php';
                    $stmt = $conn->query("SELECT name FROM files");
                    $stmt->execute();
                    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($files as $file) {
                        echo '<li><a href="download.php?file=' . $file['name'] . '">' . $file['name'] . '</a></li>';
                    }
                    ?>
                </div>
            </div>
        </div>
    
    <br><br>
    <h3 class="mt-4">Welcome Admin, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h3>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>
