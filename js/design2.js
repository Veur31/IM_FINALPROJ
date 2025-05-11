
const submitBtn = document.getElementById('submitBtn');
const bloodTypeInput = document.getElementById('blood_type');


function isValidBloodType(bloodType) {
  const bloodTypePattern = /^(A|B|AB|O)[+-]$/i;
  return bloodTypePattern.test(bloodType);
}


function updateButtonState() {
  const validBloodType = isValidBloodType(bloodTypeInput.value.trim());


  submitBtn.disabled = !(validBloodType);
}


bloodTypeInput.addEventListener('input', updateButtonState);


updateButtonState();
