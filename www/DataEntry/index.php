<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 1/9/2019
 * Time: 9:16 AM
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
</head>
<body>

<!-- Whole Page -->
<div class="container-fluid bg-white">
    <div class="container bg-white">
        <h1>Data Entry</h1>
        <hr>
        <div class="row" style="padding-bottom: 15px;">
                Table <select id="ddlTable">
                    <?php
                    $tables = $DB->GET_ALL_TABLES();

                    foreach($tables as $table)
                    {
                        echo "<option value='$table'>$table</option>";
                    }
                    ?></select>
        </div>
        <!-- Show it as a list -->
        <div class="row" id="listdiv">
            <div class="container-fluid" id="main">
                <div class="d-flex justify-content-between">
                    <div><button class="btn btn-secondary disabled" onclick="previousItem()" id="previous">Previous</button></div>
                    <div><button class="btn btn-primary" onclick="nextItem()" id="next">Next</button></div>
                </div>
                <br>
                <form id="list">
                    <!--<div class="form-group">
                        <label for="exampleFormControlInput1">Email address</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Example multiple select</label>
                        <select multiple class="form-control" id="exampleFormControlSelect2">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>-->
                </form>
            </div>
        </div>
        <!-- Data table -->
        <div class="row" id="tablediv" style="padding-bottom: 15px;">
            <table id="dtable" class="table table-striped table-bordered" style="width:100%"></table>
        </div>
    </div>
</div>

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

    $(document).ready(function() {
        // Load the data table
        //getTable();
        getList();
    });

    // WHen the table is changed, load the data table
    $("#ddlTable").change(function(){
        var table = document.getElementById("ddlTable").value;

		var table = document.getElementById("ddlTable").value
        $.ajax({
            method: "post",
            url: "./table_processing.php",
            data: {tableName: table},
            success:function(data)
            {
				console.log(data);
                var max =  JSON.parse(data);
				
            }
        });

        // Recreate element
        /*var div = document.getElementsByTagName('tablediv')[0];
        var tbl = document.createElement('table');
        tbl.id = "dtable";
        tbl.className = "table table-striped table-bordered";*/

        // Load the data table
        //getTable();
        $("#list").empty();
        rows = [];
        cols = [];
        position = 0;
        if(position === 0)
        {
            var element = document.getElementById("previous");
            element.classList.add("disabled");
        }
        getList();
    });

    // Used to show the datatable
    function showTable(rows, cols)
    {
        var array = [];

        for (var i = 0; i < cols.length; i++)
        {
            array.push({title: cols[i], data: cols[i], defaultContent: '<a href="" class="editor_edit">Edit</a> / <a href="" class="editor_remove">Delete</a>'});
        }
        console.log(rows);
        console.log(array);

        // Creating data table and defining its properties
        var dtable = $('#dtable').DataTable({
            "processing": true,
            "serverside": true,
            "lengthMenu": [20, 40, 60, 80, 100],
            "destroy": true,
            scrollX: true,
            "initComplete": function () {
                console.log("Table done loading...");
                count++;
            },
            data: rows,
            columns: array
        });
    }

    function getTable()
    {
        var table = $("#ddlTable").val();

        $.ajax({
            method: "post",
            url: "./table_processing.php",
            data: {tableName: table},
            success:function(data)
            {
				
                var rows = JSON.parse(data);
                var cols;

                if (rows === undefined || rows.length === 0) {
                    // array empty or does not exist
                    alert("The table: " + table + ", did not return anything. Might be empty.")
                }

                else
                {
                    if(count !== 0)
                    {
                        // Destroy table
                        var table = $("#dtable").DataTable();
                        table.destroy();
                        $("#dtable").empty();
                    }

                    cols = Object.keys(rows[0]);
                    showTable(rows, cols);
                }
            }
        });
    }

    function getList()
    {
        var table = $("#ddlTable").val();

        $.ajax({
            method: "post",
            url: "./table_processing.php",
            data: {tableName: table},
            success:function(data)
            {
				console.log(data);
                rows = JSON.parse(data);

                if (rows === undefined || rows.length === 0) {
                    // array empty or does not exist
                    alert("The table: " + table + ", did not return anything. Might be empty.")
                }

                else
                {
                    cols = Object.keys(rows[0]);
                    console.log(rows);
                    console.log(cols);

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
        console.log(rows);
        console.log(cols);
        $.ajax({
            method: "post",
            url: "./list_processing.php",
            data: {rows: rows[position], cols: cols},
            success:function(data)
            {
                console.log(data);
                $("#list").append(data);
            }
        });
    }

    function nextItem()
    {
        position++;

        if(position !== 0)
        {
            var element = document.getElementById("previous");
            element.classList.remove("disabled");
            $("#list").empty();
            showItem();
        }
    }

    function previousItem()
    {
        if(position === 0)
        {
            var element = document.getElementById("previous");
            element.classList.add("disabled");
        }

        else
        {
            position--;
            $("#list").empty();
            showItem();
        }
    }
</script>
</body>
</html>
