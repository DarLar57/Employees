<?php

class Address
{
    protected $townOrVillage;
    protected $postCode;
    protected $street;
    protected $buildingNumber;
    protected $apartmentNumber;

    public function __construct(array $data) {

        $this->townOrVillage = $data['town_or_village'];
        $this->postCode = $data['post_code'];
        $this->street = $data['street'];
        $this->buildingNumber = $data['building_number'];
        $this->apartmentNumber = $data['apartment_number'];
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

    public function getBuildingNumber() {
        return $this->buildingNumber;
    }

    public function getApartmentNumber() {
        return $this->apartmentNumber;
    }
}
