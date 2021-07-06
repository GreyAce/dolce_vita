<?php

namespace DB\Controller;

use DB\Controller\DB_Controller_interface;
use DB\Connection\DB_connection;
use App\Helper\Helper;

class DB_controller implements DB_Controller_interface
{
    private $DB;
    public function __construct()
    {
        $DB = new DB_connection();
        $this->DB = $DB->connect();
    }

    public function create($tName, $data)
    {
        $strKeys = '';
        $strVals = '';
        $queryParams = [];
        $queryTypes = '';
        $counter = 0;
        foreach ($data as $key => $val) {

            if ($counter > 0) {
                $strKeys .= ", ";
                $strVals .= ",";
            }
            if (gettype($val) == "string") {
                $queryTypes .= "s";
            } else if (gettype($val) == "number") {
                $queryTypes .= "i";
            }

            array_push($queryParams, $val);
            $strKeys .= "$key";
            $strVals .= "?";
            $counter++;
        }
        array_unshift($queryParams);
        $pdo = $this->DB;
        $query = "INSERT IGNORE INTO $tName ($strKeys) 
                  VALUES ($strVals)";

        $pdo->prepare($query)->execute($queryParams);
        return true;
    }

    public function delete($tName, $id)
    {
        $pdo = $this->DB;
        $query = "DELETE FROM $tName WHERE id=?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        return true;
    }

    public function getOne($tName, $key, $val)
    {
        $pdo = $this->DB;

        $query = "SELECT * FROM $tName WHERE $key = ?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$val]);
        $res = $stmt->fetch();

        return $res;
    }

    public function getAll($tName)
    {
        $pdo = $this->DB;

        $query = "SELECT * FROM $tName";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll();

        return json_encode($res);
    }

    public function getAllByStatus($tName, $status)
    {
        $pdo = $this->DB;
        $query = "SELECT * FROM `$tName` WHERE status = '$status'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll();

        return json_encode($res);
    }

    public function getAllByDates($tName, $start, $end)
    {
        $pdo = $this->DB;
        $query = "SELECT * FROM `$tName` WHERE DATE(start_time) >= '$start' AND DATE(start_time) < '$end'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll();

        return json_encode($res);
    }

    public function update($tName, $arrParams)
    {
        $pdo = $this->DB;
        $queryParams = "";
        $counter = 0;
        $arrQueryParams = [
            'title' => $arrParams['title'],
            'status' => $arrParams['status'],
            'description' => $arrParams['description'],
        ];

        foreach ($arrQueryParams as $key => $val) {

            if ($counter !== 0) {
                $queryParams .= ", ";
            }
            $queryParams .= "$key = :$key";
            $counter++;
        }
        $query = "UPDATE $tName SET $queryParams WHERE id= :id";

        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute($arrParams);
            print_r("success!");
        } catch (\PDOException $e) {
            print_r('Error: ' . $e->getMessage());
        }
        return true;
    }
}
