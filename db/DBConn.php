<?php
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*';
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: ' . $origin);
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Headers: origin, Content-Type, accept, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {exit();}

class DBConn {
    private $servername;
    private $username;
    private $password;
    private $dbname;

    private $conn;

    public function __construct() {
        try {
            $this->servername = 'localhost';
            $this->username = 'root';
            $this->password = '';
            $this->dbname = 'dilshan_slmart';

            $this->conn = new PDO (
                "mysql:host = $this->servername; dbname=$this->dbname",
                $this->username, $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw $exception;
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}