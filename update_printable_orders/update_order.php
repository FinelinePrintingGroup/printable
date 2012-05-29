<?php

	/*

		Filename:



	*/

	function update_order ($db, $order, $new_status, $debug) {

		$sql = "Update Orders Set Status = [Status], CreditCard_AuthorizationNumber = [CreditCard_AuthorizationNumber], CreditCard_AuthorizationExpirationDate = [CreditCard_AuthorizationExpirationDate], CreditCard_ConfirmationNumber = [CreditCard_ConfirmationNumber] Where Order_ID = '" . mssql_addslashes($order->ID->_) . "'";
		
		$sql = str_replace("[Status]", "'" . mssql_addslashes(@$new_status) . "'", $sql);
		$sql = str_replace("[CreditCard_AuthorizationNumber]", "'" . mssql_addslashes(@$order->CreditCard->AuthorizationNumber) . "'", $sql);
		$sql = str_replace("[CreditCard_AuthorizationExpirationDate]", "'" . mssql_addslashes(@$order->CreditCard->AuthorizationExpirationDate) . "'", $sql);
		$sql = str_replace("[CreditCard_ConfirmationNumber]", "'" . mssql_addslashes(@$order->CreditCard->ConfirmationNumber) . "'", $sql);
	
		$sql = preg_replace('/\[[^\]]*\]/', 'NULL', $sql);		
		$result = mssql_query ($sql);
		
		if ($debug === true) {
			echo "<h1>Order Update Statement Generated</h1>";
			echo "<pre>";
			echo $sql;
			echo "</pre>";
			echo "<br />" . $result . "<br />";
		}

	}

?>