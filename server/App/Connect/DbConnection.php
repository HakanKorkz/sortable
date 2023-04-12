<?php

namespace Korkz\Server\App\Connect;
use PDO;
use PDOException;

class DbConnection {
    private PDO|null $conn;
    private string $host = 'localhost';
    private string $user = 'username';
    private string $pass = 'password';
    private string $dbname = 'database_name';

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function connect(): PDO {
        return $this->conn;
    }

    public function __destruct() {
        $this->conn = null;
    }
}
