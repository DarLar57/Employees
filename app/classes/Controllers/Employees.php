<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use App\Models\Employees\Employee;
use App\Models\ValidatePesel;

class Employees
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
       $this->container = $container;
    }
    
    //to create new employee
    public function addEmployees($request, $response)
    {
        // your code
        // to access items in the container... $this->container->get('');

        $data = $request->getParsedBody();

        $employee_data['first_name'] = htmlspecialchars($data['first_name']);
        $employee_data['last_name'] = htmlspecialchars($data['last_name']);
        
        $employee_address[0] = htmlspecialchars($data['street']);
        $employee_address[1] = htmlspecialchars($data['number']);
        $employee_address[2] = htmlspecialchars($data['post_code']);
        $employee_address[3] = htmlspecialchars($data['town_or_village']);
        
        $employee_data['address'] = $employee_address;
        $employee_data['pesel'] = htmlspecialchars($data['pesel']);
        
        $validatePeselObj = new ValidatePesel ($employee_data['pesel']);
        
        $this->container->get('logger')->addInfo("Employee adding");
        
        //validating if pesel is correct
        if ($validatePeselObj->validatePesel($employee_data['pesel'])) {
        
            $employee = new Employee($employee_data);
        
            $dbObj = $this->container->get('dbObj');
        
            // checking if pesel is in db with 'isNewPeselRegistered' fun.
            // inside the 'saveEmployee' fun. of 'DbOperations' class
            
            if (!$dbObj->isNewPeselRegistered($employee)) {
                
                $dbObj->saveEmployee($employee);

                return $response->withHeader('Location','/employees/new/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
            } else { 
                return $response->withHeader('Location','/error/already registerred');
            } 
        }  return $response->withHeader('Location','/error/invalid');
    }

    //delete employee
    public function deleteEmployees($request, $response)
    {
        $data = $request->getParsedBody();

        $employee_id = htmlspecialchars($data['selectionId']);

        $employee_data['first_name'] = htmlspecialchars($data['first_name']);
        $employee_data['last_name'] = htmlspecialchars($data['last_name']);

        $dbObj = $this->container->get('dbObj');

        $employee = $dbObj->getEmployeeById($employee_id);
        
        $dbObj->deleteEmployee($employee);
        
        $this->container->get('logger')->addInfo("Employee deleted");

        $response = $response->withHeader('Location','/employees/deleted/' . $employee_data['first_name'] . '/' . $employee_data['last_name']);
    
        return $response;
    }

    //getting error message dependant on kind of error
    public function error($request, $response, $args)
    {
        $txt = $args['txt'];
        
        $response = $this->container->get('view')->render($response, "error.php", ["txt" => $txt, "router" => $this->container->get('router')]);

        return $response;
    }

    //read employees
    public function readEmployees($request, $response, $args)
    {
        $dbObj = $this->container->get('dbObj');
        
        $employees = $dbObj->getEmployees();
        
        $response = $this->container->get('view')->render($response, "employeesReadDelete.php", ["employees" => $employees, "router" => $this->container->get('router')]);
        
        $this->container->get('logger')->addInfo("Employee list");
    
        return $response;
    }
    //reading - new employee view where new employee's details are input
    public function readEmployeeNew($request, $response)
    {
        $dbObj = $this->container->get('dbObj');
        
        $employees = $dbObj->getEmployees();
        
        $response = $this->container->get('view')->render($response, "employeeAdd.php", ["employees" => $employees, "router" => $this->container->get('router')]);
        
        $this->container->get('logger')->addInfo("get the site for Employee adding");
    
        return $response;
    }

    //getting selected employee for updating
    public function readEmployeeById($request, $response, $args)
    {
        $dbObj = $this->container->get('dbObj');
        
        $employee_id = (int)$args['id'];
        
        $employee = $dbObj->getEmployeeById($employee_id);
        
        $response = $this->container->get('view')->render($response, "employeeUpdate.php", ["employee" => $employee, "router" => $this->container->get('router')]);
        $this->container->get('logger')->addInfo("getting Employee site to update");
    
        return $response;
    }

    //read employees after inserting, updating and deleting new employee
    public function readEmployeesAfterInsUpdDel($request, $response, $args)
    {
        $firstName = $args['first_name'];
        $lastName = $args['last_name'];
    
        $dbObj = $this->container->get('dbObj');
        
        $employees = $dbObj->getEmployees();
        
        $response = $this->container->get('view')->render($response, "employeesReadDelete.php", ["employees" => $employees, "first_name" => $firstName, "last_name" => $lastName, "router" => $this->container->get('router')]);
    
        return $response;
    }

    //to update employee
    public function updateEmployees($request, $response)
    {
        $data = $request->getParsedBody();
    
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
    
        $this->container->get('logger')->addInfo("Employee updating");
    
        //validating if pesel is correct
        if ($validatePeselObj->validatePesel($employee_data['pesel'])) {
    
            $employee = new Employee($employee_data);
    
            $dbObj = $this->container->get('dbObj');
    
            // checking if pesel is in db with 'isUpdatePeselRegistered' fun.
            // inside the 'modifyEmployee' fun. of 'DbOperations' class
            
            if (!$dbObj->isUpdatePeselRegistered($employee)) {
                $dbObj->modifyEmployee($employee);
                return $response->withHeader('Location','/employees/update/' . $employee_data    ['first_name'] . '/' . $employee_data['last_name']);
            } else { 
                return $response->withHeader('Location','/error/already registerred');
            } 
        }

        return $response->withHeader('Location','/error/invalid');
    }
}