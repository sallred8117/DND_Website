<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 1/14/2019
 * Time: 12:35 PM
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
		 <div class="row" style="padding-bottom: 15px;">
                CR Rating <select id="ddlTableCR">
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
    $(document).ready(function() 
	{
       
    });
	function inChest()
	{
	   var distribution = getDistribution("Standard Chest");
	   var isMoney = rollRandom("d100");
	   var isMagicItem = rollRandom("d100");
	   var isTrinket = rollRandom("d100");
	   var isGear = rollRandom("d100");
	   var isFoodNDrink = rollRandom("d100");
	   console.log("Money Roll: " + isMoney);
	   console.log("Magic Roll: " + isMagicItem);
	   console.log("Trinket Roll: " + isTrinket);
	   console.log("Gear Roll: " + isGear);
	   console.log("Food Roll: " + isFoodNDrink);
	   var existsArray = {Money: 0, MagicItem: 0, Trinket: 0, Gear: 0, FoodNDrink: 0};
	   if(distribution.Money >= isMoney)
	   {
		   // 60   <=   15
		   //Money Exists
		   existsArray.Money = "1";
	   }
	   if(distribution.MagicItem >= isMagicItem)
	   {
		   //MagicItem Exists
		    existsArray.MagicItem = "1";
	   }
	   if(distribution.Trinket >= isTrinket)
	   {
		   //Trinket Exists
		    existsArray.Trinket = "1";
	   }
	   if(distribution.Gear >= isGear)
	   {
		   //Gear Exists
		    existsArray.Gear = "1";
	   }
	   if(distribution.FoodNDrink >= isFoodNDrink)
	   {
		   //FoodNDrink Exists
		    existsArray.FoodNDrink = "1";
	   }
	   return existsArray;
	   
	}
	function getDistribution(type)
	{
		if(type == "Standard Chest")
		{
			var dist = {Money: 99, MagicItem: 10, Trinket: 20, Gear: 7.5, FoodNDrink: 2.5};
			console.log("Using " + type + " distribution : " + "60,10,20,7.5,2.5");
		}
		return dist;
	}
	function rollRandom(dice)
    {
		if(dice == "d100")
		{
			//Roll random 100
			var value = Math.floor(Math.random() * 100) + 1;
		}
		else if (dice == "d20")
		{
			//Roll random 20
			var value = Math.floor(Math.random() * 20) + 1;
		}
		else if (dice == "d12")
		{
			//Roll random 12
			var value = Math.floor(Math.random() * 12) + 1;
		}
		if(dice == "d10")
		{
			//Roll random 10
			var value = Math.floor(Math.random() * 10) + 1;
		}
		else if (dice == "d8")
		{
			//Roll random 8
			var value = Math.floor(Math.random() * 8) + 1;
		}
		else if (dice == "d6")
		{
			//Roll random 6
			var value = Math.floor(Math.random() * 6) + 1;
		}
		else if (dice == "d4")
		{
			//Roll random 4
			var value = Math.floor(Math.random() * 4) + 1;
		}
		return value;
	}
     
	$("#ddlTableCR").change(function()
	{
		 // Load the data table
        //getTable();
       // getList();
	   var TABLE = document.getElementById("dtable");
	   while(TABLE.rows.length > 0) 
	   {
			TABLE.deleteRow(0);
	   }
	   for(var i = 0; i < 5; i++)
	   {
		   
		   var ROW = TABLE.insertRow(0);
		   var cell1 = ROW.insertCell(0);
		   var cell2 = ROW.insertCell(1);
		   var dbInTheChest = inChest();
	       
	 
		   for(var property in dbInTheChest)
		   {
			   console.log(dbInTheChest[property]);
			  
			   if(property == "Money" && dbInTheChest[property] == "1")
			   {
					var CR = document.getElementById("ddlTableCR").value;
					if(CR == "0" || CR == "1/8" || CR == "1/4" || CR == "1/2" || CR == "1" || CR == "2" || CR == "3" || CR == "4")
					{
						var quality = rollRandom("d100");
						console.log("Quality: " + quality);
						if(quality <= 30)
						{
						   var value = 0;
						   for(var i = 0; i < 5; i++)
						   {
							   value += rollRandom("d6");
						   }
						   $("body").append(value + " cp ");
						   cell1.innerHTML += value + " cp, ";
						   //Q30 :cp
						}
						else if (quality >= 31 && quality <= 60)
						{
						   var value = 0;
						   for(var i = 0; i < 4; i++)
						   {
							   value += rollRandom("d6");
						   }
						   $("body").append(value + " sp ");
							cell1.innerHTML += value + " sp, ";
						   //sp
						}
						 else if (quality >= 61 && quality <= 70)
						 {
						   var value = 0;
						   for(var i = 0; i < 3; i++)
						   {
							   value += rollRandom("d6");
						   }
						   $("body").append(value + " ep ");
						   cell1.innerHTML += value + " ep, ";
						 }
						 else if (quality >= 71 && quality <= 95)
						 {
							var value = 0;
						   for(var i = 0; i < 3; i++)
						   {
							   value += rollRandom("d6");
						   }
						   $("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
						 }
						 else if (quality >= 96 && quality <= 100)
						 {
							   value += rollRandom("d6");
							   $("body").append(value + " pp ");
							   cell1.innerHTML += value + " pp, ";
						 }
						   
					}
					if(CR == "5" || CR == "6" || CR == "7" || CR == "8" || CR == "9" || CR == "10")
					{
						var quality = rollRandom("d100");
						console.log("Quality: " + quality);
						if(quality <= 30)
						{
						   var value = 0;
						   for(var i = 0; i < 4; i++)
						   {
							   value += rollRandom("d6");
						   }
							value = value * 100;
						   $("body").append(value + " cp ");
						   cell1.innerHTML += value + " cp, ";
						   //cp
						   value = 0;
						   value = rollRandom("d6") * 10;
						   $("body").append(value + " ep ");
							cell1.innerHTML += value + " ep, ";
						   //ep
						}
						else if (quality >= 31 && quality <= 60)
						{
						   var value = 0;
						   for(var i = 0; i < 6; i++)
						   {
							   value += rollRandom("d6");
						   }
						   value = value * 10;
						   $("body").append(value + " sp ");
						   cell1.innerHTML += value + " sp, ";
						   //sp
						   
						   value = 0;
						   for(var i = 0; i < 2; i++)
						   {
							   value += rollRandom("d6");
						   }
						   value = value * 10;
						   $("body").append(value + " gp ");
						   cell1.innerHTML += value + " gp, ";
						   //gp
						}
						 else if (quality >= 61 && quality <= 70)
						 {
						   
						   var value = 0;
						   for(var i = 0; i < 3; i++)
						   {
							   value += rollRandom("d6");
						   }
						   value = value * 10;
						   $("body").append(value + " ep ");
							cell1.innerHTML += value + " ep, ";
						   //ep
						   
						   value = 0;
						   for(var i = 0; i < 2; i++)
						   {
							   value += rollRandom("d6");
						   }
						   value = value * 10;
							$("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
						   //gp
						 }
						 else if (quality >= 71 && quality <= 95)
						 {
						   var value = 0;
						   for(var i = 0; i < 4; i++)
						   {
							   value += rollRandom("d6");
						   }
						   value = value * 10;
						   $("body").append(value + " gp ");
						   cell1.innerHTML += value + " gp, ";
						   //gp
						 }
						 else if (quality >= 96 && quality <= 100)
						 {
						   var value = 0;
						   for(var i = 0; i < 2; i++)
						   {
							   value += rollRandom("d6");
						   }
						   value = value * 10;
						   $("body").append(value + " gp ");
						   cell1.innerHTML += value + " gp, ";
						   //gp
						   value = 0;
						   for(var i = 0; i < 3; i++)
						   {
							   value += rollRandom("d6");
						   }
						   $("body").append(value + " pp ");
							cell1.innerHTML += value + " pp, ";
						 }
					}
					if(CR == "11" || CR == "12" || CR == "13" || CR == "14" || CR == "15" || CR == "16")
					{
						var quality = rollRandom("d100");
						console.log("Quality: " + quality);
						if(quality <= 20)
						{
						   var value = 0;
						   for(var i = 0; i < 4; i++)
						   {
							   value += rollRandom("d6");
						   }
						   value = value * 100;
						   $("body").append(value + " sp ");
						   cell1.innerHTML += value + " sp, ";
						   //sp
						   value = 0;
						   value = rollRandom("d6");
						   value = value * 100;
						   $("body").append(value + " gp ");
						   cell1.innerHTML += value + " gp, ";
						   //gp
						}
						if(quality >= 21 && quality <= 35)
						{
							var value = 0;
							value = rollRandom("d6");
							value = value * 100;
							$("body").append(value + " ep ");
							 cell1.innerHTML += value + " ep, ";
							//ep
							value = 0;
							value = rollRandom("d6");
							value = value * 100;
							$("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
							//gp
						}
						if(quality >= 36 && quality <= 75)
						{
							var value = 0;
							for(var i = 0; i < 2; i++)
							{
							   value += rollRandom("d6");
							}
							value = value * 100;
							$("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
							//gp
							value = 0;
							value = rollRandom("d6");
							value = value * 10;
							$("body").append(value + " pp ");
							 cell1.innerHTML += value + " pp, ";
							//pp
						}
						if(quality >= 76 && quality <= 100)
						{
							var value = 0;
							for(var i = 0; i < 2; i++)
							{
							   value += rollRandom("d6");
							}
							value = value * 100;
							$("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
							//gp
							value = 0;
							for(var i = 0; i < 2; i++)
							{
							   value += rollRandom("d6");
							}
							value = value * 10;
							$("body").append(value + " pp ");
							 cell1.innerHTML += value + " pp, ";
							//pp
						}
					}
					if(CR == "17" || CR == "18" || CR == "19" || CR == "20" || CR == "21+")
					{
						var quality = rollRandom("d100");
						console.log("Quality: " + quality);
						if(quality <= 15)
						{
							var value = 0;
							for(var i = 0; i < 2; i++)
							{
							   value += rollRandom("d6");
							}
							value = value * 1000;
							$("body").append(value + " ep ");
							 cell1.innerHTML += value + " ep, ";
							//ep
							value = 0;
							for(var i = 0; i < 8; i++)
							{
							   value += rollRandom("d6");
							}
							value = value * 100;
							$("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
							//gp
						}
						if(quality >= 16 && quality <= 55)
						{
							var value = 0;
							
							value = rollRandom("d6");
							
							value = value * 1000;
							$("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
							//gp
							value = 0;
							
							value = rollRandom("d6");
							
							value = value * 100;
							$("body").append(value + " pp ");
							 cell1.innerHTML += value + " pp, ";
							//pp
						}
						if(quality >= 56 && quality <= 100)
						{
							var value = 0;
							
							value = rollRandom("d6");
							
							value = value * 1000;
							$("body").append(value + " gp ");
							cell1.innerHTML += value + " gp, ";
							//gp
							value = 0;
							
							for(var i = 0; i < 2; i++)
							{
							   value += rollRandom("d6");
							}
							
							value = value * 100;
							$("body").append(value + " pp ");
							 cell1.innerHTML += value + " pp, ";
							//pp
						}
					}
				
			   }
			   if(property == "MagicItem" && dbInTheChest[property] == "1")
			   {
				   $.ajax({
					method: "post",
					url: "./table_processing_one.php",
					data: {tableName: "magic_items"},
					success:function(data)
					{
						var max =  JSON.parse(data);
						var TEST = max[0].Name + ", ";
						$("body").append(TEST);
						cell2.innerHTML += TEST;
					}
				});
			   }
			   if(property == "Trinket" && dbInTheChest[property] == "1")
			   {
					$.ajax({
					method: "post",
					url: "./table_processing_one.php",
					data: {tableName: "trinkets"},
					success:function(data)
					{
						var max =  JSON.parse(data);
						if(max[0].Name == "")
						{
							var TEST = max[0].description + ", ";
							$("body").append(TEST);
							cell1.innerHTML += TEST;
						}
						else
						{
							var TEST = max[0].Name + ", ";
							$("body").append(TEST);
							cell1.innerHTML += TEST;
						}
					}
				}); 
			   }
			   if(property == "Gear" && dbInTheChest[property] == "1")
			   {
					$.ajax({
					method: "post",
					url: "./table_processing_one.php",
					data: {tableName: "gear"},
					success:function(data)
					{
						var max =  JSON.parse(data);
						
						var TEST = max[0].Name + ", ";
						$("body").append(TEST);
						cell1.innerHTML += TEST;
						
					}
				}); 
			   }
			   if(property == "FoodNDrink" && dbInTheChest[property] == "1")
			   {
					$.ajax({
					method: "post",
					url: "./table_processing_one.php",
					data: {tableName: "foodndrink"},
					success:function(data)
					{
						var max =  JSON.parse(data);
						var TEST = max[0].Name + ", ";
						$("body").append(TEST);
						cell1.innerHTML += TEST;
					}
				}); 
			   }
			   
			  
		   }
		   }
	   
	   
	});
    // WHen the table is changed, load the data table
    $("#ddlTable").change(function(){

		var table = document.getElementById("ddlTable").value
        $.ajax({
            method: "post",
            url: "./table_processing.php",
            data: {tableName: table},
            success:function(data)
            {
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
