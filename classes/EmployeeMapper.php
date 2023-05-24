<?php

class EmployeeMapper extends Mapper
{
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

    public function getEmployeeById($employee_id)
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
        }
    }

    public function save(Employee $employee): void
    {
        $sql = "insert into employees
            (first_name, last_name, address, pesel) values
            (:first_name, :last_name, :address, :pesel)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "first_name" => $employee->getFirstName(),
            "last_name" => $employee->getLastName(),
            "address" => $employee->getAddress(),
            "pesel" => $employee->getPesel(),
        ]);

        if(!$result) {
            throw new Exception("could not save record");
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
        $sql = "update employees
            set 
                first_name = :first_name,
                last_name = :last_name, 
                address = 'ab, cd, ef, gf',
                pesel = :pesel
            where id = :employee_id";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "first_name" => $employee->getFirstName(),
            "last_name" => $employee->getLastName(),
            "address" => $employee->getAddress(),
            "pesel" => $employee->getPesel(),
            "employee_id" => $employee->getId(),
        ]);

        if(!$result) {
            throw new Exception("could not modify record");
        }
    }
}