<?php

namespace Models;

class Sex
{
    protected string $pesel;
    protected string $sex;
    
    public function __construct($pesel)
    {
        $this->pesel = $pesel;
    }

    function generateSex($pesel): string
    {
        $peselArr = str_split($pesel);
        
        ((int)$peselArr[9] % 2) == 0 ? $sex = "female" : $sex = "male";
    
        return $sex;
    }
}
