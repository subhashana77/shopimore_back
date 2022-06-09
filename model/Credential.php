<?php

class Credential {
//    DB stuff
    private $conn;
    private $table = 'credential';

//    Credential Properties
    public $id_redentials;
    public $username;
    public $password;

//    Constructor with DB
    public function _construct($db) {
        $this->conn = $db;
    }

//    Get credentials
    public function read() {
//        Create query
        $query = 'SELECT id_redentials, username, password FROM ' . $this->table;

//        Prepare statement
        $stmt = $this->conn->prepare($query);

//        Execute query
        $stmt->execute();

        return $stmt;
    }
}