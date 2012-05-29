<?php

	/*
	
		Filename:
		
			load_printable_job_tickets/!load_printable_job_tickets.php


	*/
	
	
	// Extend maximum execution time to 800 seconds.
	set_time_limit (1200);	


	require_once ("../settings.php");
	require_once ("../custom_functions.php");
	require_once ("get_max_job_ticket_create_date.php");
	require_once ("get_job_tickets_by_date.php");			
	require_once ("job_ticket_insert.php");
	require_once ("../printable_to_logic/check_new_jobtickets.php");
	
	// Open a connection to SQL Server.
	$db = mssql_connect (SQL_Host, SQL_Login, SQL_Password) or die ("Unable to connect to SQL Server.");
	

	// Get the create date of the last job ticket received.
	$start_date = get_max_job_ticket_create_date($db, Debug_Mode);
	//$start_date = "9/27/2011";
	// Get any new job tickets received.
	$new_job_tickets = get_job_tickets_by_date ($start_date, date("c"), Debug_Mode);			

	// Loop over the new job tickets...
	$new_job_tickets_list = null;
	if ($new_job_tickets != null) {
		foreach ($new_job_tickets as $job_ticket) {
		
			// Save the job ticket in a text file.
			ob_start ();
			var_dump ($job_ticket);
			$var = ob_get_contents ();
			ob_end_clean();
			$filename = preg_replace("/[^a-z0-9-]/", "_", strtolower($job_ticket->JobTicketNumber));
			file_put_contents("../printable_responses/printable_job_ticket_" . $filename . ".txt", $var);	
			
			// Insert the new jt.
			$result = job_ticket_insert ($db, $job_ticket, Debug_Mode);
			
						
			// If the jt was inserted...
			if ($result != null) {
				$new_job_tickets_list .= "<li>" . $job_ticket->JobTicketNumber . "</li>";				
			}
					
		}	
	}
	
	// Check for new job tickets to insert into Logic.
	check_new_jobtickets ($db, Debug_Mode);	
		
		
	// Display response to the user...
	echo "<p>";
	echo "<h1>New Job Tickets Received Since " . date("r", strtotime($start_date)) . "</h1>";
	echo "</p>";	
	
	echo "<p>";
	if ($new_job_tickets_list != null) {
		echo "<ul>";
		echo $new_job_tickets_list;
		echo "</ul>";
	} else {
		echo "None.";
	}
	echo "</p>";
	
?>	
