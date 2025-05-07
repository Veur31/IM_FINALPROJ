<?php
session_start();
include("connection.php");
include("recipient_navbar.php");

$message = '';

// Handle request submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $full_name = mysqli_real_escape_string($dbcon, $_POST['full_name']);
    $birth_date = $_POST['birth_date'];
    $address = mysqli_real_escape_string($dbcon, $_POST['address']);
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);
    $blood_type = strtoupper(trim($_POST['blood_type']));
    $quantity = (int)$_POST['quantity'];
    $request_date = $_POST['request_date'];
    $status = 'Pending'; // Default status for the request

    // SQL query to insert data into the database
    $sql = "INSERT INTO requests (full_name, birth_date, address, email, blood_type, quantity, request_date, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind statement
    if ($stmt = $dbcon->prepare($sql)) {
        $stmt->bind_param("ssssssss", $full_name, $birth_date, $address, $email, $blood_type, $quantity, $request_date, $status);

        // Execute the statement
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success text-center mt-3">Blood request submitted successfully.</div>';
        } else {
            $message = '<div class="alert alert-danger text-center mt-3">Error submitting request.</div>';
        }

        // Close statement
        $stmt->close();
    } else {
        $message = '<div class="alert alert-danger text-center mt-3">Error preparing the query.</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Request Blood</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<br><br>
<div class="container d-flex justify-content-center" style="padding-top:120px; max-width: 800px;">
  <div class="card shadow-lg rounded-4 w-100">
    <div class="card-body">
      <h2 class="card-title text-center mb-4">Blood Request Form</h2>

      <!-- Success or Error Message (if any) -->
      <div id="message"><?php echo $message; ?></div>

      <form method="POST" action="">
        <div class="row">
          <!-- Left Column -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="full_name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="full_name" name="full_name" required/>
            </div>

            <div class="mb-3">
              <label for="birth_date" class="form-label">Birth Date</label>
              <input type="date" class="form-control" id="birth_date" name="birth_date" required/>
              <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="text" class="form-control" id="age" name="age" readonly/>
               
              </div>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="quantity" class="form-label">Quantity (in units)</label>
              <input type="number" class="form-control" id="quantity" name="quantity" required/>
            </div>

            <div class="mb-3">
              <label for="blood_type" class="form-label">Blood Type</label>
              <input type="text" class="form-control" id="blood_type" name="blood_type" placeholder="e.g., A+, O-, AB+" required/>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required/>
            </div>

            <div class="mb-3">
              <label for="request_date" class="form-label">Date Needed</label>
              <input type="date" class="form-control" id="request_date" name="request_date" required/>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-danger w-100">Submit Request</button>
      </form>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/design1.js"></script>
</body>
</html>
