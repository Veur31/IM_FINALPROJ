const birthDateInput = document.getElementById('birth_date');
const birthDateInput1 = document.getElementById('birth_date1');
const ageInput1 = document.getElementById('age1');
const ageInput = document.getElementById('age');
const ageWarning = document.getElementById('age-warning');
const donationInput = document.getElementById('last_donation_date');
const donationWarning = document.getElementById('donation-warning');
const submitBtn = document.getElementById('submitBtn');
const bloodTypeInput = document.getElementById('blood_type');


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
function checkAge1() {
  const birthDate1 = new Date(birthDateInput1.value);
  const today = new Date();
  let age = today.getFullYear() - birthDate1.getFullYear();
  const month = today.getMonth() - birthDate1.getMonth();
  
  if (month < 0 || (month === 0 && today.getDate() < birthDate1.getDate())) {
    age--;
  }


    ageInput1.value = age;


}
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


function isValidBloodType(bloodType) {
  const bloodTypePattern = /^(A|B|AB|O)[+-]$/i;
  return bloodTypePattern.test(bloodType);
}


function updateButtonState() {
  const validAge = checkAge();
  const validDonation = checkDonationDate();
  const validBloodType = isValidBloodType(bloodTypeInput.value.trim());


  submitBtn.disabled = !(validAge && validDonation && validBloodType);
}

birthDateInput.addEventListener('change', updateButtonState);
donationInput.addEventListener('change', updateButtonState);
bloodTypeInput.addEventListener('input', updateButtonState);


updateButtonState();

