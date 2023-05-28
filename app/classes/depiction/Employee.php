<?php

namespace Models\Depiction;

use \Models\Person;
use Models\Depiction\Address;

class Employee extends Person
{
    public array $address;
    private Address $addressObj;
    private BirthDate $birthDateObj;
    private Sex $sexObj;
    private int $id;

    public function __construct(array $data) 
    {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }
        
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->pesel = $data['pesel'];
        $this->addressObj = new Address($data['address']);
        $this->birthDateObj = new BirthDate($this->pesel);
        $this->sexObj = new Sex($this->pesel);
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

    public function getBirthDate(): string
    {
        $pesel = $this->getPesel();
        $birthDate = $this->birthDateObj->generateBirthDate($pesel); 
        return $birthDate; 
    }
    
    public function getSex(): string
    {
        $pesel = $this->getPesel();
        $sex = $this->sexObj->generateSex($pesel); 
        return $sex; 
    }

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
