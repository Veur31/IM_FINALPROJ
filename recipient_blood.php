<?php
session_start();
include("connection.php");
include("recipient_navbar.php");
  // Checking if recipient is login, also for username validation
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'Recipient') {

    header("Location: login.php");
    exit();
}

$message = '';
$already_requested = false;
$email = '';
$user_id = null;
$name = '';
// for username validation checking (session)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    $email_query = "SELECT registration_id, email, full_name FROM registration WHERE username = ?";
    $stmt_email = $dbcon->prepare($email_query);
    $stmt_email->bind_param("s", $username);
    $stmt_email->execute();
    $result_email = $stmt_email->get_result();

    if ($result_email->num_rows > 0) {
        $row = $result_email->fetch_assoc();
        if (!empty($row['registration_id'])) {
            $user_id = $row['registration_id'];
            $email = $row['email'];
            $name = $row['full_name'];

            $check_query = "SELECT request_id FROM requests WHERE email = ?";
            $stmt_check = $dbcon->prepare($check_query);
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check && $result_check->num_rows > 0) {
                $already_requested = true;
            }
        } else {
            $message = '<div class="alert alert-danger text-center mt-3">Error: Invalid user ID fetched.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger text-center mt-3">Error: User data not found.</div>';
    }
}

if (isset($status)) {
    if ($status === 'approved') {
        $message = '<div class="alert alert-success text-center mt-3">Your registration has been approved! Your Recipient ID is: ' . $_SESSION['recipient_id'] . '</div>';
    } else {
        $message = '<div class="alert alert-warning text-center mt-3">Your registration is declined.</div>';
    }
}

//getting the infor from the recipients input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($dbcon, $_POST['full_name']);
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $address = mysqli_real_escape_string($dbcon, $_POST['address']);
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);
    $blood_type = strtoupper(trim($_POST['blood_type']));
    $quantity = (int)$_POST['quantity'];
    $request_date = $_POST['request_date'];
    $status = 'Pending'; 
    $age = mysqli_real_escape_string($dbcon, $_POST['age']);

    $sql = "INSERT INTO requests (full_name, gender, birth_date, address, email, blood_type, quantity, request_date, age, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //inseeting the data to the table
    if ($stmt = $dbcon->prepare($sql)) {
        $stmt->bind_param("ssssssssss", $full_name, $gender, $birth_date, $address, $email, $blood_type, $quantity, $request_date, $age, $status);

        if ($stmt->execute()) {
            $message = '<div class="alert alert-success text-center mt-3">Blood request submitted successfully.</div>';
            $already_requested = true;
            if (isset($status)) {

}
        } else {
            $message = '<div class="alert alert-danger text-center mt-3">Error submitting request.</div>';
        }

        $stmt->close();
    } 
}if (!empty($message)) echo $message;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Request Blood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<br><br>
<div class="container d-flex align-items-center justify-content-center" style="padding-top:120px; max-width: 800px;">
    <div class="card shadow-lg rounded-4 w-100">
        <div class="card-body p-3">
            <h2 class="card-title text-center mb-4">Blood Request Form</h2>
            <?php if (!empty($message)) echo $message; ?>

            <?php if ($already_requested): ?>
                <div class="alert alert-info text-center mb-5">
                    Thank you, email will be sent.
                </div>
            <?php else: ?>
                <form method="POST" action="recipient_blood.php">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($name); ?>" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option selected disabled>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
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
                  Valid age only
                </div>
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
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required />
                            </div>

                            <div class="mb-3">
                                <label for="request_date" class="form-label">Request Date</label>
                                <input type="date" class="form-control" id="request_date" name="request_date" required />
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
<script src="js/design3.js"></script>
</body>
</html>