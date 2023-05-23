$(document).ready(function(){
  $("#inputFilter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table_report tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

function validatePesel(pesel) {
    // Check if the PESEL number consists of 11 digits
    if (!/^\d{11}$/.test(pesel)) {
        return false;
    }

    // Extract the individual digits from the PESEL
    var digits = pesel.split('').map(Number);

    // Calculate the control sum based on the PESEL digits and control weights
    var controlSum = (digits[0] * 1 + digits[1] * 3 + digits[2] * 7 + digits[3] * 9 +
                      digits[4] * 1 + digits[5] * 3 + digits[6] * 7 + digits[7] * 9 +
                      digits[8] * 1 + digits[9] * 3) % 10;

    // Compare the calculated control sum with the last digit of the PESEL
    return controlSum === digits[10];
}

function validateAndDisplay() {
    var peselInput = document.getElementById('pesel');
    var pesel = peselInput.value;
    var peselIsValid = validatePesel(pesel);
    
    var validationLabel = document.getElementById('validationLabel');
    if (peselIsValid) {
        validationLabel.textContent = 'PESEL is valid.';
        validationLabel.style.color = 'green';
    } else {
        validationLabel.textContent = 'PESEL is invalid.';
        validationLabel.style.color = 'red';
    }
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