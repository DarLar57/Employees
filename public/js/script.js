//searching any string (input in the form ) from the table 
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

//check if a pesel is valid number
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

//display if pesel is / is not valid
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


$(document).ready(function(){
  // Get the form
  const form = document.getElementById('item_list');
  // Add ev. listener to the form
  form.addEventListener('submit', function(event) {
    // Check radio button selection
    if (!isRadioButtonSelected()) {
      event.preventDefault(); // Prevent submission
    }
    });
  });
  // Check radio button selection
function isRadioButtonSelected() {
  var formRadio = document.querySelectorAll('form input[type="radio"]');
    for (let i = 0; i < formRadio.length; i++) {
      if (formRadio[i].checked) {
        return true;
      }
    }
    return false;
  }

// AJAX - for new employee's data submission
$(document).ready(function() {
  $('#new_employee_form').submit(function(event) {
    event.preventDefault(); // Prevent default form submission

    var formData = $(this).serialize();

    // AJAX request
    $.ajax({
      url: '/employee/new',
      type: 'POST',
      data: formData,
      success: function() {
        
        var peselInput = document.getElementById('pesel');
        var pesel = peselInput.value;

        if (validatePesel(pesel)) {
          window.location.href = '/employees';
        } 
      }
    });
  });
});