<?php
	/*
		Filename:	
	*/
		
	// Extend maximum execution time to 800 seconds.
	set_time_limit (1200);	

	require_once ("../settings.php");
	require_once ("../custom_functions.php");
	require_once ("getFileFromURL.php");
	error_reporting(~E_NOTICE);
	
	// Open a connection to SQL Server.
	$db = mssql_connect (SQL_Host, SQL_Login, SQL_Password) or die ("Unable to connect to SQL Server.");
	
	$sql = "Select OrderDetail_ID, SupplierWorkOrder_Name, OutputFileURL, FileDownloaded, ProductType from OrderDetails WHERE FileDownloaded = 0 AND DATEDIFF(day, DateTime_Created, GETDATE()) <= 5"; 
			
        $query = mssql_query ($sql, $db);		
        if (!$query)
        {
            echo "MSSQL Query failed: " . mssql_get_last_message() . "<br />\n";			
        }
        else
        {
            // Iterate through returned records
            while ($row = mssql_fetch_array($query)) 
            {
                // file from urls
                $outputfileurl = $row['OutputFileURL'];
                if (!empty($outputfileurl))
                {		
                    // Handle record ...
                    getFileFromURL($row['OutputFileURL'], $row['SupplierWorkOrder_Name'], $row['OrderDetail_ID'], $db);				
                    //echo '<br>' . $row['SupplierWorkOrder_Name'] . '<br>';
                }
                else
                {
                    $productType = $row['ProductType'];
                    
                    if (($productType == 'Versioned' ) || ($productType == 'Variable'))
                    {
                        $od_id = $row['OrderDetail_ID'];
                        error_log('OD_ID: ' . $od_id . ' - File download error in !get_job_ticket_files.php - Versioned/Variable order with no FileURL');
                        
                        //INSERT DELETE STATEMENTS HERE FOR BAD DATA.
                    }
                    else
                    {
                        $jt_num = $row['SupplierWorkOrder_Name'];
                        error_log($jt_num . ' does not need to download files');
                    }
                }
            } 		
        }	
?>	
