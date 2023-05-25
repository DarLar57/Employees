<?php

namespace Models;

class Address
{
    protected $townOrVillage;
    protected $postCode;
    protected $street;
    protected $number;

    public function __construct(array $data) {

        $this->townOrVillage = $data['town_or_village'];
        $this->postCode = $data['post_code'];
        $this->street = $data['street'];
        $this->number = $data['number'];
    }

    public function getTownOrVillage() {
        return $this->townOrVillage;
    }

    public function getPostCode() {
        return $this->postCode;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getNumber() {
        return $this->number;
    }
}
