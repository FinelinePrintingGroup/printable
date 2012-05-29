<?php

	/*
	
		Filename:
		
	    Test insertion
	*/
	
	
	// Extend maximum execution time to 600 seconds.
	set_time_limit (900);	

	require_once ("../settings.php");
	require_once ("../custom_functions.php");
	
	require_once ("check_new_jobtickets.php");
	// Open a connection to SQL Server.
	//$db = mssql_connect (SQL_Host, SQL_Login, SQL_Password) or die ("Unable to connect to SQL Server.");

		
	// Check for new job tickets to insert into Logic.
	$dbLogic = mssql_connect (Logic_SQL_Host, Logic_SQL_Login, Logic_SQL_Password) or die ("Unable to connect to SQL Server.");
	
	echo 'connected';
		//$jobN = get_jobN($dbLogic); //get the next JobN
		
	
?>	
