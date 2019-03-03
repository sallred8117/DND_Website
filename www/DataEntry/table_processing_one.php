<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 1/9/2019
 * Time: 11:04 AM
 */
require "../../Library/DBHelper.php";

if(isset($_POST["tableName"]))
{
    // Getting table name
    $tableName = $_POST["tableName"];

    $DB = new DBHelper();

    // Getting rows from table
    $rows = $DB->SELECT_ONE_ITEM_FROM_TABLE($tableName);
	//echo $rows;
    echo json_encode($rows);
}

else
{
    echo "Parameters not set right.";
}
