<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//delete employee
$app->post('/employees', function (Request $request, Response $response) {
    
    $data = $request->getParsedBody();

    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);

    $dbObj = $this->get('dbObj');

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);

    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    return $response;
});

//deleting employee after inserting new employee
$app->post('/employees/new/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);

    $dbObj = $this->get('dbObj');

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    return $response;
});

//deleting employee after updating new employee
$app->post('/employees/update/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);

    $dbObj = $this->get('dbObj');

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    return $response;
});