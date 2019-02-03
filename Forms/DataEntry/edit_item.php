<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 2/2/2019
 * Time: 5:39 PM
 */
$strRequest = file_get_contents('php://input');
$request = json_decode($strRequest, true);
$data = [];

// Getting out of that nasty data structure, its been a rough day
foreach($request as $key => $value)
{
    $keys[key($value)] = $value[key($value)];
}

