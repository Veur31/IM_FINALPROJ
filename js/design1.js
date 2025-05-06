const birthDateInput = document.getElementById('birth_date');
const ageInput = document.getElementById('age');
const ageWarning = document.getElementById('age-warning');
const donationInput = document.getElementById('last_donation_date');
const donationWarning = document.getElementById('donation-warning');
const submitBtn = document.getElementById('submitBtn');
const bloodTypeInput = document.getElementById('blood_type');

// Function to check the age based on birth date
function checkAge() {
  const birthDate = new Date(birthDateInput.value);
  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const month = today.getMonth() - birthDate.getMonth();
  
  if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }

  if (age >= 16 && age <= 65) {
    ageInput.value = age;
    ageWarning.style.display = 'none';
    return true;
  } else {
    ageInput.value = '';
    ageWarning.style.display = 'block';
    return false;
  }
}

// Function to check if the last donation date is valid (at least 56 days ago)
function checkDonationDate() {
  const donationDate = new Date(donationInput.value);
  const today = new Date();
  const duration = (today - donationDate) / (1000 * 60 * 60 * 24);

  if (duration < 56) {
    donationWarning.style.display = 'block';
    return false;
  } else {
    donationWarning.style.display = 'none';
    return true;
  }
}

// Function to validate the blood type
function isValidBloodType(bloodType) {
  const bloodTypePattern = /^(A|B|AB|O)[+-]$/i; // Regular expression for valid blood types
  return bloodTypePattern.test(bloodType);
}

// Event listener to update the submit button state
function updateButtonState() {
  const validAge = checkAge();
  const validDonation = checkDonationDate();
  const validBloodType = isValidBloodType(bloodTypeInput.value.trim());

  // Disable the submit button if any condition is false
  submitBtn.disabled = !(validAge && validDonation && validBloodType);
}

// Event listeners for changes in input fields
birthDateInput.addEventListener('change', updateButtonState);
donationInput.addEventListener('change', updateButtonState);
bloodTypeInput.addEventListener('input', updateButtonState);

// Initial check when the page loads
updateButtonState();
