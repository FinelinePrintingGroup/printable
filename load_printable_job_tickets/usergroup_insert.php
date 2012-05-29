<?php

	/*
	
		Filename:
	
	*/
	

	function usergroup_insert ($db, $order_id, $usergroup, $debug) {
	
			
		if ($debug === true) {
			echo "<h1>User Group Object (passed to usergroup_insert)</h1>";
			echo "<pre>";
			var_dump ($usergroup);
			echo "</pre>";
		}

		
		// Create a list of the columns that will be inserted into.
		$columns = "[Order_ID], [UserGroup], [UserGroup_Type]";


		// Create a list of the values that will be inserted.
		$values = $columns;
		$values = str_replace("[Order_ID]", "'" . mssql_addslashes(@$order_id) . "'", $values);
		$values = str_replace("[UserGroup]", "'" . mssql_addslashes(@$usergroup->UserGroup->_) . "'", $values);
		$values = str_replace("[UserGroup_Type]", "'" . mssql_addslashes(@$usergroup->UserGroup->Type) . "'", $values);
				
		// For any columns that we couldn't replace, set the values to NULL.		
		$values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);		
	
	
		// Build the complete "INSERT" statement.
		$insert_query = "INSERT INTO Order_UserGroups (" . $columns . ") VALUES (" . $values . ")";
		
		
		if ($debug === true) {
			echo "<h1>Order_UserGroups INSERT Statement Generated</h1>";
			echo "<pre>";
			echo $insert_query;
			echo "</pre>";
		}
		
		
		// Insert.
		mssql_query ($insert_query);		
		
		return;
	
	}

?>