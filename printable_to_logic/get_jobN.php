<?php

	/*

		Filename:


	*/
	function get_jobN ($dbLogic) {
	
		$query = "SELECT MAX(JobN) AS Max_JobN FROM OpenJob";
		
		$result = mssql_query ($query, $dbLogic);
		
		$record = mssql_fetch_array ($result);
		
		$max_JobN = $record["Max_JobN"];
		$jobn = $max_JobN + 1;
		//echo $jobn;
		
		mssql_free_result($result);
		unset($query);
		unset($max_JobN);
		unset($record);
	return $jobn;
}

?>