<?php
// INF 653 Final Project Rest API
// Author: Craig Freeburg
// Date: 5/1/2021
// File: database.php

// Heroku Database

class Database
{
    
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
}
*/
?>