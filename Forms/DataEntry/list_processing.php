<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 1/10/2019
 * Time: 12:07 PM
 */
require "../../Library/DBHelper.php";

if(isset($_POST["rows"]) && isset($_POST["cols"]))
{
    $rows = $_POST["rows"];
    $cols = $_POST["cols"];
    $count = 0;

    // Creating elements
    foreach($cols as $column)
    {
        if($count == 0)
        {
            echo "<h5>ID " . $rows[$column] . "</h5>";
            echo '<input type="text" id="'. $column . '" value="'. $rows[$column] . '" hidden>';
        }

        else if(strlen($rows[$column]) > 100)
        {
            $numberOfRows = ceil(strlen($rows[$column]) / 100);
            echo "<div class='form-group'><label for='$column'>$column</label>";
            echo "<textarea class='form-control' rows ='$numberOfRows' id='$column'>$rows[$column]</textarea>";
            echo "</div>";
        }

        else
        {
            echo "<div class='form-group'><label for='$column'>$column</label>";
            echo "<input type='text' class='form-control' id='$column' value='" . $rows[$column] . "'>";
            echo "</div>";
        }
        $count++;
    }

    echo '<input type="submit" class="btn btn-primary" value="Submit"><div class="pt-3"></div>';
}