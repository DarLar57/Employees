<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Models\DbOperations;
use \Models\Employee;
use \Models\ValidatePesel;

$app->get('/employees', function (Request $request, Response $response)
{
    $mapper = new DbOperations($this->db);
    $employees = $mapper->getEmployees();
    $response = $this->view->render($response, "employees.php", ["employees" => $employees, "router" => $this->router]);
    $this->logger->addInfo("Employee list");

    return $response;
});

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

$app->get('/employee/new', function (Request $request, Response $response)
{
    $mapper = new DbOperations($this->db);

    $employees = $mapper->getEmployees();
    $response = $this->view->render($response, "employeeadd.php", ["employees" => $employees, "router" => $this->router]);
    
    $this->logger->addInfo("get the site for Employee adding");

    return $response;
});

$app->post('/employee/new', function (Request $request, Response $response)
{
    $data = $request->getParsedBody();

    $employee_data = [];
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);

    $employee_address = [];
    $employee_address['street'] = htmlspecialchars($data['street']);
    $employee_address['number'] = htmlspecialchars($data['number']);
    $employee_address['post_code'] = htmlspecialchars($data['post_code']);
    $employee_address['town_or_village'] = htmlspecialchars($data['town_or_village']);

    $employee_data['address'] = $employee_address;
    $employee_data['pesel'] = htmlspecialchars($data['pesel']);

    $validatePesel = new ValidatePesel ($employee_data['pesel']);

    $this->logger->addInfo("Employee adding");
    
    if ($validatePesel->validatePesel($employee_data['pesel'])) {

        $employee = new Employee($employee_data);

        $employee_mapper = new DbOperations($this->db);

        $employee_mapper->save($employee);
        $response = $response->withHeader('Location','/employees');
        
        return $response;
    } else { 
        return $this->view->render($response, "error.php", ["router" => $this->router]);
    }
});

$app->post('/employee/update', function (Request $request, Response $response)
{
    $data = $request->getParsedBody();

    $employee_data = [];
    $employee_data['id'] = $data['id'];
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);

    $employee_address = [];
    $employee_address['street'] = htmlspecialchars($data['street']);
    $employee_address['number'] = htmlspecialchars($data['number']);
    $employee_address['post_code'] = htmlspecialchars($data['post_code']);
    $employee_address['town_or_village'] = htmlspecialchars($data['town_or_village']);

    $employee_data['address'] = $employee_address;
    $employee_data['pesel'] = htmlspecialchars($data['pesel']);

    $validatePesel = new ValidatePesel ($employee_data['pesel']);

    $this->logger->addInfo("Employee updating");

    if ($validatePesel->validatePesel($employee_data['pesel'])) {

        $employee = new Employee($employee_data);

        $employee_mapper = new DbOperations($this->db);
        $employee_mapper->modify($employee);
    
        $response = $response->withHeader('Location','/employees');
    
        return $response;
    } else {
        return $this->view->render($response, "error.php", ["router" => $this->router]);
    }
});

$app->get('/employee/{id}', function (Request $request, Response $response, $args)
{
    $employee_id = (int)$args['id'];

    $mapper = new DbOperations($this->db);
    
    $employee = $mapper->getEmployeeById($employee_id);
    $response = $this->view->render($response, "employeemodify.php", ["employee" => $employee, "router" => $this->router]);

    $this->logger->addInfo("getting Employee site to update");

    return $response;
})->setName('employee-modify');
