<?php
class Database
{
    private $host = "localhost";
    private $dbname = "task_system";
    private $username = "root";
    private $password = "";

    public $conn;

    public function connect()
    {
        if ($this->conn == null) {
            $this->conn = new PDO(
                "mysql:host=$this->host;
                port=3308;dbname=$this->dbname;
                charset=utf8",
                $this->username,
                $this->password
);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->conn;
    }
}