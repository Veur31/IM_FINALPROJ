<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Now</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/design.css"> 
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 

</head>
<body>
    <?php include("navbar.php"); ?> 



    <div class="container-fluid p-0" style="padding-top: 30px">
        <div class="photo-lobby">
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/P4oIsJQKFc0?autoplay=1&mute=1&loop=1&playlist=P4oIsJQKFc0&enablejsapi=1"
                        title="Blood Donation Form in PHP MySQL"
                        allow="autoplay; fullscreen"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
    <br><br>

    <div data-aos="fade-down">
    <p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 70px; color:red;">
        <b>Make a Donation</b>
    </p>


    <div class="container">
        <div class="row justify-content-center gap-3">

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card" style="border: none;">
                    <div class="card-body">
                        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;">
                            How Often Can You Donate?
                        </p>
                        <p class="card-text" style="text-align: center;">Whole blood: Every 56 days (about every 2 months) for healthy adults.</p>
                        <button class="btn btn-danger mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#donation">
                            Learn more
                        </button>
                        <div class="collapse" id="donation">
                            <div class="card card-body">
                                <ul>
                                    <li>You can donate whole blood every <strong>56 days</strong>.</li>
                                    <li>Platelet donations are allowed every <strong>7 days</strong>, up to 24 times a year.</li>
                                    <li>One donation can save up to <strong>3 lives</strong>.</li>
                                    <li>O-negative blood is the <strong>universal donor</strong>.</li>
                                    <li>You must be in <strong>good health</strong> and weigh at least 50 kg.</li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                    <img src="photo/welfare.jpg" class="card-img-top img-fluid" alt="Éloise Dupont">
                </div>
            </div>


            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card" style="border: none;">
                    <div class="card-body">
                        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;">Quick Facts About Blood Donation</p>
                        <p class="card-text" style="text-align: center;">1 donation can save up to 3 lives</p>
                        <button class="btn btn-danger mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#quick1">
                            Learn more
                        </button>
                        <div class="collapse" id="quick1">
                            <div class="card card-body">
                                <ul>
                                    <li>1 donation can save up to <strong> 3 lives</strong>.</li>
                                    <li>The process takes about <strong>8–10 minutes</strong>, but the whole visit is around 45 minutes.</li>
                                    <li><strong>O-negative</strong> is the universal donor — vital in emergencies.</li>
                                    <li><strong>AB plasma</strong>is universal for plasma transfusions.</li>
                                    <li><strong>Blood can’t be manufactured</strong> — it only comes from volunteers.</li>
                                    <li>You can <strong>eat and drink normally </strong>  before donating, but avoid fatty foods.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <img src="photo/donate.jpg" class="card-img-top img-fluid" alt="Éloise Dupont">
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card" style="border: none;">
                    <div class="card-body">
                        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;"> General Requirements</p>
                        <p class="card-text" style="text-align: center;">Weigh at least 110 lbs (50 kg)</p>
                        <button class="btn btn-danger mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#facts">
                            Learn more
                        </button>
                        <div class="collapse" id="facts">
                            <div class="card card-body">
                                <ul>
                                    <li>Must be at least <strong>16–18 years old</strong>(depending on your country).</li>
                                    <li>Weigh at least<strong>110 lbs</strong>(50 kg).</li>
                                    <li>Be in<strong> good general health</strong>.</li>

                                    <li>Must pass a basic screening<strong>(hemoglobin levels, blood pressure, etc.)</strong>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <img src="photo/volunteer.jpg" class="card-img-top img-fluid" alt="Éloise Dupont">
                </div>
            </div>
        </div>
    </div>

    </div>
    <br><br>
    <div data-aos="fade-right">
    <p style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 60px; color:red;"><b>Additional Requirements</b></p>
    <div class="container">
        <div class="row justify-content-center gap-3 mt-4">

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card" style="border: none;">
                    <div class="card-body">
                        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;">No recent illness or fever</p>
                        <p class="card-text" style="text-align: center;">You should be feeling healthy with no cold, flu, or fever for at least 48 hours before donating blood.</p>
                    </div>
                    <img src="photo/emergency.png" class="card-img-top img-fluid" alt="Éloise Dupont">
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card" style="border: none;">
                    <div class="card-body">
                        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;">Must not be pregnant</p>
                        <p class="card-text" style="text-align: center;">Pregnant women are typically advised not to donate blood to avoid strain on their health.</p>
                    </div>
                    <img src="photo/life.jpg" class="card-img-top img-fluid" alt="Éloise Dupont">
                </div>
            </div>


            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card" style="border: none;">
                    <div class="card-body">
                        <p class="card-text" style="text-align: center; font-family: 'Playfair Display', serif; font-size:35px; padding-top:20px;">Adequate iron levels</p>
                        <p class="card-text" style="text-align: center;">Your iron levels are checked before donation. If they're too low, you may need to wait until they're back to normal.</p>
                    </div>
                    <img src="photo/life1.png" class="card-img-top img-fluid" alt="Éloise Dupont">
                </div>
            </div>
        </div>
    </div>
    <p style="text-align: center; font-family: Lora, serif; font-size: 30px;">

    
  <a href="register.php">
  <button class="btn btn-danger" style="font-size: 25px;">Donate</button>
</a>
</div>
</p>
<br><br>
<div data-aos="fade-left">
    <p style="text-align: center; font-family: Lora, serif; font-size: 30px; color:red;"><b>"Thank you for being a lifeline."</b>
    <br><br> </p>
    </div>
    <?php include("footer.php"); ?> 


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
  AOS.init();
</script>
</body>
</html>
