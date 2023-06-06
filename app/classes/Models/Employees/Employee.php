<?php

namespace App\Models\Employees;

use \App\Models\Person;
use \App\Models\Pesel;
use \App\Models\Address;

class Employee extends Person
{
    public function __construct(array $data) 
    {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }
        
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->pesel = $data['pesel'];
        $this->address = $data['address'];

        $this->addressObj = new Address($data['address']);
        $this->peselObj = new Pesel($this->pesel);
    }

    public function getId(): int 
    {
        return $this->id;
    }

    public function getFirstName(): string 
    {
        return $this->firstName;
    }

    public function getLastName(): string 
    {
        return $this->lastName;
    }

    public function getPesel(): string
    {
        return $this->pesel;
    }

    //getting birth date using BirthDate class
    public function getBirthDate(): string
    {
        $this->birthDate = $this->peselObj->generateBirthDate($this->pesel);

        return $this->birthDate; 
    }
    
    //getting sex using Sex class
    public function getSex(): string
    {
        $this->sex = $this->peselObj->generateSex($this->pesel);
        return $this->sex; 
    }
    
    //getting full Address using Address class
    public function getAddress(): string
    {
        $address = $this->addressObj->generateAddressString();
        return $address;
    }

    public function getTownOrVillage(): string 
    {
        $TownOrVillage = $this->addressObj->getTownOrVillage();
        return $TownOrVillage;        
    }

    public function getPostCode(): string
    {
        $postCode = $this->addressObj->getpostCode();
        return $postCode;  
    }

    public function getStreet(): string
    {
        $street = $this->addressObj->getStreet();
        return $street;  
    }

    public function getNumber(): string
    {
        $number = $this->addressObj->getNumber();
        return $number;
    }
}
