<?php

declare(strict_types= 1);

namespace App;

use PDO;

class Database {
    private $host = 'db';
    private $dbname = 'my_db';
    private $username = 'root';
    private $password = 'root';

    public $con = null;

    public function getConnection(): mixed {
        try {
            $this->con = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, 'root', []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }

        return $this->con;
    }
}