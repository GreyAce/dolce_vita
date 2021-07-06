<?php

namespace DB\Controller;

use DB\Connection;

interface DB_Controller_interface
{
    public function create(string $tName, $data);
    public function delete(string $tName, $id);
    public function getOne(string $tName, $key, $val);
    public function getAll(string $tName);
    public function update(string $tName, $arrParams);
}
