<?php

include __DIR__ . '/../common/header.php';

?>

<body class="bg-warning">
    <div class="row">  
        <header class="container text-center bg-primary text-white pb-3 p-2 fs-2">
            List of Employees
        </header>
    </div>
    <div id="table_employees_container" class="row p-4">
        <div>
            <button type="button" class="btn btn-success"><a style="text-decoration: none; color: white;" href="/employee/new">Add new employee</a></button>
        </div>
        <div id="form_employees_container">
        <div class="row">
        <div class="col-md-4">
        <input id="inputFilter" type="text" class="form-control mb-3" placeholder="Search for text in any colum...">
        </div>
        </div>
            <form id="item_list" method="post">
        <table id="table_employees" class="table table-striped table-hover m-3 p-2">
            <tr class="table-row">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>PESEL</th>
                <th>Birth date</th>
                <th>Sex</th>
                <th>
                <button type="submit" id="deleteButton" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Please select" id="delete_btn">delete</button>
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
                <input type="radio" class="ms-4" name="selection" id="<?= $employee->getId() ?>" value="<?= $employee->getId() ?>">
                </td>
                <td>
                <button class="btn btn-secondary"><a href="<?=$router->pathFor('employee-modify', ['id' => $employee->getId()])?>" data-toggle="tooltip" data-placement="top" title="Selection not needed">Modify</a></button>

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