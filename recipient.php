<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'Recipient') {
    // Redirect to the login page if the user is not logged in or is not a donor
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

  <h1 class="text-start pt-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">DONORS OVERVIEW</h1>
  <p style="font-size:18px; font-family: 'Poppins', sans-serif; font-weight: 400;">Welcome back, <?php echo $donor_name; ?>!</p>
  <h1 class="text-start pt-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">DONORS OVERVIEW</h1>
  <p style="font-size:18px; font-family: 'Poppins', sans-serif; font-weight: 400;">Welcome back, <?php echo $donor_name; ?>!</p>
  <hr class="my-4">
  <p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 50px; color:red;"><b>Who can donate?</b>
  <div class="d-flex justify-content-center gap-3">

<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Basic Eligibility</strong></p>
            <ul>
                <li>Age between 16 to 65 years (some countries allow 16 to 17 with consent).</li>
                <li>Must weigh at least 50 kg (110 lbs)</li>
                <li>In good physical health</li>
                <li>No active illnesses or infections</li>
                <li>Adequate hemoglobin level</li>
            </ul>
    </div>

</div>


<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Donation Frequency & Preparation</strong></p>
            <ul>
                <li>Minimum 56 days between whole blood donations.</li>
                <li>Eat a healthy meal and stay hydrated before donating.</li>
                <li>Avoid alcohol 24 hours prior.</li>
                <li>Bring valid ID.</li>
                <li>Get enough sleep the night before.</li>
            </ul>

</p>
    </div>

</div>


<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Benefits of Donating Blood</strong></p>
            <ul>
                <li>Saves up to 3 lives with one donation.</li>
                <li>Promotes heart health.</li>
                <li>Reduces harmful iron stores.</li>
                <li>Stimulates blood cell production.</li>
                <li>Provides free mini health check-up.</li>
            </ul>
    </div>
   
</div>
</div>
<hr class="my-4">
<p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 50px; color:red;"><b>Who cannot donate?</b>
<div class="d-flex justify-content-center gap-3 mt-4">

<div class="card" style="width: 25%; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Disqualifying conditions</strong></p>
            <ul>
                <li>Recent tattoo or piercing (within last 6 to 12 months).</li>
                <li>History of certain diseases (e.g., hepatitis, HIV/AIDS).</li>
                <li>Pregnant or recently gave birth.</li>
                <li>Taking certain medications.</li>
                <li>Recently received a blood transfusion or vaccine</li>
            </ul>
    </div>
   
</div>


<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Temporary Deferrals</strong></p>
            <ul>
                <li>Recent tattoo or piercing (within last 12 months, depending on regulations).</li>
                <li>Recent surgery or major dental work.</li>
                <li>Recent travel to malaria-risk countries.</li>
                <li>Cold, flu, or other short-term illness.</li>
                <li>Pregnancy or recently given birth.</li>
            </ul>
    </div>
  
</div>


<div class="card" style="width: 25%; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Permanent Deferrals</strong></p>
            <ul>
                <li>Tested positive for HIV, hepatitis B or C.</li>
                <li>History of certain cancers (e.g., leukemia).</li>
                <li>Use of intravenous drugs not prescribed by a doctor.</li>
                <li>Chronic diseases like uncontrolled diabetes or severe heart conditions.</li>
                <li>Lived in countries with certain blood-related disease risks.</li>
            </ul>
    </div>

  
</div>
</div>
</div>
<hr class="my-4">
<p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 50px; color:red;"><b>How to donate?<br>And the donation process</b>
<div class="d-flex justify-content-center gap-3 mt-4">

<div class="card" style="width: 25%; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Registration Steps</strong></p>
            <ul>
                <li>Fill out the online donor registration form with your personal and health information.</li>
                <li>Wait for confirmation via email or SMS, which will include screening instructions and your donor ID.</li>
                <li>Choose a nearby HemoVault unit from our list of active locations.</li>
            </ul>
    </div>
   
</div>


<div class="card" style="width: 25%; padding: 10px;">
    
<div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Find a HemoVault Mobile Blood Donation Unit</strong></p>
            <ul>
                <li>Track the schedule of mobile units by checking their online calendar or mobile app.</li>
                <li>HemoVault units typically visit local communities, schools, and universities for convenient access.</li>
                <li>Some units may offer special promotions or incentives for donors, like certificates or rewards.</li>
            </ul>
    </div>
  
</div>


<div class="card" style="width: 25%; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Pre-Donation Health Screening</strong></p>
            <ul>
                <li>The nurse or medical professional will check vital signs such as temperature, blood pressure, and heart rate.</li>
                <li>Donors will answer confidential health questionnaires regarding their medical history and lifestyle.</li>
                <li>The staff may perform an iron test (finger prick) to ensure that you have enough hemoglobin for safe donation.</li>

            </ul>
    </div>

  
</div>
</div>
</div>
<div class="d-flex justify-content-center gap-3 mt-4">

<div class="card" style="width: 25%; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong> The Donation Process</strong></p>
            <ul>
                <li>A sterile needle is inserted into your arm to draw blood; this typically takes 8–10 minutes.</li>
                <li>Squeeze a stress ball or clench your fist to help blood flow smoothly.<li>
                <li>After donating, the unit may give you the option to donate blood components like plasma or platelets using the apheresis process.</li>

            </ul>
    </div>
   
</div>


<div class="card" style="width: 25%; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Post-Donation Care</strong></p>
            <ul>
                <li>After donating, you will be asked to rest for 10–15 minutes and enjoy refreshments (juice, snacks, or water).</li>
                <li>Monitor yourself for any signs of dizziness or lightheadedness; let staff know if you feel unwell.</li>
                <li>You’ll receive instructions for post-donation care, such as drinking fluids and avoiding strenuous activities for the rest of the day.</li>

            </ul>
    </div>
  
</div>


<div class="card" style="width: 25%; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;"><strong>Follow-Up & Recovery</strong></p>
            <ul>
                <li>Drink plenty of water for the next 24 hours to help your body recover.</li>
                <li>Avoid any heavy lifting or intense exercise for at least 24 hours post-donation.</li>
                <li>Rest and eat well to replenish your energy; you may be encouraged to donate again after a certain period (usually 56 days for whole blood).</li>

            </ul>
    </div>

</div>
</div>
</div>
<br><br>
<p style="text-align: center; font-family: Lora, serif; font-size: 20px;">
<strong>If you believe you are eligible to donate, please proceed by clicking this button.</strong>
  <br><br>
  <a href="donor_donate.php">
  <button class="btn btn-danger" style="font-size: 17px;">Donate!</button>
</a>
<?php 
include("footer.php");?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>