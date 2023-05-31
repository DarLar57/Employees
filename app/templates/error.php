<?php

include __DIR__ . '/../common/header.php';

?>

<body class="bg-warning">
    <div class="row">  
        <header class="container text-center bg-primary text-white pb-3 p-2 fs-2">
            Employee
        </header>
    </div>
   <div id="errorMessage" class="pt-5 mt-5 fs-1 text-center text-danger">Wrong PESEL
   </div>
   <div class="col-12 mt-5 ps-5">
        <button class="btn btn-primary btn-lg"><a href=\employees>Employee List</button>
        
   </div>
   <div class="col-12 mt-5 ps-5">
   <button type="button" class="btn btn-primary btn-lg" onclick="goBack()">Go back</button>
   </div>
<?php

include __DIR__ . '/../common/footer.php';

?>
