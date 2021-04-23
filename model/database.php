<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: database.php

// Heroku Database
/*
class Database
{
    
    private static $dsn = 'mysql:host=eyw6324oty5fsovx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=vcyg3k2dtgc3aho1';
    private static $username = 'tml1m5szwewyaurs';
    private static $password = 'zest7r9uexe2wgvt';
    private static $db;

    private function __construct()
    {
        //empty on purpose
    }

    public static function getDB()
    {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(
                    self::$dsn,
                    self::$username,
                    self::$password
                );
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('../errors/database_error.php');
                exit();
            }
        }
        return self::$db;
    }
}
*/

// Local Database
class Database
{
    // Local Database
    private static $db;

    private function __construct()
    {
        //empty on purpose
    }

    public static function getDB()
    {
        try {
            self::$db = new PDO('mysql:host=localhost;dbname=restapi', 'root');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            include('./view/error.php');
            exit();
        }
        return self::$db;
    }
    
}

?>