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
// Count pending donors
$pending_donors = "SELECT COUNT(*) AS count FROM donors WHERE status = 'pending'";
$pending_donors_r = mysqli_query($dbcon, $pending_donors);
$pending_donors_c = 0;
if ($pending_donors_r) {
    $row = mysqli_fetch_assoc($pending_donors_r);
    $pending_donors_c = $row['count'];
}
// Count pending male donors
$pending_donors_male = "SELECT COUNT(*) AS count_male FROM donors WHERE status = 'pending' AND gender = 'Male'";
$pending_donors_male_r = mysqli_query($dbcon, $pending_donors_male);
$pending_donors_male_c = 0;
if ($pending_donors_male_r) {
    $row = mysqli_fetch_assoc($pending_donors_male_r);
    $pending_donors_male_c = $row['count_male'];
}

// Count pending female donors
$pending_donors_female = "SELECT COUNT(*) AS count_female FROM donors WHERE status = 'pending' AND gender = 'Female'";
$pending_donors_female_r = mysqli_query($dbcon, $pending_donors_female);
$pending_donors_female_c = 0;
if ($pending_donors_female_r) {
    $row = mysqli_fetch_assoc($pending_donors_female_r);
    $pending_donors_female_c = $row['count_female'];
}


$blood_stock = [];

$stock_query = "SELECT blood_type, COUNT(*) AS donor_count FROM donors GROUP BY blood_type";
$stock_result = mysqli_query($dbcon, $stock_query);

if ($stock_result) {
    while ($row = mysqli_fetch_assoc($stock_result)) {
        $blood_stock[$row['blood_type']] = (int)$row['donor_count'];
    }
}
// Fetch all pending donors
$query = "SELECT donor_id, name, gender, birth_date, blood_type, last_donation_date FROM donors WHERE status = 'pending'";
$result = mysqli_query($dbcon, $query);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donor_id'])) {
    $donor_id = $_POST['donor_id'];

    // Update the donor's status to 'approved'
  
    // Determine action: approve or cancel
    if (isset($_POST['approve'])) {
        $status = 'approved';
    } elseif (isset($_POST['cancel'])) {
        $status = 'declined';
    }
      $update_query = "UPDATE donors SET status = '$status' WHERE donor_id = '$donor_id'";
    if (mysqli_query($dbcon, $update_query)) {
        // Redirect back to the dashboard or donor list after approval
        header("Location: admin_donor.php");
        exit();
    } else {
        echo "Error: Could not approve the donor.";
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

<div class="card" style="width: 35%; padding: 10px;">
    <div class="card-body">
        <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">Total numbers of Pending Donors</p>
        <p class="card-text" style="text-align: justify; font-size: 35px;"> <strong><?php echo $pending_donors_c; ?></strong></p>
        <hr class="my-4">
        <div style="display: flex; justify-content: space-between; align-items: center;">
           
           
        </div>
        
    </div>
</div>




    <!-- Pending Donors Card -->
    <div class="card" style="width: 33%; padding: 10px; min-width: 300px;">
        <div class="card-body">
            <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">
                Total numbers of potential Male donors
            </p>
            <p class="card-text" style="text-align: justify; font-size: 35px;">
                <strong><?php echo $pending_donors_male_c; ?></strong>
            </p>
            <hr class="my-4">
            <div style="display: flex; justify-content: space-between; align-items: center;">
               
               
            </div>
        </div>
    </div>

  
    <div class="card" style="width: 33%; padding: 10px; min-width: 300px;">
        <div class="card-body">
            <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">
                Total numbers of potential Female donors
            </p>
            <p class="card-text" style="text-align: justify; font-size: 35px;">
                <strong><?php echo $pending_donors_female_c; ?></strong>
            </p>
            <hr class="my-4">
            <div style="display: flex; justify-content: space-between; align-items: center;">
               
              
            </div>
        </div>
    </div>

</div>
</div>
<br>
<div class="container">
    <div class="d-flex justify-content-center mt-3">
        <div class="card" style="width: 79%; padding: 10px;">
            <div class="card-body">
                <p class="card-text" style="text-align: left; font-family: 'Playfair Display', serif; font-size:30px; padding-top:20px;">
                   Number of donors per Blood Type<p class="card-text" style="font-family: 'Playfair Display', serif; font-size:15px; margin: 0;"> (Potential) </p>
                    <br><br>
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>A+</strong><br>
                        <?php echo $blood_stock['A+'] ?? 0; ?> Donors
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>A-</strong><br>
                        <?php echo $blood_stock['A-'] ?? 0; ?> Donors
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>B+</strong><br>
                        <?php echo $blood_stock['B+'] ?? 0; ?> Donors
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>B-</strong><br>
                        <?php echo $blood_stock['B-'] ?? 0; ?> Donors
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>AB+</strong><br>
                        <?php echo $blood_stock['AB+'] ?? 0; ?> Donors
                    </div>
          
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>AB-</strong><br>
                        <?php echo $blood_stock['AB-'] ?? 0; ?> Donors
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>O+</strong><br>
                        <?php echo $blood_stock['O+'] ?? 0; ?> Donors
                    </div>
                    <div class="vr" style="height:80px;"></div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <strong>O-</strong><br>
                        <?php echo $blood_stock['O-'] ?? 0; ?> Donors
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
            <h4>Approve Donors</h4>
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
                                <td><?= $row['donor_id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['birth_date'] ?></td>
                                <td><?= $row['blood_type'] ?></td>
                                <td><?= $row['last_donation_date'] ?></td>
                                  <td>
                                    <!-- Form to handle the "Approve" action -->
                                   <form method="post" action="admin_donor.php" class="d-flex">
                                        <input type="hidden" name="donor_id" value="<?= $row['donor_id'] ?>">
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