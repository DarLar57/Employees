<?php

namespace Models;

use \Models\Depiction\Employee;

class DbOperations
{
protected mixed $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //getting all Employees
    public function getEmployees(): array
    {
        $sql = "SELECT id, first_name, last_name, address, pesel
            from employees
            ORDER by id ASC";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            //creating array from address col. (street, number, code, town)
            $row['address'] = explode(",", $row['address']);
            $results[] = new Employee($row);
        }
        return $results;
    }

    //getting Employee by ID
    public function getEmployeeById($employee_id): ?Employee
    {
        $sql = "SELECT id, first_name, last_name, address, pesel
        from employees
            where id = :employee_id";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["employee_id" => $employee_id]);

        if($result) {
            $row = $stmt->fetch();
            //creating array from address col. (street, number, code, town)
            $row['address'] = explode(",", $row['address']);
                      
            return new Employee($row);
        } else {
            return null;
        }
    }

    //inserting an employee
    public function save(Employee $employee): void
    {
        if (!$this->isNewPeselRegistered($employee)) {
            $sql = "insert into employees
                (first_name, last_name, address, pesel) values
                (:first_name, :last_name, :address, :pesel)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                "first_name" => $employee->getFirstName(),
                "last_name" => $employee->getLastName(),
                "address" => $employee->getAddress(),
                "pesel" => $employee->getPesel(),
                ]);
       } else {
            header('Location: /employee/new');
       }
    }

    //deleting an employee
    public function delete($employee): void
    {
        $employee_id = $employee->getId();
        $sql = "DELETE from employees
            where id = :employee_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(["employee_id" => $employee_id]);
    }

    //updating an employee ny ID
    public function modify(Employee $employee): void
    {
        if (!$this->isUpdatePeselRegistered($employee)) {
            $sql = "update employees
            set 
                first_name = :first_name,
                last_name = :last_name, 
                address = :address,
                pesel = :pesel
            where 
                id = :employee_id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                "first_name" => $employee->getFirstName(),
                "last_name" => $employee->getLastName(),
                "address" => $employee->getAddress(),
                "pesel" => $employee->getPesel(),
                "employee_id" => $employee->getId(),
        ]); 
        } else {
        header('Location: /employee/update');
        }
    }

    //check if pesel is in db for a new employee
    public function isNewPeselRegistered($employee): bool
    {
        $sql = "SELECT * FROM employees
            WHERE (pesel = :pesel)";

        $stmt = $this->db->prepare($sql);
        $pesel = $employee->getPesel();
        
        $stmt->execute(["pesel" => $pesel]);

        if (($stmt->rowCount()) > 0) {
            return true;
        } else {
            return false;
        }
    }

    //check if a new pesel is in db for an employee to be updated
    //to allow modification
    public function isUpdatePeselRegistered($employee): bool
    {
        $sql = "SELECT * FROM employees
            WHERE ((pesel = :pesel) AND (id <> :id))";

        $stmt = $this->db->prepare($sql);
        $pesel = $employee->getPesel();
        $id = $employee->getId();
        $stmt->execute(["pesel" => $pesel, "id" => $id]);

        if (($stmt->rowCount()) > 0) {
            return true;
        } else {
            return false;
        }
    }    
}