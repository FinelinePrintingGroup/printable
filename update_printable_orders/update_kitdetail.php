<?php

	/*

		Filename:

	
	*/

	function update_kitdetail ($db, $orderdetail, $debug) {

		if (isset($orderdetail->Kit->KitDetail))
		{
			$kitdetails = $orderdetail->Kit->KitDetail;
			if (! is_array($kitdetails) ) {
						// Get the single object as an array.
						$new_kitdetails[] = $kitdetails;
						unset ($kitdetails);
						$kitdetails = $new_kitdetails;
						unset ($new_kitdetails);
					}		
			foreach ($kitdetails as $kitdetail) {	
			
				$sql = "Update KitDetails Set QuantityShipped = [QuantityShipped], SupplierWorkOrder_ID = [SupplierWorkOrder_ID], SupplierWorkOrder_Name = [SupplierWorkOrder_Name], Shipping_Date = [Shipping_Date], Shipping_DateShipped = [Shipping_DateShipped], ShippingTrackingNumber = [ShippingTrackingNumber], ClientStatus = [ClientStatus], ClientStatus_Date = [ClientStatus_Date], SellerStatus = [SellerStatus], SellerStatus_Date = [SellerStatus_Date], SupplierStatus = [SupplierStatus], SupplierStatus_Date = [SupplierStatus_Date], CreditCardSettlement_ID = [CreditCardSettlement_ID], CreditCardSettlement_Number = [CreditCardSettlement_Number], CreditCardSettlement_Date = [CreditCardSettlement_Date], CreditCardSettlement_User_ID = [CreditCardSettlement_User_ID], CreditCardSettlement_UserName = [CreditCardSettlement_UserName], RequisitionStatus = [RequisitionStatus] Where KitDetail_ID = '" . mssql_addslashes($kitdetail->ID->_) . "'";
				
				$sql = str_replace("[QuantityShipped]", "'" . @$orderdetail->QuantityShipped . "'", $sql);
				$sql = str_replace("[SupplierWorkOrder_ID]", "'" . mssql_addslashes(@$orderdetail->SupplierWorkOrder->ID->_) . "'", $sql);
				$sql = str_replace("[SupplierWorkOrder_Name]", "'" . mssql_addslashes(@$orderdetail->SupplierWorkOrder->Name) . "'", $sql);
				if (isset($orderdetail->Shipping->Date))
					{		
						$tempshippingdate = $orderdetail->Shipping->Date;
						$pos = strpos($tempshippingdate, ".");			
						if ($pos !== false)
						{
							$tempshippingdate = substr($tempshippingdate, 0, $pos);
						}
						$sql = str_replace("[Shipping_Date]", "'" . mssql_addslashes(@$tempshippingdate) . "'", $sql);
						unset($tempshippingdate);
						unset($pos);
					}
					else{		
						$sql = str_replace("[Shipping_Date]", "'" . mssql_addslashes(@$orderdetail->Shipping->Date) . "'", $sql);
					}
				$sql = str_replace("[Shipping_DateShipped]", "'" . mssql_addslashes(@$orderdetail->Shipping->DateShipped) . "'", $sql);
				$sql = str_replace("[ShippingTrackingNumber]", "'" . mssql_addslashes(@$orderdetail->Shipping->TrackingNumber) . "'", $sql);
				$sql = str_replace("[ClientStatus]", "'" . mssql_addslashes(@$orderdetail->ClientStatus->Value) . "'", $sql);
				$sql = str_replace("[ClientStatus_Date]", "'" . mssql_addslashes(@$orderdetail->ClientStatus->Date) . "'", $sql);
				$sql = str_replace("[SellerStatus]", "'" . mssql_addslashes(@$orderdetail->SellerStatus->Value) . "'", $sql);
				$sql = str_replace("[SellerStatus_Date]", "'" . mssql_addslashes(@$orderdetail->SellerStatus->Date) . "'", $sql);
				$sql = str_replace("[SupplierStatus]", "'" . mssql_addslashes(@$orderdetail->SupplierStatus->Value) . "'", $sql);
				$sql = str_replace("[SupplierStatus_Date]", "'" . mssql_addslashes(@$orderdetail->SupplierStatus->Date) . "'", $sql);
				$sql = str_replace("[CreditCardSettlement_ID]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->ID->_) . "'", $sql);
				$sql = str_replace("[CreditCardSettlement_Number]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->Number) . "'", $sql);
				$sql = str_replace("[CreditCardSettlement_Date]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->Date) . "'", $sql);
				$sql = str_replace("[CreditCardSettlement_User_ID]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->UserID->_) . "'", $sql);
				$sql = str_replace("[CreditCardSettlement_UserName]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->UserName) . "'", $sql);
				$sql = str_replace("[RequisitionStatus]", "'" . mssql_addslashes(@$orderdetail->RequisitionStatus) . "'", $sql);	
			
			
				$sql = preg_replace('/\[[^\]]*\]/', 'NULL', $sql);		
				$result = mssql_query ($sql);
				
				if ($debug === true) {
					echo "<h1>KitDetail Update Statement Generated</h1>";
					echo "<pre>";
					echo $sql;
					echo "</pre>";
					echo "<br />" . $result . "<br />";
				}
				unset($sql);
				unset($result);
				
			}
			unset($kitdetails);
		}
		
	}

?>