<?php

namespace Services;

use PDO;

class DBService
{

    protected $hostAddress;
    protected $dbName;
    protected $username;
    protected $password;
    protected $pdo;
    protected $conn;

    public function __construct(string $hostAddress, string $dbName, string $username, string $password)
    {
        $this->hostAddress = $hostAddress;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
    }


    protected function connect()
    {
        try {
            $this->pdo = new PDO(sprintf('mysql:host=%s;dbname=%s', $this->hostAddress, $this->dbName), $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (\PDOException $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    /**
     * @return array|PDO
     */
    public function getConnection()
    {
        if (!$this->conn) {
            $this->conn = $this->connect();
        }
        return $this->conn;
    }
}
