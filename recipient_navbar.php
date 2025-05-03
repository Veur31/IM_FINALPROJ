<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['username'])) {

    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipient</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/design1.css">

  <style>

  </style>
</head>
<body>

<div class="sidebar">
<img src="photo/logo3.png" alt="Hemo Vault Logo" style="width: 100px; margin-bottom: 15px;">
  <a class="navbar-brand" href="#" style="padding-left:45px;">Hemo Vault</a>
  <nav class="nav flex-column w-100" style="padding-left:30px; padding-top:80px;">
  <div class="d-flex align-items-center mb-2">
      <img src="photo/receiptient.png" alt="Summary Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">Request blood</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/dash.png" alt="User Management Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">User Management</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/log.png" alt="User Management Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="logout.php">Logout</a>
    </div>
  </nav>
</div>

<div class="content">
  <h1>Recipeint Dashboard</h1>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
