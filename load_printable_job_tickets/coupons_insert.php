<?php

	/*
	
		Filename:
		
	

	*/
	

	function coupons_insert ($db, $orderdetail_id, $cp, $debug) {
	
			
		if ($debug === true) {
			echo "<h1>Coupons Object</h1>";
			echo "<pre>";
			var_dump ($cp);
			echo "</pre>";
		}

		
		// Create a list of the columns that will be inserted into.
		$columns = "[OrderDetail_ID], [Code], [Discount]";


		// Create a list of the values that will be inserted.
		$values = $columns;
		$values = str_replace("[OrderDetail_ID]", "'" . mssql_addslashes(@$orderdetail_id) . "'", $values);
		$values = str_replace("[Code]", "'" . mssql_addslashes(@$cp->Code) . "'", $values);
		$values = str_replace("[Discount]", @$cp->Discount->_, $values);
				
		// For any columns that we couldn't replace, set the values to NULL.		
		$values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);		
		$values = str_replace(', ,', ', 0,', $values);
	
		// Build the complete "INSERT" statement.
		$insert_query = "INSERT INTO Coupons (" . $columns . ") VALUES (" . $values . ")";
		
		
		if ($debug === true) {
			echo "<h1>Coupons INSERT Statement Generated</h1>";
			echo "<pre>";
			echo $insert_query;
			echo "</pre>";
		}
		
		
		// Insert.
		mssql_query ($insert_query);		
		
		return;
	
	}

?>