<?php

	/*
	
		Filename:
		

	*/
	

	function finishingoptions_insert ($db, $orderdetail_id, $fo, $debug) {
	
			
		if ($debug === true) {
			echo "<h1>Finishing Options Object</h1>";
			echo "<pre>";
			var_dump ($fo);
			echo "</pre>";
		}

		
		// Create a list of the columns that will be inserted into.
		$columns = "[OrderDetail_ID], [Name], [Value], [FeeType], [CustomerCost], [SellerCost]";


		// Create a list of the values that will be inserted.
		$values = $columns;
		$values = str_replace("[OrderDetail_ID]", "'" . mssql_addslashes(@$orderdetail_id) . "'", $values);
		$values = str_replace("[Name]", "'" . mssql_addslashes(@$fo->Name) . "'", $values);
		$values = str_replace("[Value]", "'" . mssql_addslashes(@$fo->Value) . "'", $values);
		$values = str_replace("[FeeType]", "'" . mssql_addslashes(@$fo->FeeType) . "'", $values);
		$values = str_replace("[CustomerCost]", @$fo->CustomerCost->_, $values);
		$values = str_replace("[SellerCost]", @$fo->SellerCost->_, $values);
				
		// For any columns that we couldn't replace, set the values to NULL.		
		$values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);		
		$values = str_replace(', ,', ', 0,', $values);
	
		// Build the complete "INSERT" statement.
		$insert_query = "INSERT INTO FinishingOptions (" . $columns . ") VALUES (" . $values . ")";
		
		
		if ($debug === true) {
			echo "<h1>Finishing Options INSERT Statement Generated</h1>";
			echo "<pre>";
			echo $insert_query;
			echo "</pre>";
		}
		
		
		// Insert.
		mssql_query ($insert_query);		
		
		return;
	
	}

?>