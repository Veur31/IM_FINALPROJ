<?php
session_start();
include("connection.php");
//Checjing if the user is admin
if ($_SESSION['user_type'] !== 'Admin') {
  header("Location: login.php");
  exit();
}
//for username validation
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
//for username validation
$username = $_SESSION['username'];
$query = "SELECT full_name FROM registration WHERE username = '$username'";
$result = mysqli_query($dbcon, $query);
$donor_name = "";

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $admin_name = $row['full_name'];
}

// Fetch all pending donors
$query = "SELECT donor_id, name, gender, birth_date, blood_type, last_donation_date,email, status FROM donors WHERE status = 'approved' || status = 'pending' ||status = 'declined' ";
$result_donors = mysqli_query($dbcon, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);

    if (isset($_POST['remove'])) {
        // Delete from table (registration)
        $delete_query = "DELETE FROM registration WHERE email = '$email'";

        if (mysqli_query($dbcon, $delete_query)) {

            header("Location: admin_management.php");
            exit();
        } 
    }
}


// Fetch all pending requests
$query = "SELECT request_id, full_name, gender, birth_date, blood_type, request_date,email,  status FROM requests WHERE status = 'approved' || status = 'pending' ||status = 'declined' ";
$result_requests = mysqli_query($dbcon, $query);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);

    if (isset($_POST['remove'])) {
        // Delete from table (registration)
        $delete_query = "DELETE FROM registration WHERE email = '$email'";

        if (mysqli_query($dbcon, $delete_query)) {

            header("Location: admin_management.php");
            exit();
        } 
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


<br>
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h4>Donors</h4>
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
                             <th>Status</th>
                            <th style="width: 30px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_donors)): ?>
                            <tr>
                                <td><?= $row['donor_id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['birth_date'] ?></td>
                                <td><?= $row['blood_type'] ?></td>
                                <td><?= $row['last_donation_date'] ?></td>
                                <td><?= $row['status'] ?></td>
                                <td>
                                <form method="post" action="admin_management.php" class="d-flex" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="email" value="<?= $row['email'] ?>">
                                    <button type="submit" name="remove" class="btn btn-danger btn-sm me-2">Remove</button>
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
</div>
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
                            <th>Status</th>
                            <th style="width: 30px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_requests)): ?>
                            <tr>
                                <td><?= $row['request_id'] ?></td>
                                <td><?= $row['full_name'] ?></td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['birth_date'] ?></td>
                                <td><?= $row['blood_type'] ?></td>
                                <td><?= $row['request_date'] ?></td>
                                 <td><?= $row['status'] ?></td>
                                <td>
                                    <form method="post" action="admin_management.php" class="d-flex" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                             <input type="hidden" name="email" value="<?= $row['email'] ?>">
                                        <button type="submit" name="remove" class="btn btn-danger btn-sm me-2">Remove</button>
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
</div>
<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>