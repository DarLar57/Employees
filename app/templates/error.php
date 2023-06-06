<?php

include __DIR__ . '/common/header.php'; 

?>

        <header class="container text-center bg-primary text-white pb-3 p-2 fs-2">
            Employee
        </header>
    </div>
   <div id="errorMessage" class="pt-5 mt-5 fs-1 text-center text-danger">PESEL is <?= $txt ?> !
   </div>
   <div class="col-12 mt-5 ps-5">
        <button class="btn btn-primary btn-lg"><a href='\employees'>Employee List</button>
  </div>
<?php

include __DIR__ . '/common/footer.php';

?>