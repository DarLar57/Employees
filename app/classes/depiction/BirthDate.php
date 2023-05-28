<?php

namespace Models\Depiction;

use \DateTime;
use \Models\Person;

class BirthDate extends Person
{    
    public function __construct(string $pesel)
    {
        $this->pesel = $pesel;
    }

    public function generateBirthDate($pesel): string 
    {
        // Extract birth date information from PESEL
        $year = substr($pesel, 0, 2);
        $month = substr($pesel, 2, 2);
        $day = substr($pesel, 4, 2);

        // Determine the century based on the month
        $century = ($month > 80) ? '18' : (($month > 60) ? '22' : (($month > 40) ? '21' : (($month > 20) ? '20' : '19')));
    
        switch ($century) {
            case '18':
                $monthAmended = $month - 80;
                break;
            case '19':    
                $monthAmended = $month;
                break;
            case '20':
                $monthAmended = $month - 20;
                break;
            case '21':
                $monthAmended = $month - 40;
                break;
            case '22':
                $monthAmended = $month - 60;
                break;
        }
        // Construct the full birth date
        $birthDate = $year . $monthAmended . $day;
    
        // Create a DateTime object from the birth date
        $dateTime = DateTime::createFromFormat('Ymd', $century . $birthDate);
    
        // Format the birth date as desired
        $formattedDate = $dateTime->format('Y-m-d');
    
        return $formattedDate;
    }
}
