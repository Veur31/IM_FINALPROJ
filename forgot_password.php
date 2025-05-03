<?php
session_start();
include("connection.php");

$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);

    $q = "SELECT * FROM registration WHERE email = '$email'";
    $result = mysqli_query($dbcon, $q);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['reset_email'] = $email;
        header("Location: reset_password.php");
        exit();
    } else {
        $error = '<div class="alert alert-danger text-center">Email not found</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow rounded-4 mt-5">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-3">Forgot Password</h4>
                    <?php echo $error; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Enter your email address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
