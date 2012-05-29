<?php

	/*
	
		Filename:
		
		


	*/
	

	function orderdetailkit_insert ($db, $orderdetail_id, $kit, $debug) {

		require_once ("kittemplatefields_insert.php");		
		
		if ($debug === true) {
			echo "<h1>OrderDetailKit Object (passed to orderdetailkit_insert)</h1>";
			echo "<pre>";
			//var_dump (@$kit);
			echo "</pre>";
		}
		
			
		// Create a list of the columns that will be inserted into.
		$columns = "[OrderDetail_ID], [KitDetail_ID], [KitDetail_Type], [OrderType], [User_ID], [User_ID_Type], [User_FirstName], [User_LastName], [User_Login_ID], [User_Email], [Product_ID], [Product_ID_Type], [ProductName], [ProductDescription], [SKU_ID], [SKU_ID_Type], [SKU_Name], [SKUDescription], [Quantity], [QuantityShipped], [Price_Cost_Customer], [Price_Cost_Customer_Currency], [Price_Cost_Seller], [Price_Cost_Seller_Currency], [Price_Cost_Shipping], [Price_Cost_Shipping_Currency], [Price_Cost_Unit], [Price_Cost_Unit_Currency], [Price_Cost_CustomerDiscount], [Price_Cost_CustomerDiscount_Currency], [Price_Cost_CustomerMisc], [Price_Cost_CustomerMisc_Currency], [Price_Cost_SellerMisc], [Price_Cost_SellerMisc_Currency], [Price_Cost_SellerStoreDiscount], [Price_Cost_SellerStoreDiscount_Currency], [Price_Cost_SellerShipping], [Price_Cost_SellerShipping_Currency], [Price_Cost_Postage], [Price_Cost_Postage_Currency], [Price_Tax_CustomerSales], [Price_Tax_CustomerSales_Currency], [Price_Tax_DirectAcctSales], [Price_Tax_DirectAcctSales_Currency], [Price_Tax_City], [Price_Tax_City_Currency], [Price_Tax_County], [Price_Tax_County_Currency], [Price_Tax_State], [Price_Tax_State_Currency], [Price_Tax_District], [Price_Tax_District_Currency], [Price_Tax_CityFreight], [Price_Tax_CityFreight_Currency], [Price_Tax_CountyFreight], [Price_Tax_CountyFreight_Currency], [Price_Tax_StateFreight], [Price_Tax_StateFreight_Currency], [Price_Tax_DistrictFreight], [Price_Tax_DistrictFreight_Currency], [Price_Tax_TotalFreight], [Price_Tax_TotalFreight_Currency], [Price_Tax_TaxableSalesAmount], [Price_Tax_TaxableSalesAmount_Currency], [Price_Tax_ExemptSalesAmount], [Price_Tax_ExemptSalesAmount_Currency], [Price_Tax_NonTaxableSalesAmount], [Price_Tax_NonTaxableSalesAmount_Currency], [Price_Tax_CityName], [Price_Tax_CountyName], [Price_Tax_StateName], [Price_Tax_Zip], [Department_ID], [Department_ID_Type], [Department_Name], [Department_Number], [SupplierWorkOrder_ID], [SupplierWorkOrder_ID_Type], [SupplierWorkOrder_Name], [Supplier_ID], [Supplier_ID_Type], [Supplier_Name], [OutputFileURL], [Shipping_Date], [Shipping_DateShipped], [Shipping_Method], [Shipping_Instructions], [ShippingAddress_ID], [ShippingAddress_ID_Type], [ShippingAddress_Description], [ShippingAddress_Address1], [ShippingAddress_Address2], [ShippingAddress_Address3], [ShippingAddress_Address4], [ShippingAddress_City], [ShippingAddress_State], [ShippingAddress_Zip], [ShippingAddress_Country], [ShippingAddress_PhoneNumber], [ShippingAddress_FaxNumber], [ShippingAddress_CompanyName], [ShippingAddress_Attn], [ShippingTrackingNumber], [ClientStatus], [ClientStatus_Date], [SellerStatus], [SellerStatus_Date], [SupplierStatus], [SupplierStatus_Date], [CreditCardSettlement_ID], [CreditCardSettlement_ID_Type], [CreditCardSettlement_Number], [CreditCardSettlement_Date], [CreditCardSettlement_User_ID], [CreditCardSettlement_User_ID_Type], [CreditCardSettlement_UserName], [OrderNumber], [ClientPONumber], [SalesWorkOrder_ID], [SalesWorkOrder_ID_Type], [ProductType], [Postage_Method], [Postage_Cost], [Postage_Cost_Currency], [DownloadURL], [PageCount], [CatalogTreeNodeExternalId], [RequisitionStatus], [ApproverUser_ID], [ApproverUser_ID_Type], [ApproverUser_Name], [ApproverUser_FirstName], [ApproverUser_LastName], [ApproverUser_Login_ID], [ApproverUser_Email], [Explanation], [ImposedUsingDefaultURL], [ReqUser_ID], [ReqUser_ID_Type], [ReqUser_Name], [ReqUser_FirstName], [ReqUser_LastName], [ReqUser_Login_ID], [ReqUser_Email], [SKUInventorySettings_Unit], [SKUInventorySettings_QtyPerUnit], [SKUInventorySettings_Warehouse], [SKUInventorySettings_Location], [ListVendor_ID], [ListVendor_ID_Type], [ListVendor_Name], [ListVendor_CustomerCost], [ListVendor_CustomerCost_Currency], [Impersonator_ID], [Impersonator_ID_Type], [Impersonator_Name], [Impersonator_FirstName], [Impersonator_LastName], [Impersonator_Login_ID], [Impersonator_Email], [UserLiteType_ID], [UserLiteType_ID_Type], [UserLiteType_Login_ID], [UserLiteType_Name], [UserLiteType_FirstName], [UserLiteType_LastName]";


		// Create a list of the values that will be inserted.
		$values = $columns;
		$values = str_replace("[OrderDetail_ID]", "'" . mssql_addslashes($orderdetail_id) . "'", $values);
		$values = str_replace("[KitDetail_ID]", "'" . mssql_addslashes(@$kit->ID->_) . "'", $values);
		$values = str_replace("[KitDetail_Type]", "'" . mssql_addslashes(@$kit->ID->type) . "'", $values);
		$values = str_replace("[OrderType]", "'" . mssql_addslashes(@$kit->OrderType) . "'", $values);
		$values = str_replace("[User_ID]", "'" . mssql_addslashes(@$kit->User->ID->_) . "'", $values);
		$values = str_replace("[User_ID_Type]", "'" . mssql_addslashes(@$kit->User->ID->type) . "'", $values);
		$values = str_replace("[User_FirstName]", "'" . mssql_addslashes(@$kit->User->FirstName) . "'", $values);
		$values = str_replace("[User_LastName]", "'" . mssql_addslashes(@$kit->User->LastName) . "'", $values);
		$values = str_replace("[User_Login_ID]", "'" . mssql_addslashes(@$kit->User->LoginID) . "'", $values);
		$values = str_replace("[User_Email]", "'" . mssql_addslashes(@$kit->User->Email) . "'", $values);
		$values = str_replace("[Product_ID]", "'" . mssql_addslashes(@$kit->ProductID->_) . "'", $values);
		$values = str_replace("[Product_ID_Type]", "'" . mssql_addslashes(@$kit->ProductID->type) . "'", $values);
		$values = str_replace("[ProductName]", "'" . mssql_addslashes(@$kit->ProductName) . "'", $values);
		$values = str_replace("[ProductDescription]", "'" . mssql_addslashes(@$kit->ProductDescription) . "'", $values);
		$values = str_replace("[SKU_ID]", "'" . mssql_addslashes(@$kit->SKU->ID->_) . "'", $values);
		$values = str_replace("[SKU_ID_Type]", "'" . mssql_addslashes(@$kit->SKU->ID->type) . "'", $values);
		$values = str_replace("[SKU_Name]", "'" . mssql_addslashes(@$kit->SKU->Name) . "'", $values);
		$values = str_replace("[SKUDescription]", "'" . mssql_addslashes(@$kit->SKUDescription) . "'", $values);
		$values = str_replace("[Quantity]", @$kit->Quantity, $values);
		$values = str_replace("[QuantityShipped]", @$kit->QuantityShipped, $values);
		$values = str_replace("[Price_Cost_Customer]", @$kit->Price->Cost->Customer->_, $values);
		$values = str_replace("[Price_Cost_Customer_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->Customer->Currency) . "'", $values);
		$values = str_replace("[Price_Cost_Seller]", @$kit->Price->Cost->Seller->_, $values);
		$values = str_replace("[Price_Cost_Seller_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->Seller->Currency) . "'", $values);
		$values = str_replace("[Price_Cost_Shipping]", @$kit->Price->Cost->Shipping->_, $values);
		$values = str_replace("[Price_Cost_Shipping_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->Shipping->Currency) . "'", $values);
		$values = str_replace("[Price_Cost_Unit]", @$kit->Price->Cost->Unit->_, $values);
		$values = str_replace("[Price_Cost_Unit_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->Unit->Currency) . "'", $values);
		$values = str_replace("[Price_Cost_CustomerDiscount]", @$kit->Price->Cost->CustomerDiscount->_, $values);
		$values = str_replace("[Price_Cost_CustomerDiscount_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->CustomerDiscount->Currency) . "'", $values);
		$values = str_replace("[Price_Cost_CustomerMisc]", @$kit->Price->Cost->CustomerMisc->_, $values);
		$values = str_replace("[Price_Cost_CustomerMisc_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->CustomerMisc->Currency) . "'", $values);		
		$values = str_replace("[Price_Cost_SellerMisc]", @$kit->Price->Cost->SellerMisc->_, $values);
		$values = str_replace("[Price_Cost_SellerMisc_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->SellerMisc->Currency) . "'", $values);		
		$values = str_replace("[Price_Cost_SellerStoreDiscount]", @$kit->Price->Cost->SellerStoreDiscount->_, $values);
		$values = str_replace("[Price_Cost_SellerStoreDiscount_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->SellerStoreDiscount->Currency) . "'", $values);		
		$values = str_replace("[Price_Cost_SellerShipping]", @$kit->Price->Cost->SellerShipping->_, $values);
		$values = str_replace("[Price_Cost_SellerShipping_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->SellerShipping->Currency) . "'", $values);		
		$values = str_replace("[Price_Cost_Postage]", @$kit->Price->Cost->Postage->_, $values);
		$values = str_replace("[Price_Cost_Postage_Currency]", "'" . mssql_addslashes(@$kit->Price->Cost->Postage->Currency) . "'", $values);		
		$values = str_replace("[Price_Tax_CustomerSales]", @$kit->Price->Tax->CustomerSales->_, $values);
		$values = str_replace("[Price_Tax_CustomerSales_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->CustomerSales->Currency) . "'", $values);		
		$values = str_replace("[Price_Tax_DirectAcctSales]", @$kit->Price->Tax->DirectAcctSales->_, $values);
		$values = str_replace("[Price_Tax_DirectAcctSales_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->DirectAcctSales->Currency) . "'", $values);		
		$values = str_replace("[Price_Tax_City]", @$kit->Price->Tax->City->_, $values);
		$values = str_replace("[Price_Tax_City_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->City->Currency) . "'", $values);		
		$values = str_replace("[Price_Tax_County]", @$kit->Price->Tax->County->_, $values);
		$values = str_replace("[Price_Tax_County_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->County->Currency) . "'", $values);		
		$values = str_replace("[Price_Tax_State]", @$kit->Price->Tax->State->_, $values);
		$values = str_replace("[Price_Tax_State_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->State->Currency) . "'", $values);		
		$values = str_replace("[Price_Tax_District]", @$kit->Price->Tax->District->_, $values);
		$values = str_replace("[Price_Tax_District_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->District->Currency) . "'", $values);	
		$values = str_replace("[Price_Tax_CityFreight]", @$kit->Price->Tax->CityFreight->_, $values);
		$values = str_replace("[Price_Tax_CityFreight_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->CityFreight->Currency) . "'", $values);	
		$values = str_replace("[Price_Tax_CountyFreight]", @$kit->Price->Tax->CountyFreight->_, $values);
		$values = str_replace("[Price_Tax_CountyFreight_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->CountyFreight->Currency) . "'", $values);
		$values = str_replace("[Price_Tax_StateFreight]", @$kit->Price->Tax->StateFreight->_, $values);
		$values = str_replace("[Price_Tax_StateFreight_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->StateFreight->Currency) . "'", $values);
		$values = str_replace("[Price_Tax_DistrictFreight]", @$kit->Price->Tax->DistrictFreight->_, $values);
		$values = str_replace("[Price_Tax_DistrictFreight_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->DistrictFreight->Currency) . "'", $values);
		$values = str_replace("[Price_Tax_TotalFreight]", @$kit->Price->Tax->TotalFreight->_, $values);
		$values = str_replace("[Price_Tax_TotalFreight_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->TotalFreight->Currency) . "'", $values);
		$values = str_replace("[Price_Tax_TaxableSalesAmount]", @$kit->Price->Tax->TaxableSalesAmount->_, $values);
		$values = str_replace("[Price_Tax_TaxableSalesAmount_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->TaxableSalesAmount->Currency) . "'", $values);
		$values = str_replace("[Price_Tax_ExemptSalesAmount]", @$kit->Price->Tax->ExemptSalesAmount->_, $values);
		$values = str_replace("[Price_Tax_ExemptSalesAmount_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->ExemptSalesAmount->Currency) . "'", $values);
		$values = str_replace("[Price_Tax_NonTaxableSalesAmount]", @$kit->Price->Tax->NonTaxableSalesAmount->_, $values);
		$values = str_replace("[Price_Tax_NonTaxableSalesAmount_Currency]", "'" . mssql_addslashes(@$kit->Price->Tax->NonTaxableSalesAmount->Currency) . "'", $values);		
		$values = str_replace("[Price_Tax_CityName]", "'" . mssql_addslashes(@$kit->Price->Tax->CityName) . "'", $values);
		$values = str_replace("[Price_Tax_CountyName]", "'" . mssql_addslashes(@$kit->Price->Tax->CountyName) . "'", $values);
		$values = str_replace("[Price_Tax_StateName]", "'" . mssql_addslashes(@$kit->Price->Tax->StateName) . "'", $values);
		$values = str_replace("[Price_Tax_Zip]", "'" . mssql_addslashes(@$kit->Price->Tax->Zip) . "'", $values);
		$values = str_replace("[Department_ID]", "'" . mssql_addslashes(@$kit->Department->ID->_) . "'", $values);
		$values = str_replace("[Department_ID_Type]", "'" . mssql_addslashes(@$kit->Department->ID->type) . "'", $values);
		$values = str_replace("[Department_Name]", "'" . mssql_addslashes(@$kit->Department->Name) . "'", $values);
		$values = str_replace("[Department_Number]", "'" . mssql_addslashes(@$kit->Department->Number) . "'", $values);		
		//if (isset(@$kit->SupplierWorkOrder)) {
			$values = str_replace("[SupplierWorkOrder_ID]", "'" . mssql_addslashes(@$kit->SupplierWorkOrder->ID->_) . "'", $values);
			$values = str_replace("[SupplierWorkOrder_ID_Type]", "'" . mssql_addslashes(@$kit->SupplierWorkOrder->ID->type) . "'", $values);
			$values = str_replace("[SupplierWorkOrder_Name]", "'" . mssql_addslashes(@$kit->SupplierWorkOrder->Name) . "'", $values);
		//}
		//if (isset(@$kit->Supplier)) {
			$values = str_replace("[Supplier_ID]", "'" . mssql_addslashes(@$kit->Supplier->ID->_) . "'", $values);
			$values = str_replace("[Supplier_ID_Type]", "'" . mssql_addslashes(@$kit->Supplier->ID->type) . "'", $values);
			$values = str_replace("[Supplier_Name]", "'" . mssql_addslashes(@$kit->Supplier->Name) . "'", $values);
		//}
		//if (isset(@$kit->OutputFileURL)) {
			$values = str_replace("[OutputFileURL]", "'" . mssql_addslashes(@$kit->OutputFileURL->URL) . "'", $values);
		//}
		if (isset($kit->Shipping->Date))
		{
			$tempshippingdate = $kit->Shipping->Date;
			$pos = strpos($tempshippingdate, '.');
			if ($pos !== false)
			{
				$tempshippingdate = substr($tempshippingdate, 0, ($pos - 1));
			}
			$values = str_replace("[Shipping_Date]", "'" . mssql_addslashes(@$tempshippingdate) . "'", $values);
		}
		else{
			$values = str_replace("[Shipping_Date]", "'" . mssql_addslashes(@$kit->Shipping->Date) . "'", $values);
		}
		$values = str_replace("[Shipping_DateShipped]", "'" . mssql_addslashes(@$kit->Shipping->DateShipped) . "'", $values);
		//if (isset(@$kit->Shipping->Method)) {
			$values = str_replace("[Shipping_Method]", "'" . mssql_addslashes(@$kit->Shipping->Method) . "'", $values);
		//}
		$values = str_replace("[Shipping_Instructions]", "'" . mssql_addslashes(@$kit->Shipping->Instructions) . "'", $values);
		$values = str_replace("[ShippingAddress_ID]", "'" . mssql_addslashes(@$kit->Shipping->Address->ID->_) . "'", $values);
		$values = str_replace("[ShippingAddress_ID_Type]", "'" . mssql_addslashes(@$kit->Shipping->Address->ID->type) . "'", $values);
		$values = str_replace("[ShippingAddress_Description]", "'" . mssql_addslashes(@$kit->Shipping->Address->Description) . "'", $values);
		$values = str_replace("[ShippingAddress_Address1]", "'" . mssql_addslashes(@$kit->Shipping->Address->Address1) . "'", $values);
		$values = str_replace("[ShippingAddress_Address2]", "'" . mssql_addslashes(@$kit->Shipping->Address->Address2) . "'", $values);
		$values = str_replace("[ShippingAddress_Address3]", "'" . mssql_addslashes(@$kit->Shipping->Address->Address3) . "'", $values);
		$values = str_replace("[ShippingAddress_Address4]", "'" . mssql_addslashes(@$kit->Shipping->Address->Address4) . "'", $values);
		$values = str_replace("[ShippingAddress_City]", "'" . mssql_addslashes(@$kit->Shipping->Address->City) . "'", $values);
		$values = str_replace("[ShippingAddress_State]", "'" . mssql_addslashes(@$kit->Shipping->Address->State) . "'", $values);
		$values = str_replace("[ShippingAddress_Zip]", "'" . mssql_addslashes(@$kit->Shipping->Address->Zip) . "'", $values);
		$values = str_replace("[ShippingAddress_Country]", "'" . mssql_addslashes(@$kit->Shipping->Address->Country) . "'", $values);
		$values = str_replace("[ShippingAddress_PhoneNumber]", "'" . mssql_addslashes(@$kit->Shipping->Address->PhoneNumber) . "'", $values);
		$values = str_replace("[ShippingAddress_FaxNumber]", "'" . mssql_addslashes(@$kit->Shipping->Address->FaxNumber) . "'", $values);
		$values = str_replace("[ShippingAddress_CompanyName]", "'" . mssql_addslashes(@$kit->Shipping->Address->CompanyName) . "'", $values);
		$values = str_replace("[ShippingAddress_Attn]", "'" . mssql_addslashes(@$kit->Shipping->Address->Attn) . "'", $values);
		//if (isset(@$kit->Shipping->TrackingNumber)) {
			$values = str_replace("[ShippingTrackingNumber]", "'" . mssql_addslashes(@$kit->Shipping->TrackingNumber) . "'", $values);
		//}
		$values = str_replace("[ClientStatus]", "'" . mssql_addslashes(@$kit->ClientStatus->Value) . "'", $values);
		$values = str_replace("[ClientStatus_Date]", "'" . mssql_addslashes(@$kit->ClientStatus->Date) . "'", $values);
		$values = str_replace("[SellerStatus]", "'" . mssql_addslashes(@$kit->SellerStatus->Value) . "'", $values);
		$values = str_replace("[SellerStatus_Date]", "'" . mssql_addslashes(@$kit->SellerStatus->Date) . "'", $values);		
		$values = str_replace("[SupplierStatus]", "'" . mssql_addslashes(@$kit->SupplierStatus->Value) . "'", $values);
		$values = str_replace("[SupplierStatus_Date]", "'" . mssql_addslashes(@$kit->SupplierStatus->Date) . "'", $values);			
		//if (isset(@$kit->CreditCardSettlement)) {
			$values = str_replace("[CreditCardSettlement_ID]", "'" . mssql_addslashes(@$kit->CreditCardSettlement->ID->_) . "'", $values);
			$values = str_replace("[CreditCardSettlement_ID_Type]", "'" . mssql_addslashes(@$kit->CreditCardSettlement->ID->type) . "'", $values);
			$values = str_replace("[CreditCardSettlement_Number]", "'" . mssql_addslashes(@$kit->CreditCardSettlement->Number) . "'", $values);
			$values = str_replace("[CreditCardSettlement_Date]", "'" . mssql_addslashes(@$kit->CreditCardSettlement->Date) . "'", $values);
			$values = str_replace("[CreditCardSettlement_User_ID]", "'" . mssql_addslashes(@$kit->CreditCardSettlement->UserID->_) . "'", $values);
			$values = str_replace("[CreditCardSettlement_User_ID_Type]", "'" . mssql_addslashes(@$kit->CreditCardSettlement->UserID->type) . "'", $values);
			$values = str_replace("[CreditCardSettlement_UserName]", "'" . mssql_addslashes(@$kit->CreditCardSettlement->UserName) . "'", $values);
		//}
		$values = str_replace("[OrderNumber]", "'" . mssql_addslashes(@$kit->OrderNumber) . "'", $values);
		$values = str_replace("[ClientPONumber]", "'" . mssql_addslashes(@$kit->ClientPONumber) . "'", $values);
		$values = str_replace("[SalesWorkOrder_ID]", "'" . mssql_addslashes(@$kit->SalesWorkOrderID->_) . "'", $values);
		$values = str_replace("[SalesWorkOrder_ID_Type]", "'" . mssql_addslashes(@$kit->SalesWorkOrderID->type) . "'", $values);
		$values = str_replace("[ProductType]", "'" . mssql_addslashes(@$kit->ProductType) . "'", $values);
		$values = str_replace("[Postage_Method]", "'" . mssql_addslashes(@$kit->Postage->Method) . "'", $values);
		$values = str_replace("[Postage_Cost]", @$kit->Postage->Cost->_, $values);
		$values = str_replace("[Postage_Cost_Currency]", "'" . mssql_addslashes(@$kit->Postage->Cost->Currency) . "'", $values);
		$values = str_replace("[DownloadURL]", "'" . mssql_addslashes(@$kit->DownloadURL) . "'", $values);
		$values = str_replace("[PageCount]", "'" . mssql_addslashes(@$kit->PageCount) . "'", $values);
		$values = str_replace("[CatalogTreeNodeExternalId]", "'" . mssql_addslashes(@$kit->CatalogTreeNodeExternalId) . "'", $values);
		$values = str_replace("[RequisitionStatus]", "'" . mssql_addslashes(@$kit->RequisitionStatus) . "'", $values);
		$values = str_replace("[ApproverUser_ID]", "'" . mssql_addslashes(@$kit->ApproverUser->ID->_) . "'", $values);
		$values = str_replace("[ApproverUser_ID_Type]", "'" . mssql_addslashes(@$kit->ApproverUser->ID->type) . "'", $values);
		$values = str_replace("[ApproverUser_Name]", "'" . mssql_addslashes(@$kit->ApproverUser->Name) . "'", $values);		
		$values = str_replace("[ApproverUser_FirstName]", "'" . mssql_addslashes(@$kit->ApproverUser->FirstName) . "'", $values);
		$values = str_replace("[ApproverUser_LastName]", "'" . mssql_addslashes(@$kit->ApproverUser->LastName) . "'", $values);
		$values = str_replace("[ApproverUser_Login_ID]", "'" . mssql_addslashes(@$kit->ApproverUser->LoginID) . "'", $values);
		$values = str_replace("[ApproverUser_Email]", "'" . mssql_addslashes(@$kit->ApproverUser->Email) . "'", $values);		
		$values = str_replace("[Explanation]", "'" . mssql_addslashes(@$kit->Explanation) . "'", $values);
		$values = str_replace("[ImposedUsingDefaultURL]", "'" . mssql_addslashes(@$kit->ImposedUsingDefaultURL) . "'", $values);
		$values = str_replace("[ReqUser_ID]", "'" . mssql_addslashes(@$kit->ReqUser->ID->_) . "'", $values);
		$values = str_replace("[ReqUser_ID_Type]", "'" . mssql_addslashes(@$kit->ReqUser->ID->type) . "'", $values);
		$values = str_replace("[ReqUser_Name]", "'" . mssql_addslashes(@$kit->ReqUser->Name) . "'", $values);		
		$values = str_replace("[ReqUser_FirstName]", "'" . mssql_addslashes(@$kit->ReqUser->FirstName) . "'", $values);
		$values = str_replace("[ReqUser_LastName]", "'" . mssql_addslashes(@$kit->ReqUser->LastName) . "'", $values);
		$values = str_replace("[ReqUser_Login_ID]", "'" . mssql_addslashes(@$kit->ReqUser->LoginID) . "'", $values);
		$values = str_replace("[ReqUser_Email]", "'" . mssql_addslashes(@$kit->ReqUser->Email) . "'", $values);
		$values = str_replace("[SKUInventorySettings_Unit]", "'" . mssql_addslashes(@$kit->SKUInventorySettings->Unit) . "'", $values);
		$values = str_replace("[SKUInventorySettings_QtyPerUnit]", @$kit->SKUInventorySettings->QtyPerUnit, $values);
		$values = str_replace("[SKUInventorySettings_Warehouse]", "'" . mssql_addslashes(@$kit->SKUInventorySettings->Warehouse) . "'", $values);		
		$values = str_replace("[SKUInventorySettings_Location]", "'" . mssql_addslashes(@$kit->SKUInventorySettings->Location) . "'", $values);
		$values = str_replace("[ListVendor_ID]", "'" . mssql_addslashes(@$kit->ListVendor->ID->_) . "'", $values);
		$values = str_replace("[ListVendor_ID_Type]", "'" . mssql_addslashes(@$kit->ListVendor->ID->Type) . "'", $values);
		$values = str_replace("[ListVendor_Name]", "'" . mssql_addslashes(@$kit->ListVendor->Name) . "'", $values);
		$values = str_replace("[ListVendor_CustomerCost]", @$kit->ListVendor->CustomerCost->_, $values);
		$values = str_replace("[ListVendor_CustomerCost_Currency]", "'" . mssql_addslashes(@$kit->ListVendor->CustomerCost->Currency) . "'", $values);
		$values = str_replace("[Impersonator_ID]", "'" . mssql_addslashes(@$kit->Impersonator->ID->_) . "'", $values);
		$values = str_replace("[Impersonator_ID_Type]", "'" . mssql_addslashes(@$kit->Impersonator->ID->type) . "'", $values);
		$values = str_replace("[Impersonator_Name]", "'" . mssql_addslashes(@$kit->Impersonator->Name) . "'", $values);		
		$values = str_replace("[Impersonator_FirstName]", "'" . mssql_addslashes(@$kit->Impersonator->FirstName) . "'", $values);
		$values = str_replace("[Impersonator_LastName]", "'" . mssql_addslashes(@$kit->Impersonator->LastName) . "'", $values);
		$values = str_replace("[Impersonator_Login_ID]", "'" . mssql_addslashes(@$kit->Impersonator->LoginID) . "'", $values);
		$values = str_replace("[Impersonator_Email]", "'" . mssql_addslashes(@$kit->Impersonator->Email) . "'", $values);		
		$values = str_replace("[UserLiteType_ID]", "'" . mssql_addslashes(@$kit->UserLiteType->ID->_) . "'", $values);
		$values = str_replace("[UserLiteType_ID_Type]", "'" . mssql_addslashes(@$kit->UserLiteType->ID->type) . "'", $values);
		$values = str_replace("[UserLiteType_Login_ID]", "'" . mssql_addslashes(@$kit->UserLiteType->LoginID) . "'", $values);
		$values = str_replace("[UserLiteType_Name]", "'" . mssql_addslashes(@$kit->UserLiteType->Name) . "'", $values);		
		$values = str_replace("[UserLiteType_FirstName]", "'" . mssql_addslashes(@$kit->UserLiteType->FirstName) . "'", $values);
		$values = str_replace("[UserLiteType_LastName]", "'" . mssql_addslashes(@$kit->UserLiteType->LastName) . "'", $values);
				
		// For any columns that we couldn't replace, set the values to NULL.		
		$values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);
		$values = str_replace(', ,', ', 0,', $values);
		// Build the complete "INSERT" statement.
		$insert_query = "INSERT INTO KitDetails (" . $columns . ") VALUES (" . $values . ")";
			//echo '<br/>hi<br/>';
		if ($debug === true) {
			echo "<h1>KitDetails INSERT Statement Generated</h1>";
			echo "<pre>";
			echo $insert_query;
			echo "</pre>";
		}
			$result = mssql_query ($insert_query);			
		
		
	if (isset($kit->TemplateFields->TemplateField	))
	{	
		$templatefield = $kit->TemplateFields->TemplateField;
		if (! is_array($templatefield) ) {
				// Get the single object as an array.
				$new_templatefield[] = $templatefield;
				unset ($templatefield);
				$templatefield = $new_templatefield;
			}	
			
		//var_dump ($templatefield);
		foreach ($templatefield as $tp) {
				kittemplatefields_insert($db, $kit->ID->_, $tp, $debug);
				if ($debug === true) {
				//echo "<h1>KitTEMPLATEFIELD Object </h1>";
				//echo "<pre>";
				//var_dump ($tp);
				//echo "</pre>";
				}
			}
		}
		

		
		
		return;
	
	}

?>