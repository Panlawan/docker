<?php

session_start();
require_once '../db_config/db.php';
if (!isset($_SESSION['user_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
  header('location: signin.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <title>Bootstrap 5 Example</title> -->
  <title>Download</title>
  <link rel="icon" type="image/x-icon" href="http://localhost/php-downloads/icon/ces.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <?php

  if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  ?>
  
  <div class="container-fluid p-5 bg-primary text-white text-center">
    <h1>Welcome <?php echo $row['firstname'] . ' ' . $row['lastname'] ?> to CESru for download files</h1>
  </div>

  <div class="container mt-5">
    <div class="row d-flex justify-content-center">
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

</body>

<!-- <h3 class="mt-4">Welcome, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h3> -->



<a href="logout.php" class="btn btn-danger ">Logout</a>

</html>