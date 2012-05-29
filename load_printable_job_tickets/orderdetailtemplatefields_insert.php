<?php

	/*
	
		Filename:
		


	*/
	

	function orderdetailtemplatefields_insert ($db, $orderdetail_id, $tp, $debug) {
	
			
		if ($debug === true) {
			echo "<h1>Order Details Template Fields Object</h1>";
			echo "<pre>";
			//var_dump ($tp);
			echo "</pre>";
		}

		
		// Create a list of the columns that will be inserted into.
		$columns = "[OrderDetail_ID], [Name], [Value]";


		// Create a list of the values that will be inserted.
		$values = $columns;
		$values = str_replace("[OrderDetail_ID]", "'" . mssql_addslashes(@$orderdetail_id) . "'", $values);
		$values = str_replace("[Name]", "'" . mssql_addslashes(@$tp->Name) . "'", $values);
		$values = str_replace("[Value]", "'" . mssql_addslashes(@$tp->Value) . "'", $values);
				
		// For any columns that we couldn't replace, set the values to NULL.		
		$values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);		
	
	
		// Build the complete "INSERT" statement.
		$insert_query = "INSERT INTO OrderDetail_TemplateFields (" . $columns . ") VALUES (" . $values . ")";
		
		
		if ($debug === true) {
			echo "<h1>OrderDetail_TemplateFields INSERT Statement Generated</h1>";
			echo "<pre>";
			echo $insert_query;
			echo "</pre>";
		}
		
		
		// Insert.
		mssql_query ($insert_query);		
		
		return;
	
	}

?>