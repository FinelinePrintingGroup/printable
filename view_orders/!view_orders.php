<?php

	/*
	
		Filename:
		
			view_orders/!view_orders.php
		
		

	*/
	

	require_once ("../settings.php");
	

	// Open a connection to SQL Server.
	$db = mssql_connect (SQL_Host, SQL_Login, SQL_Password) or die ("Unable to connect to SQL Server.");

	// Get the data needed for the list.
	$query = "SELECT *, (SELECT COUNT(*) FROM OrderDetails WHERE OrderDetails.Order_ID = Orders.Order_ID) AS OrderDetails_Count FROM Orders ORDER BY Order_ID";		
	$result = mssql_query ($query);
	
	echo "<h1>" . mssql_num_rows($result) . " Orders Received From Printable</h1>";
	
	echo "<table border=\"1\">";
	$header_shown = false;
	while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) {
	
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
			if ($key == "Order_ID") {
				echo "<td><a href=\"order_details.php?order_id=" . $value . "\">" . $value . "</a></td>";	
			} else {
				echo "<td>" . $value . "</td>";				
			}
		}	
		echo "</tr>\n";
			
	}
	echo "</table>";
	
	
	
?>