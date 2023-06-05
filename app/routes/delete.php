<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//delete employee
$app->post('/employees', function (Request $request, Response $response) {
    
    $data = $request->getParsedBody();

    $employee_id = htmlspecialchars($data['selectionId']);
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);

    $dbObj = $this->get('dbObj');

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    
    $this->logger->addInfo("Employee deleted");

    $response = $response->withHeader('Location','/employees/deleted/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
    
    return $response;

});

//delete employee after prior other deletion
$app->post('/employees/deleted/{first_name}/{last_name}', function (Request $request, Response $response) {
    
    $data = $request->getParsedBody();

    $employee_id = htmlspecialchars($data['selectionId']);

    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);

    $dbObj = $this->get('dbObj');

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    
    $this->logger->addInfo("Employee deleted");

    $response = $response->withHeader('Location','/employees/deleted/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
    
    return $response;

});

//deleting employee after inserting new employee
$app->post('/employees/new/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();

    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);
    
    $employee_id = htmlspecialchars($data['selectionId']);

    $dbObj = $this->get('dbObj');

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    $response = $response->withHeader('Location','/employees/deleted/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
    
    return $response;
});

//deleting employee after updating new employee
$app->post('/employees/update/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);

    $employee_id = htmlspecialchars($data['selectionId']);

    $dbObj = $this->get('dbObj');

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    $response = $response->withHeader('Location','/employees/deleted/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);

    return $response;
});