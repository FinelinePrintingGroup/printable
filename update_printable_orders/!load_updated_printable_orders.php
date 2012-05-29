<?php

	/*
	
		Filename:
		
		
	*/
	
	
	// Extend maximum execution time to 600 seconds.
	set_time_limit (900);	

	require_once ("../settings.php");
	require_once ("../custom_functions.php");
	require_once ("update_orderdetail.php");
	require_once ("update_kitdetail.php");
	require_once ("update_order.php");
	require_once ("update_jobticket.php");
	require_once ("../printable_to_logic/check_new_jobtickets.php");
	// Open a connection to SQL Server.
	$db = mssql_connect (SQL_Host, SQL_Login, SQL_Password) or die ("Unable to connect to SQL Server.");


		
	$soap_client = new SoapClient (Printable_URI_Get_Order, array('trace' => 1)) or die ("Unable to initialize SOAP client.");


		
		$format = 'm-j-Y'; 
		$date = date ( $format ); 
	
		$maxDate = date ( $format, strtotime ( '-3 month' . $date ) ); 
		
		
		$select_query = "SELECT DISTINCT Orders.OrderNumber FROM Orders inner join OrderDetails on OrderDetails.Order_ID = Orders.Order_ID where (OrderDetails.ClientStatus = 'OrderAccepted' or OrderDetails.ClientStatus = 'WorkInProgress') AND Orders.DateTime_Created > '" . $maxDate . "'";
		
		
		// Execute the query.
		$query = mssql_query ($select_query);	
		
		
		$counter = 0;
		// Iterate through returned records
		do {
		    while ($row = mssql_fetch_row($query)) {
		        // Handle record ...
		      $request->OrderRequestByOrderNumber->PartnerCredentials->Token = Printable_Token_Get_Order;
		    	$request->OrderRequestByOrderNumber->OrderNumber = $row[0];
		
				// Call the GetOrdersByDate method and store the results.
				$result = $soap_client->GetOrdersByOrderNumber ($request);
				echo '<br><br>';				
				echo 'Response dump for order number ' . $row[0] . '<br/>';				
				
				
				$orders = $result->GetOrdersByOrderNumberResult->GetOrdersResponse->Orders->Order;				
				if (isset($orders->OrderDetails->OrderDetail))
				{				
				$orderdetails = $orders->OrderDetails->OrderDetail;
				
				// If order details is not an array (which indicates that we have a single orderdetail object)...
				if (! is_array($orderdetails) ) {
					// Get the single object as an array.
					$new_orderdetails[] = $orderdetails;
					unset ($orderdetails);
					$orderdetails = $new_orderdetails;
					unset ($new_orderdetails);
				}		
				
				//echo '<br>' . var_dump($orderdetails) . '<br><br>';
				$allupdated = true;
				$allsame = true;
				$allskipped = true;
				$runningstatus = 'none';
				$loweststatus = 'none';
				// Loop over the order details array...
				foreach ($orderdetails as $orderdetail) {
					//echo '<br>' . var_dump($orderdetail) . '<br><br>';
					$getorderdetails_query = "Select ClientStatus from OrderDetails WHERE OrderDetail_ID = '" . mssql_addslashes($orderdetail->ID->_) . "'";
					// Execute the query.
					$orderdeatils_query = mssql_query ($getorderdetails_query);									
					$record = mssql_fetch_array ($orderdeatils_query);		
					$clientstatus = $record["ClientStatus"];
					mssql_free_result($orderdeatils_query);	
					
					if ($runningstatus == 'none')
							{
								$runningstatus = $orderdetail->ClientStatus->Value;
								}
									
					if ($clientstatus != $orderdetail->ClientStatus->Value)
					{
						
						//***UPDATE RECORD pass $orderdetail object
						update_orderdetail ($db, $orderdetail, Debug_Mode);
						//*** UPDATE KIT ITEMS with $orderdetail->ID->_ to status
						update_kitdetail ($db, $orderdetail,  Debug_Mode);						
						echo 'UPDATING Record ' . $orderdetail->ID->_ . ': from ' . $clientstatus . ' to ' . $orderdetail->ClientStatus->Value;
						echo '<br />';							
							if ($orderdetail->ClientStatus->Value == 'WorkInProgress'){
								$loweststatus = 'WorkInProgress';
							}
						elseif ($loweststatus == 'none') {
								$loweststatus = $orderdetail->ClientStatus->Value;
							}
							if ($runningstatus == $orderdetail->ClientStatus->Value)
							{
								
							}
							else {
								$allsame = false;
								}
						$allskipped = false;
					}
					else {	
							echo 'Record skipped: ' . 	$orderdetail->ID->_ . ': from ' . $clientstatus . ' to ' . $orderdetail->ClientStatus->Value;				
							echo '<br />';							
							if ($runningstatus == $clientstatus)
							{
								
								}
							else {
									$allsame = false;
								}								
							$allupdated = false;
						}	
								
				}
				
				
				if ($allupdated == true || $allsame == true)
						{
							if ($allskipped == false){
								echo 'UPDATING JT and ORDERS<br/>';							
								echo '<br />';								
								//***** update order and jobticket status to $loweststatus
								update_order ($db, $orders, $loweststatus, Debug_Mode);
								
								update_jobticket ($db, $orders, $loweststatus, Debug_Mode);							
								
								// overwrite printable response text file of order dump
								ob_start ();
								var_dump ($orders);
								$var = ob_get_contents ();
								ob_end_clean();
								$filename = preg_replace("/[^a-z0-9-]/", "_", strtolower($orders->OrderNumber));
								file_put_contents("../printable_responses/printable_order_" . $filename . ".txt", $var);
								unset ($var);
								unset ($filename);	
							}							
						}
							
											
				}
				else { 
					echo '<br/>Order not set<br/>';				
				}

				echo 'end order dump <br />';
		    	$counter = $counter + 1;
		    	unset($request);
		    	unset($result);
		    	unset($orders);
		    	unset($orderdetails);
		    } 
		} while (mssql_next_result($query));
		
		// Clean up
		mssql_free_result($query);				
		//echo '<br/>' . $counter;
		
		// Check for new job tickets to insert into Logic.
		//check_new_jobtickets ($db, Debug_Mode);	
		
	
?>	
