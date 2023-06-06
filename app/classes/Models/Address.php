<?php

namespace App\Models;

class Address
{   private string $townOrVillage;
    private string $postCode;
    private string $street;
    private string $number;
    private array $address;
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

    public function getAddressArr(): array
    {
        return $this->address;
    }

    public function getTownOrVillage(): string 
    {
        return ltrim($this->townOrVillage);
    }

    public function getPostCode(): string
    {
        return ltrim($this->postCode);
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): string
    {
        return ltrim($this->number);
    }
}
