<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 2/2/2019
 * Time: 5:39 PM
 */
include "../../../Library/DBHelper.php";
$DB = new DBHelper();

$strRequest = file_get_contents('php://input');
$request = json_decode($strRequest, true);
$data = [];

// Getting out of that nasty data structure, its been a rough day
foreach($request as $key => $value)
{
    $data[key($value)] = $value[key($value)];
}

// Getting database name
$database = $data["database"];

// Getting table name
$table = $data["table"];

$DB->UPDATE_TABLE($database, $table, $data);
