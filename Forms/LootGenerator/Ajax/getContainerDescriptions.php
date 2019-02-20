<?php
/**
 * Created by PhpStorm.
 * User: Sallred
 * Date: 2/5/2019
 * Time: 12:28
 */
require "../../../Library/DBHelper.php";


    $DB = new DBHelper();

    // Getting rows from table

    $containervalue = $_POST["containerType"];
    $prefixvalue = $_POST["prefixType"];

    $rows = $DB->SELECT_RANDOM_CONTAINER($containervalue,$prefixvalue);
    //echo $rows;
    echo json_encode($rows);

