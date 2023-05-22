<?php

class Employee
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $address;
    protected $pesel;
    protected $birthDate;
    protected $sex;

    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data) {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->address = $data['address'];
        $this->pesel = $data['pesel'];
        //$this->birthDate = $data['birthDate'];
        //$this->sex = $data['sex'];
    }

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPesel() {
        return $this->pesel;
    }

    public function getBirthDate() {
        $pesel = $this->getPesel();
        $birthDate = new BirthDate($pesel);
        return $birthDate->generateBirthDate($pesel); 
    }
    
    public function getSex() {
        $pesel = $this->getPesel();
        $sex = new Sex($pesel);
        return $sex->generateSex($pesel); 
    }
}
