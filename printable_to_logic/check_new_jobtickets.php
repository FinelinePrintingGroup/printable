<?php
	/*
		Filename:
	*/

	function check_new_jobtickets ($db, $debug) 
        {
		require_once ("insert_logic.php");
		
		$sql = "Select Job_Ticket_ID, JobTicketNumber from Job_Tickets WHERE In_Logic = 0"; 
			
		$query = mssql_query ($sql, $db);		
		if (!$query)
		{
			echo "MSSQL Query failed: " . mssql_get_last_message() . "<br />\n";			
		}
		else
		{
			// Iterate through returned records
			 while ($row = mssql_fetch_array($query)) {
					
					// Handle record ...
					insert_logic($db, $row['JobTicketNumber'], $debug);				
					
					//Update jobticket to inserted
					$sqlupdate = "Update Job_Tickets Set In_Logic = 1 Where Job_Ticket_ID = '" . mssql_addslashes($row['Job_Ticket_ID']) . "'";
					$resultupdate = mssql_query ($sqlupdate, $db);
					unset($sqlupdate);
					unset($resultupdate);
			} 		
		}		
		if ($debug === true) {
			echo "<h1>Job Tickets inserted into Logic</h1>";
			echo "<pre>";
			echo $sql;
			echo "</pre>";
			echo "<br />" . $query . "<br />";
		}
	}
?>