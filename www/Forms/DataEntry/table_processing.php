<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 1/9/2019
 * Time: 11:04 AM
 */
require "../../../Library/DBHelper.php";

if(isset($_POST["tableName"]) && isset($_POST["database"]))
{
    // Getting table name
    $tableName = $_POST["tableName"];
    $database = $_POST["database"];

    $DB = new DBHelper();
    $DB->SWITCH_DB($database);
    // Getting rows from table
    $rows = $DB->SELECT_ALL($tableName);
	//var_dump($rows);
	//$test = json_encode($rows);
    //var_dump($test);
	echo json_encode($rows);
}

else if(isset($_POST["database"]))
{
    // Getting database name
    $database = $_POST["database"];

    $DB = new DBHelper();

    $DB->SWITCH_DB($database);

    // Getting rows
    $rows = $DB->GET_ALL_TABLES($database);

    echo json_encode($rows);
}

else
{
    echo "Parameters not set right.";
}
