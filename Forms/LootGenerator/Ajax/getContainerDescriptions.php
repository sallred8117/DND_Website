<?php
/**
 * Created by PhpStorm.
 * User: Sallred
 * Date: 2/5/2019
 * Time: 12:28
 */
require "../../../Library/DBHelper.php";
if(isset($_POST["selectedContainer"]))
{
    $container = $_POST["selectedContainer"];
    $DB = new DBHelper();
    // Getting rows from table
    $rows = $DB->SELECT_RANDOM_CONTAINER($container);
}
else
{
    $DB = new DBHelper();
    // Getting rows from table
    $rows = $DB->SELECT_RANDOM_CONTAINER();
    //echo $rows;
    echo json_encode($rows);
}

