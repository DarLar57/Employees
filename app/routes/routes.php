<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Models\DbOperations;
use \Models\Depiction\Employee;
use \Models\ValidatePesel;

//read employees
$app->get('/employees', function (Request $request, Response $response)
{
    $dbObj = new DbOperations($this->db);
    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employees.php", ["employees" => $employees, "router" => $this->router]);
    $this->logger->addInfo("Employee list");

    return $response;
});

//delete employee
$app->post('/employees', function (Request $request, Response $response)
{
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
$app->get('/employee/new', function (Request $request, Response $response)
{
    $dbObj = new DbOperations($this->db);

    $employees = $dbObj->getEmployees();
    $response = $this->view->render($response, "employeeadd.php", ["employees" => $employees, "router" => $this->router]);
    
    $this->logger->addInfo("get the site for Employee adding");

    return $response;
});

//for creating new employee
$app->post('/employee/new', function (Request $request, Response $response)
{
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

        // checking if pesel is in db is 'isNewPeselRegistered' fun.
        // inside the 'save' fun. of 'DbOperations' class
        $dbObj->save($employee);
        $response = $response->withHeader('Location','/employees');
        
        return $response;
    } else { 
        return $this->view->render($response, "error.php", ["router" => $this->router]);
    }
});

//for updating employee
$app->post('/employee/update', function (Request $request, Response $response)
{
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

        // checking if pesel (other than the one of the updated employee) is in db is
        // in 'isUpdatePeselRegistered' fun. inside the 'modify' fun. of 'DbOperations' class
        $dbObj->modify($employee);
    
        $response = $response->withHeader('Location','/employees');
    
        return $response;
    } else {
        return $this->view->render($response, "error.php", ["router" => $this->router]);
    }
});

//getting a selected employee for updating
$app->get('/employee/{id}', function (Request $request, Response $response, $args)
{
    $employee_id = (int)$args['id'];

    $dbObj = new DbOperations($this->db);
    
    $employee = $dbObj->getEmployeeById($employee_id);
    $response = $this->view->render($response, "employeemodify.php", ["employee" => $employee, "router" => $this->router]);

    $this->logger->addInfo("getting Employee site to update");

    return $response;
})->setName('employee-modify');
