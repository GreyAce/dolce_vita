<?php

namespace App\Helper;

require('../_includes.php');

use DB\Controller\DB_controller;

$action = $_REQUEST['action'];
$db = new DB_controller();
switch ($action) {
    case 'save':

        $arrParams = array(
            'id' => $_REQUEST['id'],
            'title' => $_REQUEST['title'],
            'status' => $_REQUEST['status'],
            'description' => $_REQUEST['description'],
        );

        $db->update('tasks', $arrParams);
        break;

    case 'add':

        $arrParams = array(
            'title' => $_REQUEST['title'],
            'status' => $_REQUEST['status'],
            'end_time' => $_REQUEST['end_time'],
            'start_time' => date("Y-m-d H:i"),
            'description' => $_REQUEST['description'],
        );

        $db->create('tasks', $arrParams);
        return true;
        break;
    case 'delete':
        $id = $_REQUEST['id'];
        $db->delete('tasks', $id);
        return $id;
        break;
    case 'get':
        break;
    case 'get-all':
        $arrTasks = $db->getAll('tasks');
        print_r($arrTasks);
        return true;
        // return $arrTasks;
        break;
    default:
        throw new \Error("action is not available");
        break;
    case "get-by-dates":
        $start = date('Y-m-d', strtotime($_REQUEST['start']));
        $end = date('Y-m-d', strtotime($_REQUEST['end']));
        $arrTasks = $db->getAllByDates('tasks', $start, $end);
        print_r($arrTasks);
        break;
    case "get-by-status":
        $status = $_REQUEST['status'];
        $arrTasks = $db->getAllByStatus('tasks', $status);
        print_r($arrTasks);
        break;
}
