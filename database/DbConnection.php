<?php

namespace Database;
use PDO, PDOException;
require_once 'dbSettings.php';

class DbConnection
{
    public $dbConnection;
    
    public function __construct()
    {
        $this->dbConnection = $this->connectToDatabase();
    }

    private function connectToDatabase()
    {
        $servername = DB_SERVER_NAME;
        $dbName = DB_NAME;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "Connected successfully";
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
    
    //The method to close the database connection instance after we are done using it.
    public function closeDbConnection(){
        $this->dbConnection = null;
        echo 'connection closed';
    }
}