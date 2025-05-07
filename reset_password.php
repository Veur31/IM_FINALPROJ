<?php
session_start();
include("connection.php");

if (!isset($_SESSION['reset_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['reset_email'];
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] ==="POST") {
    $new_pass = mysqli_real_escape_string($dbcon, $_POST['new_password']);
    $confirm_pass = mysqli_real_escape_string($dbcon, $_POST['confirm_password']);

    if ($new_pass !== $confirm_pass) {
        $error = '<div class="alert alert-danger text-center">Passwords do not match</div>';
    } else {
        $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
        $update= "UPDATE registration SET password = '$hashed' WHERE email = '$email'";
        
        if (mysqli_query($dbcon, $update)) {
            $success = '<div class="alert alert-success text-center">Password has been updated. <a href="login.php">Login</a></div>';
            session_unset(); 
        } else {
            $error = '<div class="alert alert-danger text-center">Error updating password</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow rounded-4 mt-5">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-3">Reset Password</h4>
                        <?php echo $error; ?>
                        <?php echo $success; ?>
                        <?php if (!$success) { ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Reset Password</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
