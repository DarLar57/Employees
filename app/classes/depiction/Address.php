<?php

namespace Models\Depiction;

use \Models\Person;

class Address extends Person
{    
    public array $address;
    public function __construct(array $address)
    {
        $this->address = $address;
        $this->street = $address[0];
        $this->number = $address[1];
        $this->postCode = $address[2];
        $this->townOrVillage = $address[3];
    }

    //generating full address from address elements
    public function generateAddressString(): string
    {
        $address = implode(", ", $this->address);
        return $address;
    }

    public function getTownOrVillage(): string 
    {
        return $this->townOrVillage;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
