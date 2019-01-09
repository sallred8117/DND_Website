<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 1/9/2019
 * Time: 9:16 AM
 */
require "../Library/DBHelper.php";
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
        <!-- Datatable -->
        <div class="row" id="tablediv" style="padding-bottom: 15px;">
            <table id="dtable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"></table>
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
    $(document).ready(function() {
        // Load the data table
        getTable();
    });

    // WHen the table is changed, load the data table
    $("#ddlTable").change(function(){
        // Destroy table
        var table = $("#dtable").DataTable();
        table.destroy();
        $("#dtable").empty();

        // Recreate element
        /*var div = document.getElementsByTagName('tablediv')[0];
        var tbl = document.createElement('table');
        tbl.id = "dtable";
        tbl.className = "table table-striped table-bordered";*/

        // Load the data table
        getTable();
    });

    // Used to show the datatable
    function showTable(rows, cols)
    {
        var array = [];

        for (var i = 0; i < cols.length; i++)
        {
            array.push({title: cols[i], data: cols[i]});
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
                    cols = Object.keys(rows[0]);
                    showTable(rows, cols);
                }
            }
        });
    }
</script>
</body>
</html>
