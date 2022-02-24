<?php
namespace Winnipass\Wfx\App;

use PDO;
use PDOException;

class Database {

    private string $host;

    private string $database;

    private string $user;

    private string $password;

    private string $dsn;

    private $connection;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->database = $_ENV['DB_DATABASE'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dsn = "mysql:host={$this->host};dbname={$this->database};charset=UTF8";
    }

    protected function connect(): PDO 
    {
        try {

            if ($this->connection) {
                return $this->connection;
            }

            return $this->connection = new PDO($this->dsn, $this->user, $this->password);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function __destruct()
    {
        unset($this->connection);
    }
}