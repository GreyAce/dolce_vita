<?php

namespace App\inc;

use Dotenv;

$inc_path = dirname(__FILE__);
$src_path = $inc_path . "/src";
$views_path = $inc_path . "/views";
require_once('vendor/autoload.php');

define('BASE_PATH', dirname(__FILE__));


$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH, ".env");
$dotenv->load();


//Back
require_once($src_path . './db_conn.int.php');
require_once($src_path . './db_conn.class.php');
require_once($src_path . './db_controller.int.php');
require_once($src_path . './db_controller.class.php');
require_once($src_path . './helper.class.php');

//Create Tables
// require_once('./MySQL_createTables.php');

//Front
require_once($views_path . './index.class.php');
