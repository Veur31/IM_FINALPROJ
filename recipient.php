<?php
session_start();

if (!isset($_SESSION['username'])) {

    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipient</title>

</head>
<body>
<?php include("recipient_navbar.php"); ?>
<div class="container">
  <h1 class="text-start pt-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">DONORS OVERVIEW</h1>
  <p style="font-size:18px; font-family: 'Poppins', sans-serif; font-weight: 400;">Welcome back, <?php echo $donor_name; ?>!</p>
  <hr class="my-4">

  <div class="d-flex justify-content-center gap-3">

<div class="card" style="width: 18rem; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;">World Blood Donor Day (June 14) Celebration</p>
        <p class="card-text" style="text-align: justify;"> Feature an event highlighting the significance of voluntary blood donation and the role of blood donors in saving lives. You can include success stories,
             thank-you notes to donors, and share a call to action for more people to donate.</p>
    </div>
    <img src="photo/world.jpg" class="card-img-top" alt="Éloise Dupont" style="width: 100%; height: 200px; object-fit: cover;">
</div>


<div class="card" style="width: 18rem; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;">Blood Donation Drive Partnership with Local Universities</p>
        <p class="card-text" style="text-align: justify;">A partnership with local schools or universities to host blood donation drives. The event can focus on educating students about the importance of blood donation, and you could feature incentives like certificates or small rewards for donors.

</p>
    </div>
    <img src="photo/lpu.jpg" class="card-img-top" alt="Éloise Dupont" style="width: 100%; height: 200px; object-fit: cover;">
</div>


<div class="card" style="width: 18rem; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;">Hemo Vault Mobile Blood Donation Units Launch</p>
        <p class="card-text" style="text-align: justify;">Announce the launch of mobile blood donation units in different communities or neighborhoods, making it easier for people to donate blood at their convenience. Highlight the ease and accessibility of blood donation.</p>
    </div>
    <img src="photo/app.png" class="card-img-top" alt="Éloise Dupont" style="width: 100%; height: 200px; object-fit: cover;">
</div>
</div>

<div class="d-flex justify-content-center gap-3 mt-4">

<div class="card" style="width: 18rem; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;">Meet Our Donors: Real-Life Stories</p>
        <p class="card-text" style="text-align: justify;">Listen to the inspiring stories of individuals who regularly donate blood, or highlight someone who has saved lives through blood donation. Real-life testimonials can motivate others to donate.</p>
    </div>
    <img src="photo/story.jpg" class="card-img-top" alt="Éloise Dupont" style="width: 100%; height: 200px; object-fit: cover;">
</div>


<div class="card" style="width: 18rem; padding: 10px;">
    
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;">New Blood Donation Guidelines and Safety Measures</p>
        <p class="card-text" style="text-align: justify;">Educate visitors on updated blood donation protocols, ensuring safety for both donors and recipients. This could include guidelines on who can donate and any new health checks that have been introduced.</p>
    </div>
    <img src="photo/life.jpg" class="card-img-top" alt="Éloise Dupont" style="width: 100%; height: 200px; object-fit: cover;">
</div>


<div class="card" style="width: 18rem; padding: 10px;">
   
    <div class="card-body">
        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:25px; padding-top:20px;">Emergency Blood Drive: Addressing Critical Shortages</p>
        <p class="card-text" style="text-align: justify;">Create urgency by reporting on critical blood shortages in the region or country and encourage people to donate in response. Emphasize the immediate need and how one donation can save up to three lives.</p>
    </div>
    <img src="photo/life1.png" class="card-img-top" alt="Éloise Dupont" style="width: 100%; height: 200px; object-fit: cover;">
</div>
</div>
</div>
</body>
</html>