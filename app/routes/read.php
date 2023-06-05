<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Models\Middleware\AddEmployeeMiddleware;
use \Models\Middleware\UpdateEmployeeMiddleware;
use \Models\Middleware\DeleteEmployeeMiddleware;

//read employees
$app->get('/employees', function (Request $request, Response $response, $args) {

    $dbObj = $this->get('dbObj');
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employeesReadDelete.php", ["employees" => $employees, "router" => $this->router]);
    $this->logger->addInfo("Employee list");

    return $response;
});

//reading - new employee view where new employee's details are input
$app->get('/employees/new', function (Request $request, Response $response) {
    $dbObj = $this->get('dbObj');

    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employeeAdd.php", ["employees" => $employees, "router" => $this->router]);
    
    $this->logger->addInfo("get the site for Employee adding");
});

//getting selected employee for updating
$app->get('/employees/{id}', function (Request $request, Response $response, $args) {
    
    $employee_id = (int)$args['id'];

    $dbObj = $this->get('dbObj');
    
    $employee = $dbObj->getEmployeeById($employee_id);
    $response = $this->view->render($response, "employeeUpdate.php", ["employee" => $employee, "router" => $this->router]);

    $this->logger->addInfo("getting Employee site to update");

    return $response;
})->setName('employee-modify');

//read employees after inserting new employee
$app->get('/employees/new/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $firstName = $args['first_name'];
    $lastName = $args['last_name'];

    $dbObj = $this->get('dbObj');
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employeesReadDelete.php", ["employees" => $employees, "first_name" => $firstName, "last_name" => $lastName, "router" => $this->router]);

    return $response;
})->add(new AddEmployeeMiddleware);

//read employees after updating new employee
$app->get('/employees/update/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $firstName = $args['first_name'];
    $lastName = $args['last_name'];

    $dbObj = $this->get('dbObj');
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employeesReadDelete.php", ["employees" => $employees, "first_name" => $firstName, "last_name" => $lastName, "router" => $this->router]);

    return $response;
})->add(new UpdateEmployeeMiddleware);

//read employees after deleting employee
$app->get('/employees/deleted/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    
    $firstName = $args['first_name'];
    $lastName = $args['last_name'];

    $dbObj = $this->get('dbObj');
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employeesReadDelete.php", ["employees" => $employees, "first_name" => $firstName, "last_name" => $lastName, "router" => $this->router]);

    return $response;
})->add(new DeleteEmployeeMiddleware);