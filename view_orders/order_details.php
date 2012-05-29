<?php

	/*
	
		Filename:
		
			view_orders/order_details.php
		
		
		

	*/
	

	require_once ("../settings.php");
	
	// Validate the Order_ID.
	if (!isset($_GET["order_id"])) { die ("No Order_ID specified."); }
	if (!is_numeric($_GET["order_id"])) { die ("The Order_ID specified is invalid."); }
	

	// Open a connection to SQL Server.
	$db = mssql_connect (SQL_Host, SQL_Login, SQL_Password) or die ("Unable to connect to SQL Server.");

	// Get the data needed for the header.
	$query = "SELECT * FROM Orders WHERE Order_ID=" . $_GET["order_id"];		
	$header = mssql_query ($query);
	
	// Get the data needed for the lineitems.
	$query = "SELECT * FROM OrderDetails WHERE Order_ID=" . $_GET["order_id"];		
	$lineitems = mssql_query ($query);	
	
	
	
	echo "<h1>Order# " . $_GET["order_id"] . "</h1>";
	
	echo "<h2>Header</h2>";
	echo "<table border=\"1\">";	
	$row = mssql_fetch_array($header, MSSQL_ASSOC);	
	foreach ($row as $key => $value) {
		echo "<tr>";
			echo "<td style=\"font-weight: bold;\">" . $key . ":</td>";
			echo "<td>" . $value . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	echo "<h2>" . mssql_num_rows($lineitems) . " Lineitems</h2>";
	
	echo "<table border=\"1\">";
	$header_shown = false;
	while ($row = mssql_fetch_array($lineitems, MSSQL_ASSOC)) {
	
		// Show the header row.
		if (!$header_shown) {
		
			echo "\n<tr>";
			foreach ($row as $key => $value) {				
				echo "<th>" . $key . "</th>";				
			}	
			echo "</tr>\n";
			
			$header_shown = true;
			
		}
	
		// Show the data row.
		echo "\n<tr>";
		foreach ($row as $key => $value) {	
			echo "<td>" . $value . "</td>";
		}	
		echo "</tr>\n";
			
	}
	echo "</table>";	
	
	
	
	
	
?>