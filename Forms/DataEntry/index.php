<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 1/15/2019
 * Time: 1:07 PM
 */
require "../../Library/DBHelper.php";
$DB = new DBHelper();
?>
<!DOCTYPE html>
<html>
<title>Data Entry</title>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- data tables bootstrap style cdn -->
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Our custom CSS, needs to come before bootstrap -->
    <link href="../../Master/custom_style.css" rel="stylesheet">
</head>
<body>
<?php include "../../Master/top_navbar.php"; ?>
<h1 class="text-center mt-3">Data Entry</h1>
<!-- Whole Page -->
<div class="container bg-white mt-3 rounded">
    <div class="row">
        <div class="col mt-3">
            <h3>Select Table to Enter Data</h3>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Select Databases:</label>
                <div class="col-sm-8">
                    <select id="ddlBases" class="form-control">
                        <?php
                        $databases = $DB->GET_ALL_DATABASES();

                        foreach($databases as $database)
                        {
                            if($database !== "information_schema" && $database !== "performance_schema" && $database !== "phpmyadmin" && $database !== "mysql")
                            {
                                echo "<option value='$database'>$database</option>";
                            }
                        }
                        ?></select>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Select Table:</label>
                <div class="col-sm-9">
                    <select id="ddlTable" class="form-control">
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- Show it as a list -->
    <div class="row pt-3" id="listdiv">
        <div class="container-fluid" id="main">
            <div class="d-flex justify-content-between">
                <div><button class="btn btn-secondary" onclick="previousItem()" id="previous">Previous</button></div>
                <div><button class="btn btn-primary" onclick="nextItem()" id="next">Next</button></div>
            </div>
            <br>
            <form id="list">
            </form>
        </div>
    </div>
</div>
<div class="container mt-5"></div>
<div id="response"></div>
<!-- Put script tags at the bottom of the page, makes the page load faster -->
<!-- JQuery cdn -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<!-- Bootstrap complete JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<!-- Datatables w/bootstrap -->
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

<script>
    var count = 0;
    var position = 0;
    var rows = [];
    var cols = [];
    var size = 0;

    $(document).ready(function() {
        // Load the data table
        //getTable();
        getTableList();
    });

    $("#ddlBases").change(function() {
        position = 0;
        $("#list").empty();
        $("#ddlTable").empty();
        getTableList();
    });

    function getTableList()
    {
        var database = $("#ddlBases").val();

        $.ajax({
            method: "post",
            url: "./table_processing.php",
            data: {database: database},
            success: function (data) {
                var selectValues = JSON.parse(data);
                $.each(selectValues, function(key, value) {
                    $('#ddlTable')
                        .append($("<option></option>")
                            .attr("value",value)
                            .text(value));
                });

                getList();
            }
        });
    }

    function getList()
    {
        var table = $("#ddlTable").val();
        var database = $("#ddlBases").val();

        $.ajax({
            method: "post",
            url: "./table_processing.php",
            data: {tableName: table, database: database},
            success:function(data)
            {
                rows = JSON.parse(data);

                if (rows === undefined || rows.length === 0) {
                    // array empty or does not exist
                    alert("The table: " + table + ", did not return anything. Might be empty.")
                }

                else
                {
                    cols = Object.keys(rows[0]);

                    if(count !== 0)
                    {
                        // Destroy list
                        showItem();
                    }

                    else
                    {
                        showItem();
                        count++;
                    }
                }
            }
        });
    }

    function showItem()
    {
        size = rows.length;
        $.ajax({
            method: "post",
            url: "./list_processing.php",
            data: {rows: rows[position], cols: cols},
            success:function(data)
            {
                $("#list").append(data);
            }
        });
    }

    function nextItem()
    {
        position++;
        if(position !== 0 && position !== size)
        {
            $("#list").empty();
            showItem();
        }

        else
        {
            position--;
            alert("There are no more items!");
        }
    }

    function previousItem()
    {
        if(position === 0)
        {
            position = 0;
        }

        else
        {
            position--;
            $("#list").empty();
            showItem();
        }
    }

    $('#ddlTable').change(function(){
        position = 0;
        $('#list').empty();
        getList();
    });

    $('#list').submit(function(event) {
        var jsonObj = [];

        // Getting all inputs first
        $('input[type=text]').each(function(){
            var name = $(this).attr("id");
            var value = $(this).val();
            var item = {};

            item[name] = value;
            jsonObj.push(item);
        });

        // Getting all textareas next
        $("textarea").each(function(){
            var name = $(this).attr("id");
            var value = $(this).val();
            var item = {};

            item[name] = value;
            jsonObj.push(item);
        });

        var item = {};
        item["table"] = $("#ddlTable").val();
        jsonObj.push(item);

        item = {};
        item["database"] = $("#ddlBases").val();
        jsonObj.push(item);

        // AJax Call
        $.ajax({
            method: "post",
            url: "./edit_item.php",
            datatype: "json",
            data: JSON.stringify(jsonObj),
            success:function(data)
            {
                $("#response").append(data);
            }
        });
        // Preventing default
        event.preventDefault();
    });
</script>
</body>
</html>
