<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: database.php

// Heroku Database

class Database
{
    //mysql://tml1m5szwewyaurs:zest7r9uexe2wgvt@eyw6324oty5fsovx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/vcyg3k2dtgc3aho1
    //private static $dsn = 'mysql:host=eyw6324oty5fsovx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=vcyg3k2dtgc3aho1';
    //private static $username = 'tml1m5szwewyaurs';
    //private static $password = 'zest7r9uexe2wgvt';
    //private static $db;
    /*
    private function __construct()
    {
        //empty on purpose
    }
    */
    public function connect()
    {
        $url = getenv('JAWSDB_URL');
        $dbparts = parse_url($url);

        $hostname = $dbparts['host'];
        $username = $dbparts['user'];
        $password = $dbparts['pass'];
        $database = ltrim($dbparts['path'],'/');
        $dsn = "mysql:host={$hostname};dbname={$database}";

        try
        {
            echo $hostname;
            echo $username;
            echo $password;
            echo $database;
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo 'Connection Failed: ' . $e->getMessage();
        }

        return $this->conn;
    }
}


/*
// Local Database
class Database
{
    // DB Params
    private $host = 'localhost';
    private $db_name = 'restapi';
    private $username = 'root';
    //private $password = '123456';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try
        {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
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
*/ 
?>