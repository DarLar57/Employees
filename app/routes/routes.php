<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Models\DbOperations;
use \Models\Depiction\Employee;
use \Models\ValidatePesel;

//read employees
$app->get('/employees', function (Request $request, Response $response)
{
    $mapper = new DbOperations($this->db);
    $employees = $mapper->getEmployees();
    $response = $this->view->render($response, "employees.php", ["employees" => $employees, "router" => $this->router]);
    $this->logger->addInfo("Employee list");

    return $response;
});

//delete employees
$app->post('/employees', function (Request $request, Response $response)
{
    $data = $request->getParsedBody();
    
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);

    $mapper = new DbOperations($this->db);

    $employee = $mapper->getEmployeeById($employee_id);
    $mapper->delete($employee);
    $response = $response->withHeader('Location','/employees');
    $this->logger->addInfo("Employee deleted");

    return $response;
})->setName('employee-delete');

//reading - new employee view where new employee's details are input
$app->get('/employee/new', function (Request $request, Response $response)
{
    $mapper = new DbOperations($this->db);

    $employees = $mapper->getEmployees();
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

    $validatePesel = new ValidatePesel ($employee_data['pesel']);

    $this->logger->addInfo("Employee adding");
    
    //validating if pesel is correct
    if ($validatePesel->validatePesel($employee_data['pesel'])) {

        $employee = new Employee($employee_data);

        $employee_db = new DbOperations($this->db);

        $employee_db->save($employee);
        $response = $response->withHeader('Location','/employees');
        
        return $response;
    } else { 
        return $this->view->render($response, "error.php", ["router" => $this->router]);
    }
});

//for updating new employee
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

    $validatePesel = new ValidatePesel ($employee_data['pesel']);

    $this->logger->addInfo("Employee updating");

    //validating if pesel is correct
    if ($validatePesel->validatePesel($employee_data['pesel'])) {

        $employee = new Employee($employee_data);

        $employee_db = new DbOperations($this->db);
        $employee_db->modify($employee);
    
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

    $mapper = new DbOperations($this->db);
    
    $employee = $mapper->getEmployeeById($employee_id);
    $response = $this->view->render($response, "employeemodify.php", ["employee" => $employee, "router" => $this->router]);

    $this->logger->addInfo("getting Employee site to update");

    return $response;
})->setName('employee-modify');
