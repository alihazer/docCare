<?php

namespace Config;

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'aliali1';
    private $dbname = 'doccare';
    private static $instance = null;
    private $con;

    // Private constructor to prevent external instantiation
    public function __construct()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
        if (!$this->con) {
            echo "Connection failed";
        }
    }

    // Public method to get the instance of the Database class
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Public method to get the database connection
    public function getConnection()
    {
        return $this->con;
    }
}
