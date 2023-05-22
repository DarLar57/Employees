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
    $response = $this->view->render($response, "employeeadd.html", ["employees" => $employees, "router" => $this->router]);
    return $response;
});

$app->post('/employee/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $employee_data = [];
    $employee_data['first_name'] = htmlspecialchars($data['first_name']);
    $employee_data['last_name'] = htmlspecialchars($data['last_name']);
    $employee_data['address'] = htmlspecialchars($data['address']);
    $employee_data['pesel'] = htmlspecialchars($data['pesel']);

    $employee = new Employee($employee_data);
    $employee_mapper = new EmployeeMapper($this->db);
    $employee_mapper->save($employee);

    $response = $response->withRedirect('/employees');
    return $response;
});

$app->get('/employee/{id}', function (Request $request, Response $response, $args) {
    $employee_id = (int)$args['id'];
    $mapper = new EmployeeMapper($this->db);
    $employee = $mapper->getEmployeeById($employee_id);

    $response = $this->view->render($response, "employeedetail.phtml", ["employee" => $employee, "router" => $this->router]);
    return $response;
})->setName('employee-detail');