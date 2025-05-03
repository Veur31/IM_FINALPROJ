<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="design.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
include("connection.php"); 
include("navbar.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
    $role = $_POST['role'];

    // Insert query
    $sql = "INSERT INTO registration (full_name, email, username, password, user_type)
            VALUES ('$fullname', '$email', '$username', '$password', '$role')";

    // Execute the query
    if (mysqli_query($dbcon, $sql)) {
        echo "<script>alert('Registered successfully!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($dbcon);
    }
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Close connection
mysqli_close($dbcon);
?>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="container" style="max-width: 400px; padding-top:60px;">
    <div class="card shadow-lg rounded-4 mt-5">
      <div class="card-body p-4">
        <h2 class="card-title text-center mb-4">Register</h2>



        <form method="POST" action="register.php">
          <div class="mb-3">
            <label for="fullname" class="form-label">Fullname</label>
            <input type="text" class="form-control" id="fullname" name="fullname" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-4">
            <label for="role" class="form-label">Category</label>
            <select class="form-select" id="role" name="role" required>
              <option value="">Select Role</option>
              <option value="Admin">Admin</option>
              <option value="Staff">Staff</option>
              <option value="Recipient">Recipient</option>
              <option value="Donor">Donor</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

      </div>
    </div>
  </div>


</body>
</html>