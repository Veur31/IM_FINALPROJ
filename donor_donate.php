<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Donor Donate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<?php include("donor_navbar.php"); ?>

<div class="container d-flex align-items-center justify-content-center" style="padding-top:120px; max-width: 800px;">
  <div class="card shadow-lg rounded-4 mt-1 w-100">
    <div class="card-body p-3">
      <h2 class="card-title text-center mb-4">Donor Information</h2>

      <form method="POST" action="donor_process.php">
        <div class="row">

          <div class="col-md-6">
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" required/>
            </div>

            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select" id="gender" name="gender">
                <option selected disabled>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="birth_date" class="form-label">Birth Date</label>
              <input type="date" class="form-control" id="birth_date" name="birth_date"/>
            </div>

            <div class="mb-3">
              <label for="age" class="form-label">Age</label>
              <input type="text" class="form-control" id="age" name="age" readonly/>
              <div id="age-warning" class="text-danger mt-1" style="display: none;">
                Donors must be between 16 and 65 years old.
              </div>
            </div>

            <div class="mb-3">
              <label for="blood_type" class="form-label">Blood Type</label>
              <input type="text" class="form-control" id="blood_type" name="blood_type" placeholder="e.g., A+, O-, AB+" required/>
            </div>
          </div>

 
          <div class="col-md-6">
            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone"/>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email"/>
            </div>

            <div class="mb-3">
              <label for="last_donation_date" class="form-label">Last Donation Date</label>
              <input type="date" class="form-control" id="last_donation_date" name="last_donation_date"/>
                <div id="donation-warning" class="text-danger mt-1" style="display: none;">
                  You must wait at least 56 days between donations.
                </div>

            </div>
          </div>
        </div>

        <button type="submit" id="submitBtn" class="btn btn-danger w-100">Submit</button>
      </form>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/design1.js"></script>

</body>
</html>
