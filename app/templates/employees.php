<?php

include __DIR__ . '/../common/header.php';

?>

<body class="bg-warning">
    <div class="row">  
        <header class="container text-center bg-primary text-white pb-4 p-3 fs-1">
            List of Employees
        </header>
    </div>
    <div class="row p-4">
        <div>
            <button type="button" class="btn btn-success" oninput="checkInputs()"><a style="text-decoration: none; color: white;" href="/employee/new">Add new employee</a></button>
        </div>
        <div class="row p-5">
        <form id="item_list" method="post">
        <div class="row">
        <div class="col-md-4">
        <input id="inputFilter" type="text" class="form-control mb-3" placeholder="Search for text in any colum...">
        </div>
        </div>
        <table class="table table-striped table-hover m-3 p-2">
            <tr class="table-row">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>PESEL</th>
                <th>Birth date</th>
                <th>Sex</th>
                <th>
                <button type="submit" id="deleteButton" class="btn btn-danger" id="delete_btn" disabled>delete</button>
                </th>    
            </tr>
<?php foreach ($employees as $employee)  { $i = 0 ?>
            <tbody id="table_report">
            <tr>
                <td><?=$employee->getFirstName() ?></td>
                <td><?=$employee->getLastName() ?></td>
                <td><?=$employee->getAddress() ?></td>
                <td><?=$employee->getPesel() ?></td>
                <td><?=$employee->getBirthDate() ?></td>
                <td><?=$employee->getSex() ?></td>
                <td>
                <input type="radio" class="ms-4" name="selection" id="<?= $employee->getId() ?>" value="<?= $employee->getId() ?>" onchange="checkRadioSelection()">
                </td>
                <td>
                <button type="" class="btn btn-secondary"><a href="<?=$router->pathFor('employee-modify', ['id' => $employee->getId()])?>">Modify</a></button>

                </td>
            </tr>

<?php }; ?>
            </tbody>
        </table>
</form>
        </div>
    </div>
<?php

include __DIR__ . '/../common/footer.php';

?>