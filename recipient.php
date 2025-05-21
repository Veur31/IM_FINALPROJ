<?php
session_start();
  // Checking if recipient is login, also for username validation
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'Recipient') {
   
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/design.css">
</head>
<body>

<?php 
include("recipient_navbar.php");
include("connection.php");
    $username = $_SESSION['username'];
    $query = "SELECT full_name FROM registration WHERE username = '$username'";
    $result = mysqli_query($dbcon, $query);
    $donor_name = "";

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $donor_name = $row['full_name'];
    }
?>

<div class="container">

  <h1 class="text-start pt-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Recipeints OVERVIEW</h1>
  <p style="font-size:18px; font-family: 'Poppins', sans-serif; font-weight: 400;">Welcome back, <?php echo $donor_name; ?>!</p>
  <h1 class="text-start pt-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Recipeints Overview</h1>
  <p style="font-size:18px; font-family: 'Poppins', sans-serif; font-weight: 400;">Welcome back, <?php echo $donor_name; ?>!</p>
  <hr class="my-4">
  <p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 50px; color:red;"><b>Requirements</b>
  <div class="d-flex justify-content-center gap-3">

<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Blood Transfusion Order</strong></p>
            <ul>
                <li>A formal written request or referral from a licensed physician stating the need for a blood transfusion, blood type, and the number of units required.</li>
               
            </ul>
    </div>

</div>


<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Patient Information</strong></p>
            <ul>
                <li>Full name, age, gender, and diagnosis.</li>
                <li>Hospital or facility name where the patient is admitted.</li>

            </ul>

</p>
    </div>

</div>


<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Blood Type of the Patient</strong></p>
            <ul>
                <li>This helps match and prepare the correct blood unit faster.</li>
            </ul>
    </div>
   
</div>
</div>
<hr class="my-4">

<div class="d-flex justify-content-center gap-3 mt-4">

<div class="card" style="width: 25%; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Valid Identification Card (ID)</strong></p>
            <ul>
                <li>For the patient’s representative or the requester (e.g., government-issued ID like UMID, PhilHealth ID, or driver’s license).</li>

            </ul>
    </div>
   
</div>


<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Blood Request Form or Slip from the Hospital</strong></p>
            <ul>
                <li>Usually provided by the attending medical staff for submission to the blood bank.</li>

            </ul>
    </div>
  
</div>
</div>
</div>
<br><br>
<p style="text-align: center; font-family: Lora, serif; font-size: 20px;">
<strong>If you believe you are eligible to donate, please proceed by clicking this button.</strong>
  <br><br>
  <a href="recipient_blood.php">
  <button class="btn btn-danger" style="font-size: 17px;">Click here!</button>
</a>
<?php 
include("footer.php");?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>