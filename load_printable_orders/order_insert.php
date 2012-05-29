<?php

/*

  Filename:

  load_printable_orders/order_insert.php


 */

function order_insert($db, $order, $debug)
{

        require_once ("orderdetail_insert.php");
        require_once ("usergroup_insert.php");

        if ($debug === true)
        {
                //echo "<h1>Order Object (passed to order_insert)</h1>";
                //echo "<pre>";
                //var_dump ($order);
                //echo "</pre>";
        }


        // Create a query used to check for the existance of the order.
        $select_query = "SELECT * FROM Orders WHERE Order_ID = '" . mssql_addslashes($order->ID->_) . "'";


        // Execute the query.
        $result = mssql_query($select_query);


        // If the order is already in the db...
        if (mssql_num_rows($result))
        {
                return null;
        }

        // Create a list of the columns that will be inserted into.
        $columns = "[Order_ID], [Order_ID_Type], [OrderNumber], [Description], [CreateDate], [Status], [User_ID], [User_ID_Type], [User_FirstName], [User_LastName], [User_Login_ID], [User_Email], [Seller_ID], [Seller_ID_Type], [Seller_Name], [Company_ID], [Company_ID_Type], [Company_Name], [BillingAddress_ID], [BillingAddress_ID_Type], [BillingAddress_Description], [BillingAddress_Address1], [BillingAddress_Address2], [BillingAddress_Address3], [BillingAddress_Address4], [BillingAddress_City], [BillingAddress_State], [BillingAddress_Zip], [BillingAddress_Country], [BillingAddress_PhoneNumber], [BillingAddress_FaxNumber], [BillingAddress_CompanyName], [BillingAddress_Attn], [ShippingAddress_ID], [ShippingAddress_ID_Type], [ShippingAddress_Description], [ShippingAddress_Address1], [ShippingAddress_Address2], [ShippingAddress_Address3], [ShippingAddress_Address4], [ShippingAddress_City], [ShippingAddress_State], [ShippingAddress_Zip], [ShippingAddress_Country], [ShippingAddress_PhoneNumber], [ShippingAddress_FaxNumber], [ShippingAddress_CompanyName], [ShippingAddress_Attn], [PaymentMethod], [CreditCard_AuthorizationNumber], [CreditCard_AuthorizationExpirationDate], [CreditCard_ConfirmationNumber], [CreditCard_CCType]";


        // Create a list of the values that will be inserted.
        $values = $columns;
        $values = str_replace("[Order_ID]", "'" . mssql_addslashes(@$order->ID->_) . "'", $values);
        $values = str_replace("[Order_ID_Type]", "'" . mssql_addslashes(@$order->ID->type) . "'", $values);
        $values = str_replace("[OrderNumber]", "'" . mssql_addslashes(@$order->OrderNumber) . "'", $values);
        $values = str_replace("[Description]", "'" . mssql_addslashes(@$order->Description) . "'", $values);
        $values = str_replace("[CreateDate]", "'" . mssql_addslashes(@$order->CreateDate) . "'", $values);
        $values = str_replace("[Status]", "'" . mssql_addslashes(@$order->Status) . "'", $values);
        $values = str_replace("[User_ID]", "'" . mssql_addslashes(@$order->User->ID->_) . "'", $values);
        $values = str_replace("[User_ID_Type]", "'" . mssql_addslashes(@$order->User->ID->type) . "'", $values);
        $values = str_replace("[User_FirstName]", "'" . mssql_addslashes(@$order->User->FirstName) . "'", $values);
        $values = str_replace("[User_LastName]", "'" . mssql_addslashes(@$order->User->LastName) . "'", $values);
        $values = str_replace("[User_Login_ID]", "'" . mssql_addslashes(@$order->User->LoginID) . "'", $values);
        $values = str_replace("[User_Email]", "'" . mssql_addslashes(@$order->User->Email) . "'", $values);
        $values = str_replace("[Seller_ID]", "'" . mssql_addslashes(@$order->Seller->ID->_) . "'", $values);
        $values = str_replace("[Seller_ID_Type]", "'" . mssql_addslashes(@$order->Seller->ID->type) . "'", $values);
        $values = str_replace("[Seller_Name]", "'" . mssql_addslashes(@$order->Seller->Name) . "'", $values);
        $values = str_replace("[Company_ID]", "'" . mssql_addslashes(@$order->Company->ID->_) . "'", $values);
        $values = str_replace("[Company_ID_Type]", "'" . mssql_addslashes(@$order->Company->ID->type) . "'", $values);
        $values = str_replace("[Company_Name]", "'" . mssql_addslashes(@$order->Company->Name) . "'", $values);
        $values = str_replace("[BillingAddress_ID]", "'" . mssql_addslashes(@$order->BillingAddress->ID->_) . "'", $values);
        $values = str_replace("[BillingAddress_ID_Type]", "'" . mssql_addslashes(@$order->BillingAddress->ID->type) . "'", $values);
        $values = str_replace("[BillingAddress_Description]", "'" . mssql_addslashes(@$order->BillingAddress->Description) . "'", $values);
        $values = str_replace("[BillingAddress_Address1]", "'" . mssql_addslashes(@$order->BillingAddress->Address1) . "'", $values);
        $values = str_replace("[BillingAddress_Address2]", "'" . mssql_addslashes(@$order->BillingAddress->Address2) . "'", $values);
        $values = str_replace("[BillingAddress_Address3]", "'" . mssql_addslashes(@$order->BillingAddress->Address3) . "'", $values);
        $values = str_replace("[BillingAddress_Address4]", "'" . mssql_addslashes(@$order->BillingAddress->Address4) . "'", $values);
        $values = str_replace("[BillingAddress_City]", "'" . mssql_addslashes(@$order->BillingAddress->City) . "'", $values);
        $values = str_replace("[BillingAddress_State]", "'" . mssql_addslashes(@$order->BillingAddress->State) . "'", $values);
        $values = str_replace("[BillingAddress_Zip]", "'" . mssql_addslashes(@$order->BillingAddress->Zip) . "'", $values);
        $values = str_replace("[BillingAddress_Country]", "'" . mssql_addslashes(@$order->BillingAddress->Country) . "'", $values);
        $values = str_replace("[BillingAddress_PhoneNumber]", "'" . mssql_addslashes(@$order->BillingAddress->PhoneNumber) . "'", $values);
        $values = str_replace("[BillingAddress_FaxNumber]", "'" . mssql_addslashes(@$order->BillingAddress->FaxNumber) . "'", $values);
        $values = str_replace("[BillingAddress_CompanyName]", "'" . mssql_addslashes(@$order->BillingAddress->CompanyName) . "'", $values);
        $values = str_replace("[BillingAddress_Attn]", "'" . mssql_addslashes(@$order->BillingAddress->Attn) . "'", $values);
        $values = str_replace("[ShippingAddress_ID]", "'" . mssql_addslashes(@$order->ShippingAddress->ID->_) . "'", $values);
        $values = str_replace("[ShippingAddress_ID_Type]", "'" . mssql_addslashes(@$order->ShippingAddress->ID->type) . "'", $values);
        $values = str_replace("[ShippingAddress_Description]", "'" . mssql_addslashes(@$order->ShippingAddress->Description) . "'", $values);
        $values = str_replace("[ShippingAddress_Address1]", "'" . mssql_addslashes(@$order->ShippingAddress->Address1) . "'", $values);
        $values = str_replace("[ShippingAddress_Address2]", "'" . mssql_addslashes(@$order->ShippingAddress->Address2) . "'", $values);
        $values = str_replace("[ShippingAddress_Address3]", "'" . mssql_addslashes(@$order->ShippingAddress->Address3) . "'", $values);
        $values = str_replace("[ShippingAddress_Address4]", "'" . mssql_addslashes(@$order->ShippingAddress->Address4) . "'", $values);
        $values = str_replace("[ShippingAddress_City]", "'" . mssql_addslashes(@$order->ShippingAddress->City) . "'", $values);
        $values = str_replace("[ShippingAddress_State]", "'" . mssql_addslashes(@$order->ShippingAddress->State) . "'", $values);
        $values = str_replace("[ShippingAddress_Zip]", "'" . mssql_addslashes(@$order->ShippingAddress->Zip) . "'", $values);
        $values = str_replace("[ShippingAddress_Country]", "'" . mssql_addslashes(@$order->ShippingAddress->Country) . "'", $values);
        $values = str_replace("[ShippingAddress_PhoneNumber]", "'" . mssql_addslashes(@$order->ShippingAddress->PhoneNumber) . "'", $values);
        $values = str_replace("[ShippingAddress_FaxNumber]", "'" . mssql_addslashes(@$order->ShippingAddress->FaxNumber) . "'", $values);
        $values = str_replace("[ShippingAddress_CompanyName]", "'" . mssql_addslashes(@$order->ShippingAddress->CompanyName) . "'", $values);
        $values = str_replace("[ShippingAddress_Attn]", "'" . mssql_addslashes(@$order->ShippingAddress->Attn) . "'", $values);
        $values = str_replace("[PaymentMethod]", "'" . mssql_addslashes(@$order->PaymentMethod) . "'", $values);
        $values = str_replace("[CreditCard_AuthorizationNumber]", "'" . mssql_addslashes(@$order->CreditCard->AuthorizationNumber) . "'", $values);
        $values = str_replace("[CreditCard_AuthorizationExpirationDate]", "'" . mssql_addslashes(@$order->CreditCard->AuthorizationExpirationDate) . "'", $values);
        $values = str_replace("[CreditCard_ConfirmationNumber]", "'" . mssql_addslashes(@$order->CreditCard->ConfirmationNumber) . "'", $values);
        $values = str_replace("[CreditCard_CCType]", "'" . mssql_addslashes(@$order->CreditCard->CCType) . "'", $values);

        // For any columns that we couldn't replace, set the values to NULL.		
        $values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);


        // Build the complete "INSERT" statement.
        $insert_query = "INSERT INTO Orders (" . $columns . ") VALUES (" . $values . ")";


        if ($debug === true)
        {
                echo "<h1>Order INSERT Statement Generated</h1>";
                echo "<pre>";
                echo $insert_query;
                echo "</pre>";
        }


        // Insert the order header.
        $result = mssql_query($insert_query);

        $log_stuff = "( Order Number: " . $order->OrderNumber . " ) => ( " . $order->Company->Name . " ) => ( Order_ID: " . @$order->ID->_ . " ) => Entered";
        error_log($log_stuff);

        // moved orderdetails to jobticket
        /* if ($result != null) {		

          // Get the order details.
          $orderdetails = $order->OrderDetails->OrderDetail;

          // If order details is not an array (which indicates that we have a single orderdetail object)...
          if (! is_array($orderdetails) ) {
          // Get the single object as an array.
          $new_orderdetails[] = $orderdetails;
          unset ($orderdetails);
          $orderdetails = $new_orderdetails;
          }

          // Loop over the order details array...
          foreach ($orderdetails as $orderdetail) {
          orderdetail_insert ($db, $order->ID->_, $orderdetail, $debug);
          }

          }
         */
        if (isset($order->UserGroups->UserGroup->_))
        {
                usergroup_insert($db, $order->ID->_, $order->UserGroups, $debug);
        }

        return $result;
}

?>