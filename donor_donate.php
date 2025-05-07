<?php
session_start();
include("connection.php");
include("donor_navbar.php");

$message = '';
$already_registered = false;
$email = '';
$user_id = null;
$name = ''; // Declare the variable to store the name

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Get email and user_id from registration
    $email_query = "SELECT id, email FROM registration WHERE username = ?";
    $stmt_email = $dbcon->prepare($email_query);
    $stmt_email->bind_param("s", $username);
    $stmt_email->execute();
    $result_email = $stmt_email->get_result();
    if ($result_email->num_rows > 0) {
        $row = $result_email->fetch_assoc();
        $email = $row['email'];
        $user_id = $row['id'];
    }

    // Fetch the full name from the registration table
    $name_query = "SELECT full_name FROM registration WHERE username = ?";
    $stmt_name = $dbcon->prepare($name_query);
    $stmt_name->bind_param("s", $username);
    $stmt_name->execute();
    $result_name = $stmt_name->get_result();
    if ($result_name->num_rows > 0) {
        $row = $result_name->fetch_assoc();
        $name = $row['full_name'];
    }

    // Check if already registered in donors
    $check_query = "
        SELECT d.donor_id 
        FROM donors d 
        WHERE d.email = ?
    ";
    $stmt_check = $dbcon->prepare($check_query);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $already_registered = true;
        $row = $result_check->fetch_assoc();
        $_SESSION['donor_id'] = $row['donor_id']; // Save donor_id in session
    }
}

// Handle form submission only if not already registered
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name = mysqli_real_escape_string($dbcon, $_POST['name']);
  $gender = $_POST['gender'];
  $birth_date = $_POST['birth_date'];
  $blood_type = strtoupper(trim($_POST['blood_type']));
  $phone = mysqli_real_escape_string($dbcon, $_POST['phone']);
  $email = mysqli_real_escape_string($dbcon, $_POST['email']);
  $address = mysqli_real_escape_string($dbcon, $_POST['address']);
  $last_donation_date = $_POST['last_donation_date'];

  $sql = "INSERT INTO donors (name, gender, birth_date, blood_type, phone, email, address, last_donation_date, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

  $arrange = $dbcon->prepare($sql);
  $arrange->bind_param("ssssssss", $name, $gender, $birth_date, $blood_type, $phone, $email, $address, $last_donation_date);

  if ($arrange->execute()) {
    $_SESSION['donor_id'] = $arrange->insert_id; // Store donor_id in session

    $message = '<div class="alert alert-success text-center mt-3">Successful Registration.</div>';
    $already_registered = true;
  } else {
    $message = ' ';
  }

  $arrange->close();
  $dbcon->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Donor Donate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<br><br>
<div class="container d-flex align-items-center justify-content-center" style="padding-top:120px; max-width: 800px;">
  <div class="card shadow-lg rounded-4 mt-1 w-100">
    <div class="card-body p-3">
      <h2 class="card-title text-center mb-4">Donor Registration</h2>

      <?php
        if (!empty($message)) echo $message;
      ?>

      <?php if ($already_registered): ?>
        <div class="alert alert-info text-center mb-5">
          You have already registered as a donor. Thank you!
        </div>
      <?php else: ?>
        <form method="POST" action="donor_donate.php">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly/>
              </div>

              <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                  <option selected disabled>Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="birth_date" class="form-label">Birth Date</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" required/>
              </div>

              <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="text" class="form-control" id="age" name="age" readonly/>
                <div id="age-warning" class="text-danger mt-1" style="display: none;">
                  Donors must be between 16 and 65 years old.
                </div>
              </div>

              <div class="mb-3">
                <label for="blood_type" class="form-label">Blood Type</label>
                <input type="text" class="form-control" id="blood_type" name="blood_type" placeholder="e.g., A+, O-, AB+" required/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required/>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required/>
              </div>

              <div class="mb-3">
                <label for="last_donation_date" class="form-label">Last Donation Date</label>
                <input type="date" class="form-control" id="last_donation_date" name="last_donation_date"/>
                <div id="donation-warning" class="text-danger mt-1" style="display: none;">
                  You must wait at least 56 days between donations.
                </div>
              </div>

              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
              </div>
            </div>
          </div>

          <button type="submit" id="submitBtn" class="btn btn-danger w-100">Submit</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
<br><br><br><br><br><br><br><br><br><br>
<?php include("footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/design1.js"></script>
</body>
</html>
