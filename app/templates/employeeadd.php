<?php

include __DIR__ . '/../common/header.php';

?>

<body class="bg-warning">
    <div class="row">  
        <header class="container text-center bg-primary text-white pb-3 p-2 fs-2">
            New Employee
        </header>
    </div>
    <div class="row p-4">
        
        <!-- AJAX to url: '/employee/new' -->
        <form id="new_employee_form" class="row g-3 was-validated" action='/employee/new' method="post">
            <div class="col-md-4">
                <label for="first_name" class="form-label">First name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="Adam" required pattern="[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\s]+$|[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$">
            </div>
            <div class="col-md-4">
                <label for="last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="Kula" required pattern="[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\s]+$|[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$">
            </div>
            <div class="row">
            <div class="col-md-4 ps-4 pt-4 pb-0">
            <fieldset>
                <legend>Address</legend>
                <label for="town_or_village">Town / Village</label><br>
                <input type="text" class="form-control" id="town_or_village" name="town_or_village" value="Warsaw" required pattern="[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\s]+$|[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$"><br>
                <label for="post_code">Post-code (xx-xxx)</label><br>
                <input type="text" class="form-control" id="post_code" name="post_code" value="12-345" required pattern="[0-9]{2}[-][0-9]{3}"><br>
                <label for="street">Street</label><br>
                <input type="text" class="form-control" id="street" name="street" value="Akacjowa" required><br>
                <label for="number">Number (building / apartment)</label><br>
                <input type="text" class="form-control" id="number" name="number" value="1/2" required><br><br>
            </fieldset>
            </div>
            </div>
            <div class="col-md-4">
                <label id="PeselLabel" for="pesel" class="form-label">PESEL (11 digits)</label>
                <input type="text" class="form-control" name="pesel" id="pesel" value="65030311274" onchange="validatePeselAndDisplay()" onkeyup="validatePeselAndDisplay()" required pattern="[0-9]{11}">
            </div>
            <div class="col-12">
                <button class="btn btn-success" id="submit_new" type="submit">Submit form</button>
            </div>
            <div class="col-12 mt-3 ps-5">
                <button  class="btn btn-primary btn-lg" type="submit"><a href=\employees>Employee List</button>
            </div>
        </form>
    </div>

<?php

include __DIR__ . '/../common/footer.php';

?>

