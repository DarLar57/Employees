<?php

class Employee
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected array $address;
    //public Address $employeeAddress;
    protected $townOrVillage;
    protected $postCode;
    protected $street;
    protected $number;
    protected $pesel;
    protected $birthDate;
    protected $sex;

    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data /*, Address $employeeAddress*/) {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->address = $data['address'];
        $this->pesel = $data['pesel'];
        $this->street = $data['address'][0];
        $this->number = $data['address'][1];
        $this->postCode = $data['address'][2];
        $this->townOrVillage = $data['address'][3];      
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
        $addressString = preg_replace('/,/', ' ', implode(", ", $this->address), 0);
        return $addressString;
    }

    public function getTownOrVillage() {
        return $this->townOrVillage;
    }

    public function getPostCode() {
        return $this->postCode;
    }

    public function getPesel() {
        return $this->pesel;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getNumber() {
        return $this->number;
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
