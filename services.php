<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="css/design.css"> 
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>
<?php include("navbar.php"); ?> 
<div class="container-fluid p-0" style="padding-top: 30px">
    <div class="photo-lobby">
        <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/gsqMpUuz5SA?autoplay=1&mute=1&loop=1&playlist=gsqMpUuz5SA&enablejsapi=1"
                    title="Shrinking YouTube Video"
                    allow="autoplay; fullscreen"
                    allowfullscreen>
            </iframe>
        </div>
    </div>
</div>
<br><br>
<div data-aos="zoom-in-left">
<p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 70px; color:red;">
        <b>Care</b>
    </p>
<br><br>
<div class="container my-5">
  <div class="row align-items-center">

    <div class="col-md-6">
      <h1 style="text-align: justify; font-family: 'Open Sans', sans-serif; font-size: 50px;">
      Onboarding Programs
      </h1>
      <br>
      <p style="text-align: justify; font-family: 'Playfair Display', serif; font-size: 18px; padding-right:30px;">
      Hemo Vault is dedicated to promoting safety and preparedness by providing comprehensive First Aid training programs. 
      These sessions are designed to equip individuals, communities, and organizations with essential life-saving skills, empowering 
      them to respond confidently and effectively in emergency situations. Whether you are a concerned citizen, a workplace team
      , or a community volunteer, our training ensures you're ready to make a difference when it matters most. By offering accessible 
      and professional instruction, Hemo Vault continues its mission of building a more resilient and health-conscious society.
      </p>
    </div>


    <div class="col-md-6 text-center">
      <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="photo/training1.jpg" class="d-block w-100" alt="Donation Image 1">
          </div>
          <div class="carousel-item">
            <img src="photo/training3.jpg" class="d-block w-100" alt="Donation Image 2">
          </div>
          <div class="carousel-item">
            <img src="photo/training2.jpeg" class="d-block w-100" alt="Donation Image 3">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
</div>
</div>
<br><br>
<div data-aos="zoom-out">
<p style="text-align: center; font-family: Lora, serif; font-size: 22px;">
HemoVault is dedicated to promoting health, safety, and community well-being through its <br>unwavering commitment to service. 
From organizing blood donation drives to offering comprehensive first aid <br> and emergency response trainings, HemoVault strives
 to empower individuals and communities with the knowledge and support they need in times of  <br>need. Through volunteer initiatives
  and accessible assistance, the organization continues to be a trusted partner in saving lives and making a positive impact.
</p>
</div>
<br><br>
<div data-aos="fade-up"
     data-aos-duration="3000">

<p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 40px; color:red;">
        <b>For more information, <br> please feel free to reach out to us.</b>
    </p>
<div class="d-flex justify-content-center gap-3 flex-wrap" style="font-size: 20px;">

  <!-- Volunteer Services Card -->
  <div class="card" style="width: 18rem; padding: 10px; border: none;">
    <div class="card-body">
      <p class="card-text text-center" style="font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;">Volunteer Services</p>
      <p class="card-text text-center">
        Phone: (555) 456-7890<br>
        Landline: (555) 345-6789<br>
        volunteer@hemo-vault.org
      </p>
    </div>
    <img src="photo/volunteer.jpg" class="card-img-top" alt="Volunteer" style="width: 100%; height: 200px; object-fit: cover;">
  </div>

  <!-- General Inquiries Card -->
  <div class="card" style="width: 18rem; padding: 10px; border: none;">
    <div class="card-body">
      <p class="card-text text-center" style="font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;">General Inquiries</p>
      <p class="card-text text-center">
        Phone: (555) 678-9012<br>
        Landline: (555) 567-8901<br>
        info@hemo-vault.org
      </p>
    </div>
    <img src="photo/life.jpg" class="card-img-top" alt="General Inquiry" style="width: 100%; height: 200px; object-fit: cover;">
  </div>

</div>
</div>
    <br><br>
<?php include("footer.php"); ?> 
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
  AOS.init();
</script>
</body>
</html>