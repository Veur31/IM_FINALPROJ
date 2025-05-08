  <?php
  session_start();
  include("connection.php");
  include("donor_navbar.php");

  $message = "";

  // Ensure the donor_id is set in the session
  if (!isset($_SESSION['donor_id'])) {
      die("Invalid session. No donor ID found.");
  }

  $donor_id = $_SESSION['donor_id'];  // Get the donor_id from the session

  // Fetch donor data based on the session's donor_id
  $query = "SELECT * FROM donors WHERE donor_id = ?";
  $stmt = $dbcon->prepare($query);
  $stmt->bind_param("i", $donor_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $donor = $result->fetch_assoc();
  $stmt->close();

  if (!$donor) {
      die("Donor not found.");
  }

  // Handle form submission to update donor data
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      // Sanitize and assign POST values to variables
      $name = mysqli_real_escape_string($dbcon, $_POST['name']);
      $gender = $_POST['gender'];
      $birth_date = $_POST['birth_date'];
      $blood_type = strtoupper(trim($_POST['blood_type']));
      $phone = mysqli_real_escape_string($dbcon, $_POST['phone']);
      $email = mysqli_real_escape_string($dbcon, $_POST['email']);
      $address = mysqli_real_escape_string($dbcon, $_POST['address']);
      $last_donation_date = $_POST['last_donation_date'];
      $age = mysqli_real_escape_string($dbcon, $_POST['age']);
      

      // SQL update query
      $update = "UPDATE donors SET name=?, gender=?, birth_date=?, blood_type=?, phone=?, email=?, address=?, last_donation_date=?, age=? WHERE donor_id=?";
      $stmt = $dbcon->prepare($update);
      $stmt->bind_param("ssssssssii", $name, $gender, $birth_date, $blood_type, $phone, $email, $address, $last_donation_date, $age, $donor_id);

      if ($stmt->execute()) {
          $message = '<div class="alert alert-danger text-center mt-3">Donor updated successfully.</div>';
      } else {
          $message = '<div class="alert alert-danger text-center mt-3">Update failed: ' . htmlspecialchars($stmt->error) . '</div>';
      }

      // Refresh donor data after update
      $stmt->close();
      $query = "SELECT * FROM donors WHERE donor_id = ?";
      $stmt = $dbcon->prepare($query);
      $stmt->bind_param("i", $donor_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $donor = $result->fetch_assoc();
      $stmt->close();
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Donor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center" style="padding-top:120px; max-width: 800px;">
  <div class="card shadow-lg rounded-4 mt-1 w-100">
    <div class="card-body p-3">
      <h2 class="card-title text-center mb-4">Edit Donor</h2>

      <?= $message ?>

      <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <input type="hidden" name="donor_id" value="<?= $donor_id ?>" />

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($donor['name']) ?>" required />
            </div>

            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select" id="gender" name="gender">
                <option value="Male" <?= $donor['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $donor['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $donor['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="birth_date" class="form-label">Birth Date</label>
              <input type="date" class="form-control" id="birth_date" name="birth_date" 
              value="<?= htmlspecialchars(date('Y-m-d', strtotime($donor['birth_date'] ?? ''))) ?>" />
            </div>
            <div class="mb-3">
              <label for="age" class="form-label">Age</label>
              <input type="text" class="form-control" id="age" name="age" readonly />
            </div>
            <div class="mb-3">
              <label for="blood_type" class="form-label">Blood Type</label>
              <input type="text" class="form-control" id="blood_type" name="blood_type" value="<?= htmlspecialchars($donor['blood_type']) ?>" required />
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($donor['phone']) ?>" />
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($donor['email']) ?>" />
            </div>

            <div class="mb-3">
              <label for="last_donation_date" class="form-label">Last Donation Date</label>
              <input type="date" class="form-control" id="last_donation_date" name="last_donation_date" 
              value="<?= htmlspecialchars(date('Y-m-d', strtotime($donor['last_donation_date'] ?? ''))) ?>" />
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" id="address" name="address" rows="2" required><?= htmlspecialchars($donor['address']) ?></textarea>
            </div>
          </div>
        </div>

        <button type="submit" id="submitBtn" class="btn btn-danger w-100">Update Donor</button>
      </form>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/design1.js"></script>
</body>
</html>
