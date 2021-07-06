<?php

namespace DB;

use PDO;
use PDOException;
use DB\Connection\DB_connection;

class Create_Tables
{
    private $connection;

    public function __construct()
    {
        $db_connection = new DB_connection();
        $this->db = $db_connection->connect();
    }


    public function create_tasks_table()
    {
        $db = $this->db;

        $table = "tasks";
        try {

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Error Handling
            $sql = "CREATE table IF NOT EXISTS $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(120) NOT NULL,
                status VARCHAR(120) NOT NULL,
                description TEXT(120) NOT NULL,
                start_time DATETIME NOT NULL,
                end_time DATETIME NOT NULL
            );";

            $db->exec($sql);
            print("Created $table Table.\n");
        } catch (PDOException $e) {
            echo $e->getMessage(); //Remove or change message in production code
        }
    }
}
