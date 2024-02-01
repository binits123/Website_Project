

function navigate(url){
    window.location.href = url;
}
function validateForm1() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Simple validation: Check if fields are not empty
    if ( email === '' || password === '' ) {
      alert('Please fill out all fields');
      return false; // Prevent the form from submitting
    }
    // If the form passes validation, it will be submitted
    return true;
  }

  function validateForm2() {
    var firstName = document.getElementById('firstName').value;
    var lastName = document.getElementById('lastName').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var address = document.getElementById('address').value;
    var phone_number = document.getElementById('phone_number').value;
    
  
    // Simple validation: Check if fields are not empty
    if (firstName === '' || lastName === '' || email === '' || password === '' || confirmPassword === '' || address === '' || phone_number === '') {
      alert('Please fill out all fields');
      return false; // Prevent the form from submitting
    }
     // If the form passes validation, it will be submitted
     return true;
}
