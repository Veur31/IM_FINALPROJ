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

$email_error = '';
$password_error = '';

//getting the information input by the user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password_raw = $_POST['password'];
  $role = $_POST['role'];

  // password validation
  $uppercase = preg_match('@[A-Z]@', $password_raw);
  $number    = preg_match('@[0-9]@', $password_raw);
  $special= preg_match('@[^\w]@', $password_raw);

  if(!$uppercase || !$number || !$special || strlen($password_raw) < 8) {
    $password_error = "It must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
  } else {
    // Check if the email already exists
    $checkEmail = "SELECT * FROM registration WHERE email = '$email'";
    $result = mysqli_query($dbcon, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
      $email_error = "This email already exists.";
    } else {
      $password = password_hash($password_raw, PASSWORD_DEFAULT);
      $sql = "INSERT INTO registration (full_name, email, username, password, user_type)
              VALUES ('$fullname', '$email', '$username', '$password', '$role')";
      if (mysqli_query($dbcon, $sql)) {
        echo "<script>window.location.href='login.php';</script>";
      } else {
        echo "Error: " . mysqli_error($dbcon);
      }
    }
  }
}
mysqli_close($dbcon);
?>

<div style="background-color: #f8f9fa; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
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
            <input type="email" 
                   class="form-control <?php echo !empty($email_error) ? 'is-invalid' : ''; ?>" 
                   id="email" 
                   name="email" 
                   required 
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <?php if (!empty($email_error)): ?>
              <div class="invalid-feedback">
                <?php echo $email_error; ?>
              </div>
            <?php endif; ?> 
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" 
                   class="form-control <?php echo !empty($password_error) ? 'is-invalid' : ''; ?>" 
                   id="password" 
                   name="password" 
                   required
                   pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).{8,}$"
                   title="It must be at least 8 characters long, include an uppercase letter, a number, and a special character.">
            <?php if (!empty($password_error)): ?>
              <div class="invalid-feedback">
                <?php echo $password_error; ?>
              </div>
            <?php endif; ?>
          </div>

          <div class="mb-4">
            <label for="role" class="form-label">Category</label>
            <select class="form-select" id="role" name="role" required>
              <option value="">Select Role</option>
              <option value="Admin">Admin</option>
              <option value="Recipient">Recipient</option>
              <option value="Donor">Donor</option>
            </select>
          </div>

          <button type="submit" class="btn btn-danger w-100">Register</button>
        </form>

      </div>
    </div>
  </div>
</div>

</body>
</html>
