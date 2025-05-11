<?php
session_start();
include("connection.php");

if ( $_SESSION['user_type'] !== 'Admin') {
  // Redirect to the login page if the user is not logged in or is not a donor
  header("Location: login.php");
  exit();
}
if (!isset($_SESSION['username'])) {

    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT full_name FROM registration WHERE username = '$username'";
$result = mysqli_query($dbcon, $query);
$donor_name = "";

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $admin_name = $row['full_name'];
}



// Fetch all pending donors
$query = "SELECT request_id, full_name, gender, birth_date, blood_type, request_date FROM requests WHERE status = 'pending'";
$result = mysqli_query($dbcon, $query);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    // Determine action: approve or cancel
    if (isset($_POST['approve'])) {
        $status = 'approved';
    } elseif (isset($_POST['cancel'])) {
        $status = 'declined';
    }

    // Now run the correct UPDATE query
    $update_query = "UPDATE requests SET status = '$status' WHERE request_id = $request_id";

    if (mysqli_query($dbcon, $update_query)) {
        header("Location: admin_recipients.php");
        exit();
    } else {
        echo "Error: Could not update the request status.";
    }
}

// Count pending male recipients
$pending_recipients_male = "SELECT COUNT(*) AS count_male_recipients FROM requests WHERE gender = 'Male' and status = 'pending' ";
$pending_recipients_male_r = mysqli_query($dbcon, $pending_recipients_male);
$pending_recipients_male_c = 0;
if ($pending_recipients_male_r) {
    $row = mysqli_fetch_assoc($pending_recipients_male_r);
    $pending_recipients_male_c = $row['count_male_recipients'];
}
// Count pending female recipients
$pending_recipients_female = "SELECT COUNT(*) AS count_female_recipients FROM requests WHERE gender = 'Female' and status = 'pending' ";
$pending_recipients_female_r = mysqli_query($dbcon, $pending_recipients_female);
$pending_recipients_female_c = 0;
if ($pending_recipients_female_r) {
    $row = mysqli_fetch_assoc($pending_recipients_female_r);
    $pending_recipients_female_c = $row['count_female_recipients'];
}

// Count pending recipient requests
$pending_recipients = "SELECT COUNT(*) AS count FROM requests WHERE status = 'Pending'";
$pending_recipients_r= mysqli_query($dbcon, $pending_recipients);
$pending_recipients_c = 0;
if ($pending_recipients_r) {
    $row = mysqli_fetch_assoc($pending_recipients_r);
    $pending_recipients_c = $row['count'];
    
}

$stock_query_recipients = "SELECT blood_type, SUM(quantity) AS total_quantity FROM requests GROUP BY blood_type";
$stock_result_recipients = mysqli_query($dbcon, $stock_query_recipients);

if ($stock_result_recipients) {
    while ($row = mysqli_fetch_assoc($stock_result_recipients)) {
        $blood_stock_recipients[$row['blood_type']] = $row['total_quantity'];
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
  <h1 class="text-start pt-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Admin Dashboard</h1>
  <p style="font-size:18px; font-family: 'Poppins', sans-serif; font-weight: 400;">Welcome back, <?php echo $admin_name; ?>!</p>
  <hr class="my-4">
  <p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 50px; color:red;"><b>Overview</b>
  <div class="d-flex justify-content-center gap-3">
<div class="card" style="width: 42%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">Total numbers of Pending Recipients Requests</p>
        <p class="card-text" style="text-align: justify; font-size: 35px;"><strong><?php echo $pending_recipients_c; ?></strong></p>
        <hr class="my-4">
     

    </div>
   
        </div>
    </div>
</div>

<div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; margin-bottom: 20px;">

    <!-- Pending Donors Card -->
    <div class="card" style="width: 33%; padding: 10px; min-width: 300px;">
        <div class="card-body">
            <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">
                Total numbers of potential Male Recipients
            </p>
            <p class="card-text" style="text-align: justify; font-size: 35px;">
                <strong><?php echo $pending_recipients_male_c; ?></strong>
            </p>
            <hr class="my-4">

        </div>
    </div>

    <!-- Pending Recipients Card -->
    <div class="card" style="width: 33%; padding: 10px; min-width: 300px;">
        <div class="card-body">
            <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">
                Total numbers of potential Female Recipients
            </p>
            <p class="card-text" style="text-align: justify; font-size: 35px;">
                <strong><?php echo $pending_recipients_female_c; ?></strong>
            </p>
            <hr class="my-4">

        </div>
    </div>

</div>
<br>


<div class="container">
    <div class="d-flex justify-content-center mt-3">
        <div class="card" style="width: 79%; padding: 10px;">
            <div class="card-body">
                <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">
                   Potential blood units needed <p style="text-align: left; font-family: 'Playfair Display', serif; font-size:15px; padding-top:20px;">Based on Recipients data</p>
                    <br><br>
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>A+</strong><br>
                        <?php echo $blood_stock_recipients['A+'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>A-</strong><br>
                        <?php echo $blood_stock_recipients['A-'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>B+</strong><br>
                        <?php echo $blood_stock_recipients['B+'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>B-</strong><br>
                        <?php echo $blood_stock_recipients['B-'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>AB+</strong><br>
                        <?php echo $blood_stock_recipients['AB+'] ?? 0; ?> units
                    </div>
          
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>AB-</strong><br>
                        <?php echo $blood_stock_recipients['AB-'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>O+</strong><br>
                        <?php echo $blood_stock_recipients['O+'] ?? 0; ?> units
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>O-</strong><br>
                        <?php echo $blood_stock_recipients['O-'] ?? 0; ?> units
                    </div>
                </div>

                <hr class="my-4">
               
            </div>
        </div>
    </div>
</div>
<br>
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h4>Recipients</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-danger">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                            <th>Blood Type</th>
                            <th>Last Donation</th>
                            <th style="width: 30px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['request_id'] ?></td>
                                <td><?= $row['full_name'] ?></td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['birth_date'] ?></td>
                                <td><?= $row['blood_type'] ?></td>
                                <td><?= $row['request_date'] ?></td>
                                  <td>
                                    <form method="post" action="admin_recipients.php" class="d-flex">
                                        <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
                                        <button type="submit" name="approve" class="btn btn-success btn-sm me-2">Approve</button>
                                        <button type="submit" name="cancel" class="btn btn-danger btn-sm">Decline</button>
                                    </form>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br><br>
<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>