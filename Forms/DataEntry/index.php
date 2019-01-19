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
<title>Blank Page</title>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- data tables bootstrap style cdn -->
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Our custom CSS, needs to come before bootstrap -->
    <link href="../../Master/custom_style.css" rel="stylesheet">
</head>
<body>
<?php include "../../Master/top_navbar.php"; ?>
<h1 class="text-center mt-3">Loot Generator</h1>
<!-- Whole Page -->
<div class="container bg-white rounded mt-3">
    <div class="row">
        <div class="col mt-3">
            <h3>How it Works</h3>
            <hr>
            <p>To generate some loot, please select the CR level of the monster your party defeated! There is a chance that
                your party rolls well, and may get a magical item that is classed one level above there own, good luck!</p>
        </div>
    </div>
    <div class="row">
        <div class="col mt-3">
            <h3>Color Coding for Rarity</h3>
            <hr>
            <p>Below is a list defining a rarity of an item going from weakest to greatest.</p>
            <ul>
                <li>Common</li>
                <li>Uncommon</li>
                <li>Rare</li>
                <li>Very Rare</li>
                <li>Legendary</li>
            </ul>
        </div>
    </div>
</div>

<div class="container bg-white mt-5 rounded">
    <div class="row">
        <div class="col mt-3">
            <h3>Generator Options</h3>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col">
            Number of items to generate <select class="form-control" id="ddlContainerList">
                <option value="4">4</option>
                <option value="6">6</option>
                <option value="8">8</option>
                <option value="10" selected="selected">10</option>
                <option value="12">12</option>
                <option value="20">20</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col">
            CR Rating <select id="ddlTableCR" class="form-control">
                <option value="0"> CR 0 </option>
                <option value="1/8"> CR 1/8 </option>
                <option value="1/4"> CR 1/4 </option>
                <option value="1/2"> CR 1/2 </option>
                <option value="1"> CR 1 </option>
                <option value="2"> CR 2 </option>
                <option value="3"> CR 3 </option>
                <option value="4"> CR 4 </option>
                <option value="5"> CR 5 </option>
                <option value="6"> CR 6 </option>
                <option value="7"> CR 7 </option>
                <option value="8"> CR 8 </option>
                <option value="9"> CR 9 </option>
                <option value="10"> CR 10 </option>
                <option value="11"> CR 11 </option>
                <option value="12"> CR 12 </option>
                <option value="13"> CR 13 </option>
                <option value="14"> CR 14 </option>
                <option value="15"> CR 15 </option>
                <option value="16"> CR 16 </option>
                <option value="17"> CR 17 </option>
                <option value="18"> CR 18 </option>
                <option value="19"> CR 19 </option>
                <option value="20"> CR 20 </option>
                <option value="20+"> CR 20+ </option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col mt-3"></div>
    </div>
</div>

<div class="mt-5">
    <h1>Bottom</h1>
</div>
<!-- Put script tags at the bottom of the page, makes the page load faster -->
<!-- JQuery cdn -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<!-- Bootstrap complete JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</body>
</html>
