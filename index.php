<?php
/**
 * Created by PhpStorm.
 * User: Court
 * Date: 1/9/2019
 * Time: 9:16 AM
 */
require "./Library/DBHelper.php";
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
<div class="container-fluid bg-primary">
    <div class="container bg-white">
        <h1>Data Entry</h1>
        <hr>
        <div class="row">
            <div class="col">
                Table <select id="ddlTable">
                    <?php
                    $tables = $DB->GET_ALL_TABLES();

                    foreach($tables as $table)
                    {
                        echo "<option value='$table'>$table</option>";
                    }
                    ?></select>
            </div>
        </div>
        <!-- Datatable -->
        <div class="row">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    
                </tr>
                </thead>
            </table>
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
        $('#example').DataTable();
    });

    // WHen the table is changed, load the data table
    $("#ddlTable").change(function(){
        console.log("Hey");
    });

    // Used to show the datatable
    function showTable() {
        // Creating data table and defining its properties
        var table = $('#dataTable').DataTable({
            "processing": true,
            "serverside": true,
            "lengthMenu": [20, 40, 60, 80, 100],
            "destroy": true,

            // Displaying loading gif
            "language": {
                "processing": "<figure id='figLoad'>" +
                "<img src='../../EmployeeManager/Forms/LoadingGifs/loading-gif-1.gif' style='width: 50%; height: 50%;'><figcaption>Loading</figcaption></figure>"
            },

            "initComplete": function () {
                console.log("Table done loading...");
            },

            // Getting select statement
            ajax:
                {
                    url: "../Master/Server_Scripts/ManageEmployeesManager.php?getDataTable=" + true,
                },

            columns: [
                {data: 'id'},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'gender'},
                {data: 'hire_date'},
                {data: 'employee_number'},
                {data: 'admin'},
                {data: 'title'},
                {data: 'street_address'}
            ]
        });
    }
</script>
</body>
</html>
