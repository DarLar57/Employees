<?php

namespace Models;

class Employee
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected array $address;

    protected string $townOrVillage;
    protected string $postCode;
    protected string $street;
    protected string $number;
    protected string $pesel;
    protected string $birthDate;
    protected string $sex;


    public function __construct(array $data) 
    {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->address = $data['address'];
        $this->pesel = $data['pesel'];
        $this->street = $data['address']['street'] ?? $data['address'][0];
        $this->number = $data['address']['number'] ?? $data['address'][1];
        $this->postCode = $data['address']['post_code'] ?? $data['address'][2];
        $this->townOrVillage = $data['address']['town_or_village'] ?? $data['address'][3];      
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

    public function getAddress(): string 
    {
        $addressString = preg_replace('/,/', ' ', implode(", ", $this->address), 0);
        return $addressString;
    }

    public function getTownOrVillage(): string 
    {
        return $this->townOrVillage;
    }

    public function getPostCode(): string
     {
        return $this->postCode;
    }

    public function getPesel(): string
    {
        return $this->pesel;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getBirthDate(): string
    {
        $pesel = $this->getPesel();
        $birthDate = new BirthDate($pesel);
        return $birthDate->generateBirthDate($pesel); 
    }
    
    public function getSex(): string
    {
        $pesel = $this->getPesel();
        $sex = new Sex($pesel);
        return $sex->generateSex($pesel); 
    }
}
