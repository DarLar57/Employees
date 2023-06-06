<?php

namespace App\Models;

abstract class Person
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    public array $address;
    protected string $townOrVillage;
    protected string $postCode;
    protected string $street;
    protected string $number;
    protected string $pesel;
    protected string $birthDate;
    protected string $sex;
    protected Address $addressObj;
    protected Pesel $peselObj;
}