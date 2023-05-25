<?php

namespace Models;

use PDO;

class DB
{
    public static $pdo;
    public const DB_HO = "localhost";
    public const DB_US = "root";
    public const DB_PS = "";
    public const DB_NA = "iwq";
    
    public static function getPDO(): PDO
    {
        DB::$pdo = new PDO("mysql:host=" . DB::DB_HO . ";dbname=" . DB::DB_NA,
        DB::DB_US, DB::DB_PS);
        DB::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        DB::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return DB::$pdo;
    }
}