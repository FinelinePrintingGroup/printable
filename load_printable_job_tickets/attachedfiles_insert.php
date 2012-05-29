<?php

	/*
	
		Filename:	
			

	*/
	

	function attachedfiles_insert ($db, $orderdetail_id, $af, $debug) {
	
			
		if ($debug === true) {
			echo "<h1>Attached Files Object</h1>";
			echo "<pre>";
			var_dump ($af);
			echo "</pre>";
		}

		
		// Create a list of the columns that will be inserted into.
		$columns = "[OrderDetail_ID], [URL]";


		// Create a list of the values that will be inserted.
		$values = $columns;
		$values = str_replace("[OrderDetail_ID]", "'" . mssql_addslashes(@$orderdetail_id) . "'", $values);
		$values = str_replace("[URL]", "'" . mssql_addslashes(@$af->URL) . "'", $values);
		
				
		// For any columns that we couldn't replace, set the values to NULL.		
		$values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);		
	
	
		// Build the complete "INSERT" statement.
		$insert_query = "INSERT INTO AttachedFiles (" . $columns . ") VALUES (" . $values . ")";
		
		
		if ($debug === true) {
			echo "<h1>AttachedFiles INSERT Statement Generated</h1>";
			echo "<pre>";
			echo $insert_query;
			echo "</pre>";
		}
		
		
		// Insert.
		mssql_query ($insert_query);		
		
		return;
	
	}

?>