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
    // Check if the PESEL number consists of 11 digits

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

    controlSum = 10 - (controlSum).substr(-1);

    // Compare the calculated control sum with the last digit of the PESEL
    return (controlSum == digits[10]);
}

function validatePeselAndDisplay() {
    var peselInput = document.getElementById('pesel');
    var pesel = peselInput.value;
    var peselIsValid = validatePesel(pesel);
    
    var validationLabel = document.getElementById('PeselLabel');
    if (peselIsValid) {
        validationLabel.textContent = 'PESEL is valid.' + peselIsValid.toString();
        validationLabel.style.color = 'green';
    } else {
        validationLabel.textContent = 'PESEL is invalid.' + peselIsValid.toString();
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

/*
function changeGet() {
    $("#item_list").attr('method', 'get');
}
*/
/*
$(document).ready(function($) {
    $(document).on('submit', '#delete_btn', function(event) {
      event.preventDefault();
    
      alert('page did not reload');
    });
  });

  $( "a" ).on( "click", function( event ) {
    event.preventDefault();
    $( "<div>" )
      .append( "default " + event.type + " prevented" )
      .appendTo( "#log" );
  });
  */
  /*function changeMethodAndSubmit(event) {
    event.preventDefault(); // Prevent the form from submitting
    
    var form = document.getElementById("item_list");
    form.method = "delete"; // Change the form's method attribute to GET
    alert('page did not reload');
    // Now you can perform any additional processing or validation before submitting the form
    // ...

    form.submit();
  }
  */