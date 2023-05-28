$(document).ready(function(){
  $("#inputFilter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table_report tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

function getLastDigit(number) {
  return number % 10;
}

function validatePesel(pesel) {
    // Extract the individual digits from the PESEL
    var digits = pesel.split('').map(Number);
    
    var controlSum = digits[0] * 1;
    controlSum += (digits[1] * 3) > 9 ? getLastDigit(digits[1] * 3) : (digits[1] * 3);
    controlSum += (digits[2] * 7) > 9 ? getLastDigit(digits[2] * 7) : (digits[2] * 7);
    controlSum += (digits[3] * 9) > 9 ? getLastDigit(digits[3] * 9) : (digits[3] * 9);
    controlSum += digits[4] * 1;
    controlSum += (digits[5] * 3) > 9 ? getLastDigit(digits[5] * 3) : (digits[5] * 3); 
    controlSum += (digits[6] * 7) > 9 ? getLastDigit(digits[6] * 7) : (digits[6] * 7); 
    controlSum += (digits[7] * 9) > 9 ? getLastDigit(digits[7] * 9) : (digits[7] * 9);
    controlSum += (digits[8] * 1); 
    controlSum += (digits[9] * 3) > 9 ? getLastDigit(digits[9] * 3) : (digits[9] * 3);

    controlSum = 10 - getLastDigit(controlSum);

    // Compare the calculated control sum with the last digit of the PESEL
    return (controlSum == digits[10]);
}

function validatePeselAndDisplay() {
    var peselInput = document.getElementById('pesel');
    var pesel = peselInput.value;
    var peselIsValid = validatePesel(pesel);
    
    var validationLabel = document.getElementById('PeselLabel');
    if (peselIsValid) {
        validationLabel.textContent = 'PESEL is valid.';
        validationLabel.style.color = 'green';
    } else {
        validationLabel.textContent = 'PESEL is invalid.';
        validationLabel.style.color = 'red';
    }
}

function changeColor(color) {
    var paragraph = document.getElementById('PeselLabel');
    paragraph.style.backgroundColor = color;
}

function checkRadioSelection() {
  var formRadio = document.querySelectorAll('form input[type="radio"]');
  var button = document.getElementById('deleteButton');
  var isRadioSelected = false;

  for (var i = 0; i < formRadio.length; i++) {
    if (formRadio[i].checked) {
      isRadioSelected = true;
      break;
    }
  }
  button.disabled = !isRadioSelected;
}
// for new employee submission
$(document).ready(function() {
  $('#new_employee_form').submit(function(event) {
    event.preventDefault(); // Prevent default form submission

    var formData = $(this).serialize();

    // AJAX request
    $.ajax({
      url: '/employee/new',
      type: 'POST',
      data: formData,
      success: function(response) {
        
        var peselInput = document.getElementById('pesel');
        var pesel = peselInput.value;

        if (validatePesel(pesel)) {
          window.location.href = '/employees';
        } 
      }
    });
  });
});