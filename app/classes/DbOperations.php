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

    public function getEmployees(): array
    {
        $sql = "SELECT id, first_name, last_name, address, pesel
            from employees";
            
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $row['address'] = explode(",", $row['address']);
            $results[] = new Employee($row);
        }
        return $results;
    }

    public function getEmployeeById($employee_id): ?Employee
    {
        $sql = "SELECT id, first_name, last_name, address, pesel
        from employees
            where id = :employee_id";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["employee_id" => $employee_id]);

        if($result) {
            $row = $stmt->fetch();
            $row['address'] = explode(",", $row['address']);
                      
            return new Employee($row);
        } else {
            return null;
        }
    }

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

    public function delete($employee): void
    {
        $employee_id = $employee->getId();
        $sql = "DELETE from employees
            where id = :employee_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(["employee_id" => $employee_id]);
    }

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