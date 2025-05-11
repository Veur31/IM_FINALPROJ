<?php
session_start();
include("connection.php");
include("donor_navbar.php");

$message = '';
$already_registered = false;
$email = '';
$user_id = null;
$name = ''; // Declare the variable to store the name

// Check if the user is logged in as a donor
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'Donor') {
    // Redirect to the login page if the user is not logged in or is not a donor
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Get the email and user_id of the logged-in donor
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

// Get the donor's full name
$name_query = "SELECT full_name FROM registration WHERE username = ?";
$stmt_name = $dbcon->prepare($name_query);
$stmt_name->bind_param("s", $username);
$stmt_name->execute();
$result_name = $stmt_name->get_result();
if ($result_name->num_rows > 0) {
    $row = $result_name->fetch_assoc();
    $name = $row['full_name'];
}

// Check if the donor is already registered
$check_query = "SELECT d.donor_id, d.status FROM donors d WHERE d.email = ?";
$stmt_check = $dbcon->prepare($check_query);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $already_registered = true;
    $row = $result_check->fetch_assoc();
    $_SESSION['donor_id'] = $row['donor_id'];
    $status = $row['status'];
}

// Check the registration status of the donor
if (isset($status)) {
    if ($status === 'approved') {
  $message = '<div class="alert alert-success text-center mt-3">Your registration has been approved! Your Donor ID is: ' . $_SESSION['donor_id'] . '</div>';
    } else {
        $message = '<div class="alert alert-warning text-center mt-3">Your registration is declined.</div>';
    }
}

// Process approval if an admin has approved the registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donor_id'])) {
    $donor_id = $_POST['donor_id'];

    // Update the donor's status to 'approved'
    $approve_query = "UPDATE donors SET status = 'approved' WHERE donor_id = ?";
    $stmt_approve = $dbcon->prepare($approve_query);
    $stmt_approve->bind_param("i", $donor_id);
    $stmt_approve->execute();
     
}

// Handle donor registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['donor_id'])) {
    // Gather form data and insert into the donors table
    $name = mysqli_real_escape_string($dbcon, $_POST['name']);
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $blood_type = strtoupper(trim($_POST['blood_type']));
    $phone = mysqli_real_escape_string($dbcon, $_POST['phone']);
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);
    $address = mysqli_real_escape_string($dbcon, $_POST['address']);
    $last_donation_date = $_POST['last_donation_date'];
    $age = mysqli_real_escape_string($dbcon, $_POST['age']);
    $status = 'pending';

    $sql = "INSERT INTO donors (name, gender, birth_date, blood_type, phone, email, address, last_donation_date, status, age)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $arrange = $dbcon->prepare($sql);
    $arrange->bind_param("ssssssssss", $name, $gender, $birth_date, $blood_type, $phone, $email, $address, $last_donation_date, $status, $age);

    if ($arrange->execute()) {
        $_SESSION['donor_id'] = $arrange->insert_id; // Store donor_id in session
        $message = '<div class="alert alert-success text-center mt-3">Successful Registration.</div>';
        $already_registered = true;
    } else {
        $message = '<div class="alert alert-danger text-center mt-3"></div>';
    }

    $arrange->close();
}

// Close the database connection
$dbcon->close();

// Output any messages
if (!empty($message)) echo $message;
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
        <div class="alert alert-danger text-center mb-5">
        Thank you!
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

          <button type="submit" id="submitBtn" class="btn btn-danger w-100">Update</button>
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
