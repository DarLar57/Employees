<?php

include __DIR__ . '/../common/header.php';

?>

<body class="bg-warning">
    <div class="row">  
        <header class="container text-center bg-primary text-white pb-4 p-3 fs-1">
            Details of Employee
        </header>
    </div>
    <div class="row p-4">
        <div>
            <button type="button" class="btn btn-success"><a style="text-decoration: none; color: white;" href="/employee/new">Add new employee</a></button>
        </div>
        <div class="row p-5">
        <form id="item_list" method="POST">
        <table class="table table-striped table-hover m-3 p-5">
            <tr>
                <th>ID</th>    
                <th>First Name</th>
                <th>Last Name</th>
                <th>Town/Village</th>
                <th>Post-Code</th>
                <th>Street</th>
                <th>Building/Flat</th>
                <th>PESEL</th>
                <th>Birth date</th>
                <th>Sex</th>
            </tr>
            <tr>
                <td><?=$employee->getID() ?></td>
                <td><?=$employee->getFirstName() ?></td>
                <td><?=$employee->getLastName() ?></td>
                <td><?=$employee->getTownOrVillage() ?></td>
                <td><?=$employee->getPostCode() ?></td>
                <td><?=$employee->getStreet() ?></td>
                <td><?=$employee->getNumber() ?></td>
                <td><?=$employee->getPesel() ?></td>
                <td><?=$employee->getBirthDate() ?></td>
                <td><?=$employee->getSex() ?></td>
    </table>
</form>
        </div>
    </div>

<?php

include __DIR__ . '/../common/footer.php';

?>