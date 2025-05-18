<?php
session_start();
include("connection.php");
//  only admin can access
if ($_SESSION['user_type'] !== 'Admin') {
    header("Location: login.php");
    exit();
}
// To idenify if the user is log in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// get the user full name to display in the screen
$username = $_SESSION['username'];
$query = "SELECT full_name FROM registration WHERE username = '$username'";
$result = mysqli_query($dbcon, $query);
$admin_name = "";
$message = '';

// if there is user
if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $admin_name = $row['full_name'];
}

$blood_stock = [
    'A+' => 0,
    'A-' => 0,
    'B+' => 0,
    'B-' => 0,
    'AB+' => 0,
    'AB-' => 0,
    'O+' => 0,
    'O-' => 0
];

//associative array, it is set to none so that if they failed to search it will not cause error
$donor_info = ['name' => '', 'age' => '', 'blood_type' => '', 'status' => ''];

// fetching the donor_id so the data of the user will be available
if (isset($_POST['donor_id']) && !empty($_POST['donor_id'])) {
    $donor_id = $_POST['donor_id'];

    // Fetch donor information including name, age, blood_type, and status
    $query = "SELECT name, age, blood_type, status FROM donors WHERE donor_id = ?";
    $stmt = $dbcon->prepare($query);
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $donor_info['name'] = $row['name'];
        $donor_info['age'] = $row['age'];
        $donor_info['blood_type'] = $row['blood_type'];
        $donor_info['status'] = $row['status'];
    } else {
        $message = "Donor not found.";
    }
}

// Fetch blood stock
$stock_query = "SELECT blood_type, quantity FROM blood_stock";
$stock_result = mysqli_query($dbcon, $stock_query);

if ($stock_result) {
    while ($row = mysqli_fetch_assoc($stock_result)) {
        $blood_stock[$row['blood_type']] = $row['quantity'];
    }
}

// Handle form submission for donation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_donation'])) {
    $donor_id = $_POST['donor_id'];

    // Check donor status again
    $stmt = $dbcon->prepare("SELECT status FROM donors WHERE donor_id = ?");
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['status'] !== 'approved') {
            $message = 'Donation not allowed. Donor status is not approved.';
        } else {
            // Proceed with donation
            $name = $_POST['name'];
            $age = $_POST['age'];
            $blood_type = strtoupper(trim($_POST['blood_type']));
            $quantity = intval($_POST['units']);
            $donation_date = $_POST['request_date'];

            // Insert donation
            $donation_stmt = $dbcon->prepare("INSERT INTO donations (name, age, blood_type, quantity, donation_date) VALUES (?, ?, ?, ?, ?)");
            $donation_stmt->bind_param("sisss", $name, $age, $blood_type, $quantity, $donation_date);
            $donation_stmt->execute();
            $donation_stmt->close();

            // Update stock
            $check_stmt = $dbcon->prepare("SELECT quantity FROM blood_stock WHERE blood_type = ?");
            $check_stmt->bind_param("s", $blood_type);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $update_stmt = $dbcon->prepare("UPDATE blood_stock SET quantity = quantity + ? WHERE blood_type = ?");
                $update_stmt->bind_param("is", $quantity, $blood_type);
                $update_stmt->execute();
                $update_stmt->close();
            }
            $check_stmt->close();

            $message = 'Donation recorded and blood stock updated!';
        }
    } else {
        $message = "Donor not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<?php include("admin_navbar.php"); ?>
<div class="container">
  <h1 class="text-start pt-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Admin Dashboard</h1>
  <p style="font-size:18px; font-family: 'Poppins', sans-serif; font-weight: 400;">Welcome back, <?php echo $admin_name; ?>!</p>
  <hr class="my-4">

  <p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 50px; color:red;"><b>Full Report</b></p>


<div class="container">
    <div class="d-flex justify-content-center mt-3">
        <div class="card" style="width: 79%; padding: 10px;">
            <div class="card-body">
                <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">
                    Blood stock
                    <br><br>
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>A+</strong><br>
                        <?php echo $blood_stock['A+'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>A-</strong><br>
                        <?php echo $blood_stock['A-'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>B+</strong><br>
                        <?php echo $blood_stock['B+'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>B-</strong><br>
                        <?php echo $blood_stock['B-'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>AB+</strong><br>
                        <?php echo $blood_stock['AB+'] ?? 0; ?> units
                    </div>
          
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>AB-</strong><br>
                        <?php echo $blood_stock['AB-'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>O+</strong><br>
                        <?php echo $blood_stock['O+'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>O-</strong><br>
                        <?php echo $blood_stock['O-'] ?? 0; ?> units
                    </div>
                </div>

                <hr class="my-4">
               
            </div>
        </div>
    </div>
</div>

<div class="container mt-5" style="padding-left:300px">
    <div class="card" style="width: 70%; padding: 15px;">
       <form method="POST" action="admin_blood_inventory.php">
    <div class="row">
        <p style="text-align: center; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;padding-right:30px;">
            Input blood data
        </p>

        <!-- Success message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger" role="alert" style="text-align: center; font-size: 16px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Donor ID Field -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="donor_id" class="form-label">Enter ID</label>
                <input type="text" class="form-control" id="donor_id" name="donor_id" value="<?php echo isset($donor_id) ? htmlspecialchars($donor_id) : ''; ?>" required />
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" id="searchBtn" class="btn btn-danger w-100">Search</button>
            </div>
        </div>

        <!-- Donor Name Field -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Donor Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($donor_info['name']); ?>" readonly required />
            </div>
        </div>

        <!-- Age Field -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($donor_info['age']); ?>" readonly required />
            </div>
        </div>

        <!-- Blood Type Field -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="blood_type" class="form-label">Blood Type</label>
                <input type="text" class="form-control" id="blood_type" name="blood_type" value="<?php echo htmlspecialchars($donor_info['blood_type']); ?>" readonly required />
            </div>
        </div>

        <!-- Units Field -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="units" class="form-label">Quantity in units</label>
                <input type="number" class="form-control" id="units" name="units" value="0" required />
            </div>
        </div>

<!-- Request Date Field -->
<div class="mb-3">
    <label for="request_date" class="form-label">Date</label>
    <input type="date" class="form-control" id="request_date" name="request_date" value="<?php echo date('Y-m-d'); ?>" readonly required />
</div>


        <!-- Submit Button -->
        <div class="row">
            <div class="col-12">
                <button type="submit" id="submitBtn" name="submit_donation" class="btn btn-danger w-100">Submit</button>
            </div>
        </div>
    </div>
</form>
    </div>
</div>
</div>
<br><br>
<?php include("footer.php"); ?>
<script src="js/design2.js"></script>
</body>
</html>
