<?php

namespace App\Models;

class ValidatePesel
{
    public string $pesel;
    
    public function __construct(string $pesel)
    {
        $this->pesel = $pesel;
    }

    private function getLastDigit($number): int
    {
        return $number % 10;
    }

    //validating if pesel is a valid number
    function validatePesel($pesel): bool
    {
        // Check if the PESEL number is 11 digits
        if (!preg_match('/^[0-9]{11}$/', $pesel)) {
            return false;
        }
    
        $digits = str_split($pesel);
    
        // Control based on the PESEL digits and control weights
        $controlSum = $digits[0] * 1;
        $controlSum += (($digits[1] * 3) > 9 ? $this->getLastDigit(($digits[1] * 3)) : ($digits[1] * 3));
        $controlSum += (($digits[2] * 7) > 9 ? $this->getLastDigit(($digits[2] * 7)) : ($digits[2] * 7));
        $controlSum += (($digits[3] * 9) > 9 ? $this->getLastDigit(($digits[3] * 9)) : ($digits[3] * 9));
        $controlSum += ($digits[4] * 1);
        $controlSum += (($digits[5] * 3) > 9 ? $this->getLastDigit(($digits[5] * 3)) : ($digits[5] * 3));
        $controlSum += (($digits[6] * 7) > 9 ? $this->getLastDigit(($digits[6] * 7)) : ($digits[6] * 7));
        $controlSum += (($digits[7] * 9) > 9 ? $this->getLastDigit(($digits[7] * 9)) : ($digits[7] * 9));
        $controlSum += ($digits[8] * 1);
        $controlSum += (($digits[9] * 3) > 9 ? $this->getLastDigit(($digits[9] * 3)) : ($digits[9] * 3));
        
        $controlSum = 10 - $this->getLastDigit($controlSum);

        return ($controlSum == $digits[10]);
    }
}