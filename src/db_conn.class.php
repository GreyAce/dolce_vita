<?php

namespace DB\Connection;

use mysqli;
use PDO;
use DB\Connection\DB_connection_interface as DB_connection_interface;

class DB_connection implements DB_connection_interface
{
    private $db_host;
    private $db_password;
    private $db_username;
    private $db_name;
    private $db_connection;
    public function __construct()
    {
        $this->db_host = $_ENV['DB_HOST'];
        $this->db_password = $_ENV['DB_PASSWORD'];
        $this->db_username = $_ENV['DB_USERNAME'];
        $this->db_name = $_ENV['DB_NAME'];
    }

    public function connect()
    {

        $strPdoConnection = "mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($strPdoConnection, $this->db_username, $this->db_password, $options);
            $this->pdo = $pdo;
            return $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
