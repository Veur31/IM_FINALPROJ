<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="design.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
session_start();
include('connection.php');
include('navbar.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($dbcon, $_POST['username']);
    $password = mysqli_real_escape_string($dbcon, $_POST['password']);

    // Query to get the user data from the database
    $q = "SELECT * FROM registration WHERE username = '$username'";
    $result = mysqli_query($dbcon, $q);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type']; 
            $_SESSION['donor_id'] = $user['donor_id'];
            $_SESSION['request_id'] = $user['request_id'];

            if ($user['user_type'] == 'Admin') {
                header("Location: admin_dashboard.php");
            }  else if ($user['user_type'] == 'Donor') {
                header('Location: donor.php');
            } else if ($user['user_type'] == 'Recipient') {
                header('Location: recipient.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        } else {
            $error_message = '<div class="alert alert-danger text-center" role="alert">Invalid username or password</div>';
        }
    } else {
        $error_message = '<div class="alert alert-danger text-center" role="alert">Invalid username or password</div>';
    }
}
?>

<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg rounded-4 mt-5">
          <div class="card-body p-4">
            <h2 class="card-title text-center mb-4">Login</h2>
            <?php
            if (isset($error_message)) {
                echo $error_message;
            }
            ?>
            <form method="POST" action="#">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <a href="forgot_password.php" class="small text-decoration-none" style ="color:red;">Forgot password?</a>
              </div>
              <button type="submit" class="btn btn-danger w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
