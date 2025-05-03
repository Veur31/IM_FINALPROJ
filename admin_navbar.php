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
  <title>Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/design1.css">

  <style>

  </style>
</head>
<body>

<div class="sidebar">
<img src="photo/logo3.png" alt="Hemo Vault Logo" style="width: 100px; margin-bottom: 15px;">
  <a class="navbar-brand" href="#" style="padding-left:45px;">Hemo Vault</a>
  <nav class="nav flex-column w-100" style="padding-left:30px;">
  <div class="d-flex align-items-center mb-2">
      <img src="photo/book.png" alt="Summary Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">Summary</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/activity.png" alt="Activity Log Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">Activity log</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/invent.png" alt="Blood Inventory Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">Blood Inventory</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/donor.png" alt="Donors Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">Donors</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/receiptient.png" alt="Receipients Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">Recipients</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/dash.png" alt="User Management Icon" style="width: 30px; margin-right: 10px;">
      <a class="nav-link" href="#">User Management</a>
    </div>
    <div class="d-flex align-items-center mb-2">
      <img src="photo/log.png" alt="User Management Icon" style="width: 22px; margin-right: 10px;">
      <a class="nav-link" href="logout.php">Logout</a>
    </div>
  </nav>
</div>

<div class="content">
  <h1>Admin Dashboard</h1>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
