<?php

namespace App;

use Dotenv;
use DB\Create_tables as Create_Tables;
use App\Views\Base_View;


define(E_STRICT, true);
ini_set('display_errors', true);
// define('BASE_PATH', dirname(__FILE__));


require_once('./_includes.php');

$view = new Base_View();
$view->init();

// $test = new Create_Tables();
// $test->create_tasks_table();
