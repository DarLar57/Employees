<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Models\DbOperations;
use \Models\Depiction\Employee;
use \Models\ValidatePesel;
use \Models\Middleware\AddEmployeeMiddleware;
use \Models\Middleware\UpdateEmployeeMiddleware;

//read employees
$app->get('/employees', function (Request $request, Response $response, $args) {
    $dbObj = new DbOperations($this->db);
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employees.php", ["employees" => $employees, "router" => $this->router]);
    $this->logger->addInfo("Employee list");

    return $response;
});

//delete employee
$app->post('/employees', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);

    $dbObj = new DbOperations($this->db);

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    return $response;
})->setName('employee-delete');

//reading - new employee view where new employee's details are input
$app->get('/employee/new', function (Request $request, Response $response) {
    $dbObj = new DbOperations($this->db);

    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employeeadd.php", ["employees" => $employees, "router" => $this->router]);
    
    $this->logger->addInfo("get the site for Employee adding");

});

//to create new employee
$app->post('/employee/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $employee_data = [];
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);

    $employee_address[0] = htmlspecialchars($data['street']);
    $employee_address[1] = htmlspecialchars($data['number']);
    $employee_address[2] = htmlspecialchars($data['post_code']);
    $employee_address[3] = htmlspecialchars($data['town_or_village']);

    $employee_data['address'] = $employee_address;
    $employee_data['pesel'] = htmlspecialchars($data['pesel']);

    $validatePeselObj = new ValidatePesel ($employee_data['pesel']);

    $this->logger->addInfo("Employee adding");
    
    //validating if pesel is correct
    if ($validatePeselObj->validatePesel($employee_data['pesel'])) {

        $employee = new Employee($employee_data);

        $dbObj = new DbOperations($this->db);

        // checking if pesel is in db with 'isNewPeselRegistered' fun.
        // inside the 'save' fun. of 'DbOperations' class
        
        if (!$dbObj->isNewPeselRegistered($employee)) {
            $dbObj->save($employee);
            return $response = $response->withHeader('Location','/employee/new/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
        } else { 
            return $response = $response->withHeader('Location','/error/already registerred');
        } 
    } return $response = $response->withHeader('Location','/error/invalid');
 
});

//to update employee
$app->post('/employee/update', function (Request $request, Response $response) {
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

        $dbObj = new DbOperations($this->db);

        // checking if pesel is in db with 'isUpdatePeselRegistered' fun.
        // inside the 'modify' fun. of 'DbOperations' class
        
        if (!$dbObj->isUpdatePeselRegistered($employee)) {
            $dbObj->modify($employee);
            return $response = $response->withHeader('Location','/employee/update/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
        } else { 
            return $response = $response->withHeader('Location','/error/already registerred');
        } 
    } return $response = $response->withHeader('Location','/error/invalid');
 
});

//getting selected employee for updating
$app->get('/employee/{id}', function (Request $request, Response $response, $args) {
    $employee_id = (int)$args['id'];

    $dbObj = new DbOperations($this->db);
    
    $employee = $dbObj->getEmployeeById($employee_id);
    $response = $this->view->render($response, "employeemodify.php", ["employee" => $employee, "router" => $this->router]);

    $this->logger->addInfo("getting Employee site to update");

    return $response;
})->setName('employee-modify');

//read employees after inserting new employee
$app->get('/employee/new/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $firstName = $args['first_name'];
    $lastName = $args['last_name'];

    $dbObj = new DbOperations($this->db);
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employees.php", ["employees" => $employees, "first_name" => $firstName, "last_name" => $lastName, "router" => $this->router]);

    return $response;
})->add(new AddEmployeeMiddleware);

//deleting employee after inserting new employee
$app->post('/employee/new/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);

    $dbObj = new DbOperations($this->db);

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    return $response;
})->setName('employee-delete')->add(new AddEmployeeMiddleware);

//read employees after updating new employee
$app->get('/employee/update/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $firstName = $args['first_name'];
    $lastName = $args['last_name'];

    $dbObj = new DbOperations($this->db);
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employees.php", ["employees" => $employees, "first_name" => $firstName, "last_name" => $lastName, "router" => $this->router]);

    return $response;
})->add(new UpdateEmployeeMiddleware);

//deleting employee after updating new employee
$app->post('/employee/update/{first_name}/{last_name}', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);

    $dbObj = new DbOperations($this->db);

    $employee = $dbObj->getEmployeeById($employee_id);
    $dbObj->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    return $response;
})->setName('employee-delete')->add(new UpdateEmployeeMiddleware);

//getting error message dependant on kind of error
$app->get('/error/{txt}', function (Request $request, Response $response, $args) {
    $txt = $args['txt'];
    $response = $this->view->render($response, "error.php", ["txt" => $txt, "router" => $this->router]);

    return $response;
});