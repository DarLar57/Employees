<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/employees', function (Request $request, Response $response) {
    $this->logger->addInfo("Employee list");
    $mapper = new EmployeeMapper($this->db);
    $employees = $mapper->getEmployees();

    $response = $this->view->render($response, "employees.phtml", ["employees" => $employees, "router" => $this->router]);
    return $response;
});

$app->get('/employee/new', function (Request $request, Response $response) {
    $mapper = new EmployeeMapper($this->db);
    $employees = $mapper->getEmployees();
    $response = $this->view->render($response, "employeeadd.phtml", ["employees" => $employees, "router" => $this->router]);
    return $response;
});

$app->post('/employee/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $employee_data = [];
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);
    $employee_address = [];
    $employee_address['street'] = htmlspecialchars($data['street']);
    $employee_address['number'] = htmlspecialchars($data['number']);
    $employee_address['post_code'] = htmlspecialchars($data['post_code']);
    $employee_address['town_or_village'] = htmlspecialchars($data['town_or_village']);
    //$employeeAddress = new Address ($employee_address);
    $employee_data['address'] = $employee_address;
    $employee_data['pesel'] = htmlspecialchars($data['pesel']);

    $validatePesel = new ValidatePesel ($employee_data['pesel']);
    if ($validatePesel->validatePesel($employee_data['pesel'])) {
        $employee = new Employee($employee_data);
        $employee_mapper = new EmployeeMapper($this->db);
        $employee_mapper->save($employee);
        $response = $response->withRedirect('/employees');
        return $response;
    } else 
        return $response->withRedirect('/employee/new');
});

$app->get('/employee/{id}', function (Request $request, Response $response, $args) {
    $employee_id = (int)$args['id'];
    $mapper = new EmployeeMapper($this->db);
    $employee = $mapper->getEmployeeById($employee_id);
    $response = $this->view->render($response, "employeemodify.phtml", ["employee" => $employee, "router" => $this->router]);
    return $response;
})->setName('employee-modify');

/*
$app->get('/employee/{id}', function (Request $request, Response $response, $args) {
    $employee_id = (int)$args['id'];
    $mapper = new EmployeeMapper($this->db);
    $employee = $mapper->getEmployeeById($employee_id);
    $response = $this->view->render($response, "employeedetail.phtml", ["employee" => $employee, "router" => $this->router]);
    return $response;
})->setName('employee-detail');
*/

$app->post('/employees', function (Request $request, Response $response) {
   
    $data = $request->getParsedBody();
    $this->logger->addInfo("Employee deleted");
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);
    $mapper = new EmployeeMapper($this->db);
    $employee = $mapper->getEmployeeById($employee_id);
    $mapper->delete($employee);
    $response = $response->withRedirect('/employees');
    return $response;
})->setName('employee-delete');

/*
$app->post('/employees', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $this->logger->addInfo("Employee deleted");
    $employee_id = [];
    $employee_id = htmlspecialchars($data['selection']);
    $mapper = new EmployeeMapper($this->db);
    $employee = $mapper->getEmployeeById($employee_id);
    $mapper->modify($employee);
    $response = $response->withRedirect('/employees');
    return $response;
})->setName('employee-modify');
*/
