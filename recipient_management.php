<?php
session_start();
include("connection.php");
include("recipient_navbar.php");

$message = "";

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'Recipient') {
    // Redirect to the login page if the user is not logged in or is not a donor
    header("Location: login.php");
    exit();
}


$username = $_SESSION['username'];

// Fetch recipient email
$stmt = $dbcon->prepare("SELECT email FROM registration WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$recipient = $result->fetch_assoc();
$stmt->close();

if (!$recipient) {
    die("Recipient not found.");
}

$email = $recipient['email'];

// Fetch request by email
$stmt = $dbcon->prepare("SELECT * FROM requests WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();
$stmt->close();

if (!$request) {
    die("No request found for this recipient.");
}

// Update request if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($dbcon, $_POST['full_name']);
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date1'];
    $address = mysqli_real_escape_string($dbcon, $_POST['address']);
    $blood_type = strtoupper(trim($_POST['blood_type']));
    $quantity = (int)$_POST['quantity'];
    $request_date = $_POST['request_date'];
    $age = mysqli_real_escape_string($dbcon, $_POST['age1']);

    $stmt = $dbcon->prepare("UPDATE requests SET full_name=?, age= ? , gender=?, birth_date=?, address=?, blood_type=?, quantity=?, request_date=? WHERE email=?");
    $stmt->bind_param("sssssssss", $full_name, $age, $gender, $birth_date, $address, $blood_type, $quantity, $request_date, $email);

    if ($stmt->execute()) {
        $message = '<div class="alert alert-success text-center mt-3"> updated successfully.</div>';
    } else {
        $message = '<div class="alert alert-danger text-center mt-3">Update failed: ' . htmlspecialchars($stmt->error) . '</div>';
    }

    $stmt->close();

    // Refresh data
    $stmt = $dbcon->prepare("SELECT * FROM requests WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Recipient Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center" style="padding-top:120px; max-width: 800px;">
  <div class="card shadow-lg rounded-4 w-100">
    <div class="card-body p-3">
      <h2 class="card-title text-center mb-4">Edit Blood Request</h2>

      <?= $message ?>

      <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="full_name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="full_name" name="full_name" required
       value="<?= $request ? htmlspecialchars($request['full_name']) : '' ?>"  />
            </div>
            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select" id="gender" name="gender" required>
                <option value="Male" <?= ($request && $request['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= ($request && $request['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= ($request && $request['gender'] === 'Other') ? 'selected' : '' ?>>Other</option>
              </select>
            </div>
        
            <div class="mb-3">
    <label for="birth_date1" class="form-label">Birth Date</label>
    <input type="date" class="form-control" id="birth_date1" name="birth_date1" required onchange="checkAge1()"
    value="<?= htmlspecialchars(date('Y-m-d', strtotime($request['birth_date'] ?? ''))) ?>" />
</div>
<div class="mb-3">
    <label for="age1" class="form-label">Age</label>
    <input type="text" class="form-control" id="age1" name="age1" readonly value="<?= $request ? htmlspecialchars($request['age']) : '' ?>" />
</div>


<div class="mb-3">
    <label for="blood_type" class="form-label">Blood Type</label>
    <select class="form-select" id="blood_type" name="blood_type" required>
        <option selected disabled>Select Blood Type</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
</div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label for="quantity" class="form-label">Quantity (Units)</label>
              <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $request ? htmlspecialchars($request['quantity']) : '' ?>" min="1" required />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required />
            </div>
            <div class="mb-3">
              <label for="request_date" class="form-label">Request Date</label>
              <input type="date" class="form-control" id="request_date" name="request_date" value="<?= $request ? htmlspecialchars($request['request_date']) : '' ?>" required />
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" id="address" name="address" rows="2" required><?= $request ? htmlspecialchars($request['address']) : '' ?></textarea>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-danger w-100">Update</button>
      </form>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<script src="js/design1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
