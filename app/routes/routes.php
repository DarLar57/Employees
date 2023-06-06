<?php

use App\Middleware\AddEmployeeMiddleware;
use App\Middleware\UpdateEmployeeMiddleware;
use App\Middleware\DeleteEmployeeMiddleware;

//read employees
$app->get('/employees', 'App\Controllers\Employees:readEmployees');

//reading - new employee view where new employee's details are input
$app->get('/employees/new', 'App\Controllers\Employees:readEmployeeNew');

//getting selected employee for updating
$app->get('/employees/{id}', 'App\Controllers\Employees:readEmployeeById')->setName('employee-modify');

//read employees after inserting new employee
$app->get('/employees/new/{first_name}/{last_name}', 'App\Controllers\Employees:readEmployeesAfterInsUpdDel')->add(new AddEmployeeMiddleware);

//read employees after updating new employee
$app->get('/employees/update/{first_name}/{last_name}', 'App\Controllers\Employees:readEmployeesAfterInsUpdDel')->add(new UpdateEmployeeMiddleware);

//read employees after deleting employee
$app->get('/employees/deleted/{first_name}/{last_name}', 'App\Controllers\Employees:readEmployeesAfterInsUpdDel')->add(new DeleteEmployeeMiddleware);

//to create new employee
$app->post('/employees/new', 'App\Controllers\Employees:addEmployees');

//to update employee
$app->post('/employees/update', 'App\Controllers\Employees:updateEmployees');

//delete employee
$app->post('/employees', 'App\Controllers\Employees:deleteEmployees');

//delete employee after prior other deletion
$app->post('/employees/deleted/{first_name}/{last_name}', 'App\Controllers\Employees:deleteEmployees');

//deleting employee after inserting new employee
$app->post('/employees/new/{first_name}/{last_name}', 'App\Controllers\Employees:deleteEmployees');

//deleting employee after updating new employee
$app->post('/employees/update/{first_name}/{last_name}', 'App\Controllers\Employees:deleteEmployees');

//getting error message dependant on kind of error
$app->get('/error/{txt}', 'App\Controllers\Employees:error');