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
  <title>Navbar - Hemo Vault</title>
  <link rel="stylesheet" href="css/design1.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/design.css">

  
</head>
<body>

<div class="container4">
  <nav class="navbar navbar-expand-lg" style="background-color:rgb(248, 37, 58);">
    <a class="navbar-brand text-white" style="font-family: Didot, Bodoni MT, serif; font-size: 50px;" href="#">Hemo Vault</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto" style="font-size: 15px; font-family: 'Open Sans', sans-serif;">
      <li class="nav-item mx-2">
          <a class="nav-link text-white" href="recipient.php">
            <div class="d-flex align-items-center mb-2">
              <img class="nav-icon" src="photo/receiptient.png" alt="Summary Icon" style="width: 30px; margin-right: 10px;">
              <span class="nav-text">Home</span>
            </div>
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="recipient_blood.php">
            <div class="d-flex align-items-center mb-2">
              <img class="nav-icon" src="photo/receiptient.png" alt="Summary Icon" style="width: 30px; margin-right: 10px;">
              <span class="nav-text">Request blood</span>
            </div>
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="donate.php">
            <div class="d-flex align-items-center mb-2">
              <img class="nav-icon" src="photo/dash.png" alt="User Management Icon" style="width: 30px; margin-right: 10px;">
              <span class="nav-text">User Management</span>
            </div>
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="services.php">
            <div class="d-flex align-items-center mb-2">
              <img class="nav-icon" src="photo/log.png" alt="User Management Icon" style="width: 30px; margin-right: 10px;">
              <span class="nav-text">Logout</span>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
