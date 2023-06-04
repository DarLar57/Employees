<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Models\Depiction\Employee;
use \Models\ValidatePesel;

//to update employee
$app->post('/employees/update', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $employee_data = [];
    $employee_data['id'] = $data['id'];
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);

    $employee_address[0] = htmlspecialchars($data['street']);
    $employee_address[1] = htmlspecialchars($data['number']);
    $employee_address[2] = htmlspecialchars($data['post_code']);
    $employee_address[3] = htmlspecialchars($data['town_or_village']);

    $employee_data['address'] = $employee_address;
    $employee_data['pesel'] = htmlspecialchars($data['pesel']);

    $validatePeselObj = new ValidatePesel ($employee_data['pesel']);

    $this->logger->addInfo("Employee updating");

    //validating if pesel is correct
    if ($validatePeselObj->validatePesel($employee_data['pesel'])) {

        $employee = new Employee($employee_data);

        $dbObj = $this->get('dbObj');

        // checking if pesel is in db with 'isUpdatePeselRegistered' fun.
        // inside the 'modify' fun. of 'DbOperations' class
        
        if (!$dbObj->isUpdatePeselRegistered($employee)) {
            $dbObj->modify($employee);
            return $response = $response->withHeader('Location','/employees/update/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
        } else { 
            return $response = $response->withHeader('Location','/error/already registerred');
        } 
    }
    
    $response = $response->withHeader('Location','/error/invalid');
    return $response;
});