<?php

/*

  Filename:

  load_printable_orders/orderdetail_insert.php



 */

function orderdetail_insert($db, $order_id, $orderdetail, $debug)
{

        require_once ("orderdetailkit_insert.php");
        require_once ("orderdetailtemplatefields_insert.php");
        require_once ("attachedfiles_insert.php");
        require_once ("coupons_insert.php");
        require_once ("finishingoptions_insert.php");


        if ($debug === true)
        {
                echo "<h1>OrderDetail Object (passed to orderdetail_insert for $order_id)</h1>";
                echo "<pre>";
                var_dump(@$orderdetail);
                echo "</pre>";
        }

        //get order_id 
        // Create a list of the columns that will be inserted into.
        $columns = "[Order_ID], [OrderDetail_ID], [OrderDetail_Type], [OrderType], [User_ID], [User_ID_Type], [User_FirstName], [User_LastName], [User_Login_ID], [User_Email], [Product_ID], [Product_ID_Type], [ProductName], [ProductDescription], [SKU_ID], [SKU_ID_Type], [SKU_Name], [SKUDescription], [Quantity], [QuantityShipped], [Price_Cost_Customer], [Price_Cost_Customer_Currency], [Price_Cost_Seller], [Price_Cost_Seller_Currency], [Price_Cost_Shipping], [Price_Cost_Shipping_Currency], [Price_Cost_Unit], [Price_Cost_Unit_Currency], [Price_Cost_CustomerDiscount], [Price_Cost_CustomerDiscount_Currency], [Price_Cost_CustomerMisc], [Price_Cost_CustomerMisc_Currency], [Price_Cost_SellerMisc], [Price_Cost_SellerMisc_Currency], [Price_Cost_SellerStoreDiscount], [Price_Cost_SellerStoreDiscount_Currency], [Price_Cost_SellerShipping], [Price_Cost_SellerShipping_Currency], [Price_Cost_Postage], [Price_Cost_Postage_Currency], [Price_Tax_CustomerSales], [Price_Tax_CustomerSales_Currency], [Price_Tax_DirectAcctSales], [Price_Tax_DirectAcctSales_Currency], [Price_Tax_City], [Price_Tax_City_Currency], [Price_Tax_County], [Price_Tax_County_Currency], [Price_Tax_State], [Price_Tax_State_Currency], [Price_Tax_District], [Price_Tax_District_Currency], [Price_Tax_CityFreight], [Price_Tax_CityFreight_Currency], [Price_Tax_CountyFreight], [Price_Tax_CountyFreight_Currency], [Price_Tax_StateFreight], [Price_Tax_StateFreight_Currency], [Price_Tax_DistrictFreight], [Price_Tax_DistrictFreight_Currency], [Price_Tax_TotalFreight], [Price_Tax_TotalFreight_Currency], [Price_Tax_TaxableSalesAmount], [Price_Tax_TaxableSalesAmount_Currency], [Price_Tax_ExemptSalesAmount], [Price_Tax_ExemptSalesAmount_Currency], [Price_Tax_NonTaxableSalesAmount], [Price_Tax_NonTaxableSalesAmount_Currency], [Price_Tax_CityName], [Price_Tax_CountyName], [Price_Tax_StateName], [Price_Tax_Zip], [Department_ID], [Department_ID_Type], [Department_Name], [Department_Number], [SupplierWorkOrder_ID], [SupplierWorkOrder_ID_Type], [SupplierWorkOrder_Name], [Supplier_ID], [Supplier_ID_Type], [Supplier_Name], [OutputFileURL], [Shipping_Date], [Shipping_DateShipped], [Shipping_Method], [Shipping_Instructions], [ShippingAddress_ID], [ShippingAddress_ID_Type], [ShippingAddress_Description], [ShippingAddress_Address1], [ShippingAddress_Address2], [ShippingAddress_Address3], [ShippingAddress_Address4], [ShippingAddress_City], [ShippingAddress_State], [ShippingAddress_Zip], [ShippingAddress_Country], [ShippingAddress_PhoneNumber], [ShippingAddress_FaxNumber], [ShippingAddress_CompanyName], [ShippingAddress_Attn], [ShippingTrackingNumber], [ClientStatus], [ClientStatus_Date], [SellerStatus], [SellerStatus_Date], [SupplierStatus], [SupplierStatus_Date], [CreditCardSettlement_ID], [CreditCardSettlement_ID_Type], [CreditCardSettlement_Number], [CreditCardSettlement_Date], [CreditCardSettlement_User_ID], [CreditCardSettlement_User_ID_Type], [CreditCardSettlement_UserName], [OrderNumber], [ClientPONumber], [SalesWorkOrder_ID], [SalesWorkOrder_ID_Type], [ProductType], [Postage_Method], [Postage_Cost], [Postage_Cost_Currency], [DownloadURL], [PageCount], [CatalogTreeNodeExternalId], [RequisitionStatus], [ApproverUser_ID], [ApproverUser_ID_Type], [ApproverUser_Name], [ApproverUser_FirstName], [ApproverUser_LastName], [ApproverUser_Login_ID], [ApproverUser_Email], [Explanation], [ImposedUsingDefaultURL], [ReqUser_ID], [ReqUser_ID_Type], [ReqUser_Name], [ReqUser_FirstName], [ReqUser_LastName], [ReqUser_Login_ID], [ReqUser_Email], [SKUInventorySettings_Unit], [SKUInventorySettings_QtyPerUnit], [SKUInventorySettings_Warehouse], [SKUInventorySettings_Location], [ListVendor_ID], [ListVendor_ID_Type], [ListVendor_Name], [ListVendor_CustomerCost], [ListVendor_CustomerCost_Currency], [Impersonator_ID], [Impersonator_ID_Type], [Impersonator_Name], [Impersonator_FirstName], [Impersonator_LastName], [Impersonator_Login_ID], [Impersonator_Email], [UserLiteType_ID], [UserLiteType_ID_Type], [UserLiteType_Login_ID], [UserLiteType_Name], [UserLiteType_FirstName], [UserLiteType_LastName]";

        $orderNumber = '';

        // Create a list of the values that will be inserted.
        $values = $columns;
        $values = str_replace("[Order_ID]", "'" . mssql_addslashes($order_id) . "'", $values);
        $values = str_replace("[OrderDetail_ID]", "'" . mssql_addslashes(@$orderdetail->ID->_) . "'", $values);
        $values = str_replace("[OrderDetail_Type]", "'" . mssql_addslashes(@$orderdetail->ID->type) . "'", $values);
        $values = str_replace("[OrderType]", "'" . mssql_addslashes(@$orderdetail->OrderType) . "'", $values);
        $values = str_replace("[User_ID]", "'" . mssql_addslashes(@$orderdetail->User->ID->_) . "'", $values);
        $values = str_replace("[User_ID_Type]", "'" . mssql_addslashes(@$orderdetail->User->ID->type) . "'", $values);
        $values = str_replace("[User_FirstName]", "'" . mssql_addslashes(@$orderdetail->User->FirstName) . "'", $values);
        $values = str_replace("[User_LastName]", "'" . mssql_addslashes(@$orderdetail->User->LastName) . "'", $values);
        $values = str_replace("[User_Login_ID]", "'" . mssql_addslashes(@$orderdetail->User->LoginID) . "'", $values);
        $values = str_replace("[User_Email]", "'" . mssql_addslashes(@$orderdetail->User->Email) . "'", $values);
        $values = str_replace("[Product_ID]", "'" . mssql_addslashes(@$orderdetail->ProductID->_) . "'", $values);
        $values = str_replace("[Product_ID_Type]", "'" . mssql_addslashes(@$orderdetail->ProductID->type) . "'", $values);
        $values = str_replace("[ProductName]", "'" . mssql_addslashes(@$orderdetail->ProductName) . "'", $values);
        $values = str_replace("[ProductDescription]", "'" . mssql_addslashes(@$orderdetail->ProductDescription) . "'", $values);
        $values = str_replace("[SKU_ID]", "'" . mssql_addslashes(@$orderdetail->SKU->ID->_) . "'", $values);
        $values = str_replace("[SKU_ID_Type]", "'" . mssql_addslashes(@$orderdetail->SKU->ID->type) . "'", $values);
        $values = str_replace("[SKU_Name]", "'" . mssql_addslashes(@$orderdetail->SKU->Name) . "'", $values);
        $values = str_replace("[SKUDescription]", "'" . mssql_addslashes(@$orderdetail->SKUDescription) . "'", $values);
        $values = str_replace("[Quantity]", @$orderdetail->Quantity, $values);
        $values = str_replace("[QuantityShipped]", @$orderdetail->QuantityShipped, $values);
        $values = str_replace("[Price_Cost_Customer]", @$orderdetail->Price->Cost->Customer->_, $values);
        $values = str_replace("[Price_Cost_Customer_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->Customer->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_Seller]", @$orderdetail->Price->Cost->Seller->_, $values);
        $values = str_replace("[Price_Cost_Seller_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->Seller->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_Shipping]", @$orderdetail->Price->Cost->Shipping->_, $values);
        $values = str_replace("[Price_Cost_Shipping_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->Shipping->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_Unit]", @$orderdetail->Price->Cost->Unit->_, $values);
        $values = str_replace("[Price_Cost_Unit_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->Unit->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_CustomerDiscount]", @$orderdetail->Price->Cost->CustomerDiscount->_, $values);
        $values = str_replace("[Price_Cost_CustomerDiscount_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->CustomerDiscount->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_CustomerMisc]", @$orderdetail->Price->Cost->CustomerMisc->_, $values);
        $values = str_replace("[Price_Cost_CustomerMisc_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->CustomerMisc->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_SellerMisc]", @$orderdetail->Price->Cost->SellerMisc->_, $values);
        $values = str_replace("[Price_Cost_SellerMisc_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->SellerMisc->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_SellerStoreDiscount]", @$orderdetail->Price->Cost->SellerStoreDiscount->_, $values);
        $values = str_replace("[Price_Cost_SellerStoreDiscount_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->SellerStoreDiscount->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_SellerShipping]", @$orderdetail->Price->Cost->SellerShipping->_, $values);
        $values = str_replace("[Price_Cost_SellerShipping_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->SellerShipping->Currency) . "'", $values);
        $values = str_replace("[Price_Cost_Postage]", @$orderdetail->Price->Cost->Postage->_, $values);
        $values = str_replace("[Price_Cost_Postage_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Cost->Postage->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_CustomerSales]", @$orderdetail->Price->Tax->CustomerSales->_, $values);
        $values = str_replace("[Price_Tax_CustomerSales_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->CustomerSales->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_DirectAcctSales]", @$orderdetail->Price->Tax->DirectAcctSales->_, $values);
        $values = str_replace("[Price_Tax_DirectAcctSales_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->DirectAcctSales->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_City]", @$orderdetail->Price->Tax->City->_, $values);
        $values = str_replace("[Price_Tax_City_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->City->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_County]", @$orderdetail->Price->Tax->County->_, $values);
        $values = str_replace("[Price_Tax_County_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->County->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_State]", @$orderdetail->Price->Tax->State->_, $values);
        $values = str_replace("[Price_Tax_State_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->State->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_District]", @$orderdetail->Price->Tax->District->_, $values);
        $values = str_replace("[Price_Tax_District_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->District->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_CityFreight]", @$orderdetail->Price->Tax->CityFreight->_, $values);
        $values = str_replace("[Price_Tax_CityFreight_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->CityFreight->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_CountyFreight]", @$orderdetail->Price->Tax->CountyFreight->_, $values);
        $values = str_replace("[Price_Tax_CountyFreight_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->CountyFreight->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_StateFreight]", @$orderdetail->Price->Tax->StateFreight->_, $values);
        $values = str_replace("[Price_Tax_StateFreight_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->StateFreight->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_DistrictFreight]", @$orderdetail->Price->Tax->DistrictFreight->_, $values);
        $values = str_replace("[Price_Tax_DistrictFreight_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->DistrictFreight->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_TotalFreight]", @$orderdetail->Price->Tax->TotalFreight->_, $values);
        $values = str_replace("[Price_Tax_TotalFreight_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->TotalFreight->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_TaxableSalesAmount]", @$orderdetail->Price->Tax->TaxableSalesAmount->_, $values);
        $values = str_replace("[Price_Tax_TaxableSalesAmount_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->TaxableSalesAmount->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_ExemptSalesAmount]", @$orderdetail->Price->Tax->ExemptSalesAmount->_, $values);
        $values = str_replace("[Price_Tax_ExemptSalesAmount_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->ExemptSalesAmount->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_NonTaxableSalesAmount]", @$orderdetail->Price->Tax->NonTaxableSalesAmount->_, $values);
        $values = str_replace("[Price_Tax_NonTaxableSalesAmount_Currency]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->NonTaxableSalesAmount->Currency) . "'", $values);
        $values = str_replace("[Price_Tax_CityName]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->CityName) . "'", $values);
        $values = str_replace("[Price_Tax_CountyName]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->CountyName) . "'", $values);
        $values = str_replace("[Price_Tax_StateName]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->StateName) . "'", $values);
        $values = str_replace("[Price_Tax_Zip]", "'" . mssql_addslashes(@$orderdetail->Price->Tax->Zip) . "'", $values);
        $values = str_replace("[Department_ID]", "'" . mssql_addslashes(@$orderdetail->Department->ID->_) . "'", $values);
        $values = str_replace("[Department_ID_Type]", "'" . mssql_addslashes(@$orderdetail->Department->ID->type) . "'", $values);
        $values = str_replace("[Department_Name]", "'" . mssql_addslashes(@$orderdetail->Department->Name) . "'", $values);
        $values = str_replace("[Department_Number]", "'" . mssql_addslashes(@$orderdetail->Department->Number) . "'", $values);
        //if (isset(@$orderdetail->SupplierWorkOrder)) {
        $values = str_replace("[SupplierWorkOrder_ID]", "'" . mssql_addslashes(@$orderdetail->SupplierWorkOrder->ID->_) . "'", $values);
        $values = str_replace("[SupplierWorkOrder_ID_Type]", "'" . mssql_addslashes(@$orderdetail->SupplierWorkOrder->ID->type) . "'", $values);
        $values = str_replace("[SupplierWorkOrder_Name]", "'" . mssql_addslashes(@$orderdetail->SupplierWorkOrder->Name) . "'", $values);
        //}
        //if (isset(@$orderdetail->Supplier)) {
        $values = str_replace("[Supplier_ID]", "'" . mssql_addslashes(@$orderdetail->Supplier->ID->_) . "'", $values);
        $values = str_replace("[Supplier_ID_Type]", "'" . mssql_addslashes(@$orderdetail->Supplier->ID->type) . "'", $values);
        $values = str_replace("[Supplier_Name]", "'" . mssql_addslashes(@$orderdetail->Supplier->Name) . "'", $values);
        //}
        //if (isset(@$orderdetail->OutputFileURL)) {
        $values = str_replace("[OutputFileURL]", "'" . mssql_addslashes(@$orderdetail->OutputFileURL->URL) . "'", $values);
        //}
        if (isset($orderdetail->Shipping->Date)) // remove bad dates
        {
                $tempshippingdate = $orderdetail->Shipping->Date;
                $pos = strpos($tempshippingdate, ".");
                if ($pos !== false)
                {
                        $tempshippingdate = substr($tempshippingdate, 0, $pos);
                }
                $values = str_replace("[Shipping_Date]", "'" . mssql_addslashes(@$tempshippingdate) . "'", $values);
                unset($tempshippingdate);
                unset($pos);
        }
        else
        {
                $values = str_replace("[Shipping_Date]", "'" . mssql_addslashes(@$orderdetail->Shipping->Date) . "'", $values);
        }

        $values = str_replace("[Shipping_DateShipped]", "'" . mssql_addslashes(@$orderdetail->Shipping->DateShipped) . "'", $values);
        //if (isset(@$orderdetail->Shipping->Method)) {
        $values = str_replace("[Shipping_Method]", "'" . mssql_addslashes(@$orderdetail->Shipping->Method) . "'", $values);
        //}
        $values = str_replace("[Shipping_Instructions]", "'" . mssql_addslashes(@$orderdetail->Shipping->Instructions) . "'", $values);
        $values = str_replace("[ShippingAddress_ID]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->ID->_) . "'", $values);
        $values = str_replace("[ShippingAddress_ID_Type]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->ID->type) . "'", $values);
        $values = str_replace("[ShippingAddress_Description]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->Description) . "'", $values);
        $values = str_replace("[ShippingAddress_Address1]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->Address1) . "'", $values);

        $add2 = @$orderdetail->Shipping->Address->Address2;
//        $strpos = strpos(strtoupper($add2), "800 EAST 3RD STREET");
//        if ($strpos !== false)
//        {
//                error_log("Address2 Changed to '845 A AVE E' for OD_ID: " . $orderdetail->ID->_);
//                $add2 = str_replace("800 EAST 3RD STREET", "845 A AVE E", strtoupper($add2));
//        }
        $values = str_replace("[ShippingAddress_Address2]", "'" . mssql_addslashes(@$add2) . "'", $values);

        $values = str_replace("[ShippingAddress_Address3]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->Address3) . "'", $values);
        $values = str_replace("[ShippingAddress_Address4]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->Address4) . "'", $values);
        $values = str_replace("[ShippingAddress_City]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->City) . "'", $values);
        $values = str_replace("[ShippingAddress_State]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->State) . "'", $values);
        $values = str_replace("[ShippingAddress_Zip]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->Zip) . "'", $values);
        $values = str_replace("[ShippingAddress_Country]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->Country) . "'", $values);
        $values = str_replace("[ShippingAddress_PhoneNumber]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->PhoneNumber) . "'", $values);
        $values = str_replace("[ShippingAddress_FaxNumber]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->FaxNumber) . "'", $values);
        $values = str_replace("[ShippingAddress_CompanyName]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->CompanyName) . "'", $values);
        //$values = str_replace("[ShippingAddress_Attn]", "'" . mssql_addslashes(@$orderdetail->Shipping->Address->Attn) . "'", $values);
        //if (isset(@$orderdetail->Shipping->TrackingNumber)) {
        $values = str_replace("[ShippingTrackingNumber]", "'" . mssql_addslashes(@$orderdetail->Shipping->TrackingNumber) . "'", $values);
        //}
        $values = str_replace("[ClientStatus]", "'" . mssql_addslashes(@$orderdetail->ClientStatus->Value) . "'", $values);
        $values = str_replace("[ClientStatus_Date]", "'" . mssql_addslashes(@$orderdetail->ClientStatus->Date) . "'", $values);
        $values = str_replace("[SellerStatus]", "'" . mssql_addslashes(@$orderdetail->SellerStatus->Value) . "'", $values);
        $values = str_replace("[SellerStatus_Date]", "'" . mssql_addslashes(@$orderdetail->SellerStatus->Date) . "'", $values);
        $values = str_replace("[SupplierStatus]", "'" . mssql_addslashes(@$orderdetail->SupplierStatus->Value) . "'", $values);
        $values = str_replace("[SupplierStatus_Date]", "'" . mssql_addslashes(@$orderdetail->SupplierStatus->Date) . "'", $values);
        //if (isset(@$orderdetail->CreditCardSettlement)) {
        $values = str_replace("[CreditCardSettlement_ID]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->ID->_) . "'", $values);
        $values = str_replace("[CreditCardSettlement_ID_Type]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->ID->type) . "'", $values);
        $values = str_replace("[CreditCardSettlement_Number]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->Number) . "'", $values);
        $values = str_replace("[CreditCardSettlement_Date]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->Date) . "'", $values);
        $values = str_replace("[CreditCardSettlement_User_ID]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->UserID->_) . "'", $values);
        $values = str_replace("[CreditCardSettlement_User_ID_Type]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->UserID->type) . "'", $values);
        $values = str_replace("[CreditCardSettlement_UserName]", "'" . mssql_addslashes(@$orderdetail->CreditCardSettlement->UserName) . "'", $values);
        //}
        $values = str_replace("[OrderNumber]", "'" . mssql_addslashes(@$orderdetail->OrderNumber) . "'", $values);
        $values = str_replace("[ClientPONumber]", "'" . mssql_addslashes(@$orderdetail->ClientPONumber) . "'", $values);
        $values = str_replace("[SalesWorkOrder_ID]", "'" . mssql_addslashes(@$orderdetail->SalesWorkOrderID->_) . "'", $values);
        $values = str_replace("[SalesWorkOrder_ID_Type]", "'" . mssql_addslashes(@$orderdetail->SalesWorkOrderID->type) . "'", $values);
        $values = str_replace("[ProductType]", "'" . mssql_addslashes(@$orderdetail->ProductType) . "'", $values);
        $values = str_replace("[Postage_Method]", "'" . mssql_addslashes(@$orderdetail->Postage->Method) . "'", $values);
        $values = str_replace("[Postage_Cost]", @$orderdetail->Postage->Cost->_, $values);
        $values = str_replace("[Postage_Cost_Currency]", "'" . mssql_addslashes(@$orderdetail->Postage->Cost->Currency) . "'", $values);
        $values = str_replace("[DownloadURL]", "'" . mssql_addslashes(@$orderdetail->DownloadURL) . "'", $values);
        $values = str_replace("[PageCount]", "'" . mssql_addslashes(@$orderdetail->PageCount) . "'", $values);
        $values = str_replace("[CatalogTreeNodeExternalId]", "'" . mssql_addslashes(@$orderdetail->CatalogTreeNodeExternalId) . "'", $values);
        $values = str_replace("[RequisitionStatus]", "'" . mssql_addslashes(@$orderdetail->RequisitionStatus) . "'", $values);
        $values = str_replace("[ApproverUser_ID]", "'" . mssql_addslashes(@$orderdetail->ApproverUser->ID->_) . "'", $values);
        $values = str_replace("[ApproverUser_ID_Type]", "'" . mssql_addslashes(@$orderdetail->ApproverUser->ID->type) . "'", $values);
        $values = str_replace("[ApproverUser_Name]", "'" . mssql_addslashes(@$orderdetail->ApproverUser->Name) . "'", $values);
        $values = str_replace("[ApproverUser_FirstName]", "'" . mssql_addslashes(@$orderdetail->ApproverUser->FirstName) . "'", $values);
        $values = str_replace("[ApproverUser_LastName]", "'" . mssql_addslashes(@$orderdetail->ApproverUser->LastName) . "'", $values);
        $values = str_replace("[ApproverUser_Login_ID]", "'" . mssql_addslashes(@$orderdetail->ApproverUser->LoginID) . "'", $values);
        $values = str_replace("[ApproverUser_Email]", "'" . mssql_addslashes(@$orderdetail->ApproverUser->Email) . "'", $values);
        $values = str_replace("[Explanation]", "'" . mssql_addslashes(@$orderdetail->Explanation) . "'", $values);
        $values = str_replace("[ImposedUsingDefaultURL]", "'" . mssql_addslashes(@$orderdetail->ImposedUsingDefaultURL) . "'", $values);
        $values = str_replace("[ReqUser_ID]", "'" . mssql_addslashes(@$orderdetail->ReqUser->ID->_) . "'", $values);
        $values = str_replace("[ReqUser_ID_Type]", "'" . mssql_addslashes(@$orderdetail->ReqUser->ID->type) . "'", $values);
        $values = str_replace("[ReqUser_Name]", "'" . mssql_addslashes(@$orderdetail->ReqUser->Name) . "'", $values);
        $values = str_replace("[ReqUser_FirstName]", "'" . mssql_addslashes(@$orderdetail->ReqUser->FirstName) . "'", $values);
        $values = str_replace("[ReqUser_LastName]", "'" . mssql_addslashes(@$orderdetail->ReqUser->LastName) . "'", $values);
        $values = str_replace("[ReqUser_Login_ID]", "'" . mssql_addslashes(@$orderdetail->ReqUser->LoginID) . "'", $values);
        $values = str_replace("[ReqUser_Email]", "'" . mssql_addslashes(@$orderdetail->ReqUser->Email) . "'", $values);
        $values = str_replace("[SKUInventorySettings_Unit]", "'" . mssql_addslashes(@$orderdetail->SKUInventorySettings->Unit) . "'", $values);
        $values = str_replace("[SKUInventorySettings_QtyPerUnit]", @$orderdetail->SKUInventorySettings->QtyPerUnit, $values);
        $values = str_replace("[SKUInventorySettings_Warehouse]", "'" . mssql_addslashes(@$orderdetail->SKUInventorySettings->Warehouse) . "'", $values);
        //remove commas from messed up printable data.
        $fgi = str_replace(',', '', mssql_addslashes(@$orderdetail->SKUInventorySettings->Location));
        $values = str_replace("[SKUInventorySettings_Location]", $fgi, $values);
        $values = str_replace("[ListVendor_ID]", "'" . mssql_addslashes(@$orderdetail->ListVendor->ID->_) . "'", $values);
        $values = str_replace("[ListVendor_ID_Type]", "'" . mssql_addslashes(@$orderdetail->ListVendor->ID->Type) . "'", $values);
        $values = str_replace("[ListVendor_Name]", "'" . mssql_addslashes(@$orderdetail->ListVendor->Name) . "'", $values);
        $values = str_replace("[ListVendor_CustomerCost]", @$orderdetail->ListVendor->CustomerCost->_, $values);
        $values = str_replace("[ListVendor_CustomerCost_Currency]", "'" . mssql_addslashes(@$orderdetail->ListVendor->CustomerCost->Currency) . "'", $values);
        $values = str_replace("[Impersonator_ID]", "'" . mssql_addslashes(@$orderdetail->Impersonator->ID->_) . "'", $values);
        $values = str_replace("[Impersonator_ID_Type]", "'" . mssql_addslashes(@$orderdetail->Impersonator->ID->type) . "'", $values);
        $values = str_replace("[Impersonator_Name]", "'" . mssql_addslashes(@$orderdetail->Impersonator->Name) . "'", $values);
        $values = str_replace("[Impersonator_FirstName]", "'" . mssql_addslashes(@$orderdetail->Impersonator->FirstName) . "'", $values);
        $values = str_replace("[Impersonator_LastName]", "'" . mssql_addslashes(@$orderdetail->Impersonator->LastName) . "'", $values);
        $values = str_replace("[Impersonator_Login_ID]", "'" . mssql_addslashes(@$orderdetail->Impersonator->LoginID) . "'", $values);
        $values = str_replace("[Impersonator_Email]", "'" . mssql_addslashes(@$orderdetail->Impersonator->Email) . "'", $values);
        $values = str_replace("[UserLiteType_ID]", "'" . mssql_addslashes(@$orderdetail->UserLiteType->ID->_) . "'", $values);
        $values = str_replace("[UserLiteType_ID_Type]", "'" . mssql_addslashes(@$orderdetail->UserLiteType->ID->type) . "'", $values);
        $values = str_replace("[UserLiteType_Login_ID]", "'" . mssql_addslashes(@$orderdetail->UserLiteType->LoginID) . "'", $values);
        $values = str_replace("[UserLiteType_Name]", "'" . mssql_addslashes(@$orderdetail->UserLiteType->Name) . "'", $values);
        $values = str_replace("[UserLiteType_FirstName]", "'" . mssql_addslashes(@$orderdetail->UserLiteType->FirstName) . "'", $values);
        $values = str_replace("[UserLiteType_LastName]", "'" . mssql_addslashes(@$orderdetail->UserLiteType->LastName) . "'", $values);

        
        
        $orderNumber = $orderdetail->OrderNumber;
        $shippingAddress_Attn = $orderdetail->Shipping->Address->Attn;
        $pos = strpos(strtoupper($orderNumber), strtoupper('IUH-'));

        if ($pos === false)
        {                
        }
        else
        {
                $shippingAddress_Attn = $shippingAddress_Attn . '  -  ' . $orderNumber;
                error_log("ShippingAttn: " . $shippingAddress_Attn);
        }
        
        $values = str_replace("[ShippingAddress_Attn]", "'" . mssql_addslashes(@$shippingAddress_Attn) . "'", $values);
        
        
        
        
        
        // For any columns that we couldn't replace, set the values to NULL.		
        $values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);
        $values = str_replace(', ,', ', 0,', $values);
        // Build the complete "INSERT" statement.
        $insert_query = "INSERT INTO OrderDetails (" . $columns . ") VALUES (" . $values . ")";
        //echo '<br/>hi<br/>';
        if ($debug === true)
        {
                echo "<h1>OrderDetails INSERT Statement Generated</h1>";
                echo "<pre>";
                echo $insert_query;
                echo "</pre>";
        }
        $result = mssql_query($insert_query);


        if (isset($orderdetail->TemplateFields->TemplateField))
        {
                $templatefield = $orderdetail->TemplateFields->TemplateField;
                if (!is_array($templatefield))
                {
                        // Get the single object as an array.
                        $new_templatefield[] = $templatefield;
                        unset($templatefield);
                        $templatefield = $new_templatefield;
                }
                foreach ($templatefield as $tp)
                {
                        orderdetailtemplatefields_insert($db, $orderdetail->ID->_, $tp, $debug);
                }
        }

        if (isset($orderdetail->Kit->KitDetail))
        {
                $orderdetailkit = $orderdetail->Kit->KitDetail;

                // If order details is not an array (which indicates that we have a single orderdetailkit object)...
                if (!is_array($orderdetailkit))
                {
                        // Get the single object as an array.
                        $new_orderdetailkit[] = $orderdetailkit;
                        unset($orderdetailkit);
                        $orderdetailkit = $new_orderdetailkit;
                }
                //var_dump ($orderdetailkit);
                // Loop over the order details array...
                foreach ($orderdetailkit as $kit)
                {
                        orderdetailkit_insert($db, $orderdetail->ID->_, $kit, $debug);
                }
        }

        if (isset($orderdetail->AttachedFiles->File))
        {
                $files = $orderdetail->AttachedFiles->File;
                if (!is_array($files))
                {
                        // Get the single object as an array.
                        $new_files[] = $files;
                        unset($files);
                        $files = $new_files;
                }

                foreach ($files as $file)
                {
                        if (isset($file->URL))
                        {
                                attachedfiles_insert($db, $orderdetail->ID->_, $file, $debug);
                        }
                }
        }


        if (isset($orderdetail->Coupons->Coupon))
        {
                $coupons = $orderdetail->Coupons->Coupon;
                if (!is_array($coupons))
                {
                        // Get the single object as an array.
                        $new_coupons[] = $coupons;
                        unset($coupons);
                        $coupons = $new_coupons;
                }

                foreach ($coupons as $coupon)
                {
                        if (isset($coupon->Code))
                        {
                                coupons_insert($db, $orderdetail->ID->_, $coupon, $debug);
                        }
                }
        }


        if (isset($orderdetail->FinishingOptions->Option))
        {
                $options = $orderdetail->FinishingOptions->Option;
                if (!is_array($options))
                {
                        // Get the single object as an array.
                        $new_options[] = $options;
                        unset($options);
                        $options = $new_options;
                }

                foreach ($options as $option)
                {
                        if (isset($option->Name))
                        {
                                finishingoptions_insert($db, $orderdetail->ID->_, $option, $debug);
                        }
                }
        }



        return $result;
}

?>