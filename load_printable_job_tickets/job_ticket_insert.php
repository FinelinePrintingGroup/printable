<?php

/*

  Filename:

  load_printable_job_tickets/job_ticket_insert.php



 */

function job_ticket_insert($db, $job_ticket, $debug)
{

        require_once ("orderdetail_insert.php");

        if ($debug === true)
        {
                echo "<h1>Job Ticket Object (passed to job_ticket_insert)</h1>";
                echo "<pre>";
                //var_dump ($job_ticket);
                echo "</pre>";
        }


        // Create a query used to check for the existance of the job ticket in the bridge.
        $select_query = "SELECT * FROM Job_Tickets WHERE Job_Ticket_ID = '" . mssql_addslashes($job_ticket->ID->_) . "'";


        // Execute the query.
        $result = mssql_query($select_query);


        // If the job ticket is already in the Bridge...
        if (mssql_num_rows($result))
        {
                return null;
        }

        // Create a list of the columns that will be inserted into.
        $columns = "[Job_Ticket_ID], [Job_Ticket_ID_Type], [JobTicketNumber], [ProjectDescription], [CreatedDate], [Sales_ID], [Sales_ID_Type], [Company_ID], [Company_ID_Type], [Supplier_ID], [Supplier_ID_Type], [SupplierOrderStatus], [BillingAddress_Description], [BillingAddress_Address1], [BillingAddress_Address2], [BillingAddress_Address3], [BillingAddress_Address4], [BillingAddress_City], [BillingAddress_State], [BillingAddress_Zip], [BillingAddress_Country], [BillingAddress_Attn], [ShippingAddress_Description], [ShippingAddress_Address1], [ShippingAddress_Address2], [ShippingAddress_Address3], [ShippingAddress_Address4], [ShippingAddress_City], [ShippingAddress_State], [ShippingAddress_Zip], [ShippingAddress_Country], [ShippingAddress_Attn], [DeliveryDate], [Email], [FinalOutputFileURL], [Instructions_Email],[Instructions_GeneralDescription],[Instructions_PaperDescription],[Instructions_FilmDescription],[Instructions_PressInstructions],[Instructions_BinderyInstructions],[Instructions_ShippingInstructions]";


        // Create a list of the values that will be inserted.
        $values = $columns;
        $values = str_replace("[Job_Ticket_ID]", "'" . mssql_addslashes($job_ticket->ID->_) . "'", $values);
        $values = str_replace("[Job_Ticket_ID_Type]", "'" . mssql_addslashes($job_ticket->ID->type) . "'", $values);
        $values = str_replace("[JobTicketNumber]", "'" . mssql_addslashes($job_ticket->JobTicketNumber) . "'", $values);
        $values = str_replace("[ProjectDescription]", "'" . mssql_addslashes($job_ticket->ProjectDescription) . "'", $values);
        $values = str_replace("[CreatedDate]", "'" . mssql_addslashes($job_ticket->CreatedDate) . "'", $values);
        $values = str_replace("[Sales_ID]", "'" . mssql_addslashes($job_ticket->SalesID->_) . "'", $values);
        $values = str_replace("[Sales_ID_Type]", "'" . mssql_addslashes($job_ticket->SalesID->type) . "'", $values);
        $values = str_replace("[Company_ID]", "'" . mssql_addslashes($job_ticket->CompanyID->_) . "'", $values);
        $values = str_replace("[Company_ID_Type]", "'" . mssql_addslashes($job_ticket->CompanyID->type) . "'", $values);
        $values = str_replace("[Supplier_ID]", "'" . mssql_addslashes($job_ticket->SupplierID->_) . "'", $values);
        $values = str_replace("[Supplier_ID_Type]", "'" . mssql_addslashes($job_ticket->SupplierID->type) . "'", $values);
        $values = str_replace("[SupplierOrderStatus]", "'" . mssql_addslashes($job_ticket->SupplierOrderStatus) . "'", $values);
        
        
        for ($i = 0; $i < 2; $i++)
        {
                if ($job_ticket->Address[$i]->Type == "Billing")
                {
                        $values = str_replace("[BillingAddress_Description]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Description) . "'", $values);
                        $values = str_replace("[BillingAddress_Address1]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address1) . "'", $values);
                        $values = str_replace("[BillingAddress_Address2]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address2) . "'", $values);
                        $values = str_replace("[BillingAddress_Address3]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address3) . "'", $values);
                        $values = str_replace("[BillingAddress_Address4]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address4) . "'", $values);
                        $values = str_replace("[BillingAddress_City]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->City) . "'", $values);
                        $values = str_replace("[BillingAddress_State]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->State) . "'", $values);
                        $values = str_replace("[BillingAddress_Zip]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Zip) . "'", $values);
                        $values = str_replace("[BillingAddress_Country]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Country) . "'", $values);
                        $values = str_replace("[BillingAddress_Attn]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Attn) . "'", $values);
                }
                else
                {
                        $values = str_replace("[ShippingAddress_Description]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Description) . "'", $values);
                        $values = str_replace("[ShippingAddress_Address1]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address1) . "'", $values);
                        $values = str_replace("[ShippingAddress_Address2]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address2) . "'", $values);
                        $values = str_replace("[ShippingAddress_Address3]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address3) . "'", $values);
                        $values = str_replace("[ShippingAddress_Address4]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Address4) . "'", $values);
                        $values = str_replace("[ShippingAddress_City]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->City) . "'", $values);
                        $values = str_replace("[ShippingAddress_State]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->State) . "'", $values);
                        $values = str_replace("[ShippingAddress_Zip]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Zip) . "'", $values);
                        $values = str_replace("[ShippingAddress_Country]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Country) . "'", $values);
                        $values = str_replace("[ShippingAddress_Attn]", "'" . mssql_addslashes(@$job_ticket->Address[$i]->Attn) . "'", $values);
                }
        }

        $DeliveryDate = $job_ticket->DeliveryDate;
        
        if (strtotime($DeliveryDate) <= strtotime("midnight"))
        {
                error_log("JT DueDate Changed - Before: " . $DeliveryDate . "  (" . $job_ticket->JobTicketNumber . ")");
                $DeliveryDate = strtotime("+2 day", strtotime("now"));
                $DeliveryDate = date("M d Y H:iA", $DeliveryDate);
        }
        

        $values = str_replace("[DeliveryDate]", "'" . mssql_addslashes($DeliveryDate) . "'", $values);
        $values = str_replace("[Email]", "'" . mssql_addslashes($job_ticket->Email) . "'", $values);
        $values = str_replace("[FinalOutputFileURL]", "'" . mssql_addslashes(@$job_ticket->FinalOutputFileURL->URL) . "'", $values);

        $values = str_replace("[Instructions_Email]", "'" . mssql_addslashes(@$job_ticket->JobTicketInstructions->Email) . "'", $values);
        $values = str_replace("[Instructions_GeneralDescription]", "'" . mssql_addslashes(@$job_ticket->JobTicketInstructions->GeneralDescription) . "'", $values);
        $values = str_replace("[Instructions_PaperDescription]", "'" . mssql_addslashes(@$job_ticket->JobTicketInstructions->PaperDescription) . "'", $values);
        $values = str_replace("[Instructions_FilmDescription]", "'" . mssql_addslashes(@$job_ticket->JobTicketInstructions->FilmDescription) . "'", $values);
        $values = str_replace("[Instructions_PressInstructions]", "'" . mssql_addslashes(@$job_ticket->JobTicketInstructions->PressInstructions) . "'", $values);
        $values = str_replace("[Instructions_BinderyInstructions]", "'" . mssql_addslashes(@$job_ticket->JobTicketInstructions->BinderyInstructions) . "'", $values);
        $values = str_replace("[Instructions_ShippingInstructions]", "'" . mssql_addslashes(@$job_ticket->JobTicketInstructions->ShippingInstructions) . "'", $values);



        // For any columns that we couldn't replace, set the values to NULL.		
        $values = preg_replace('/\[[^\]]*\]/', 'NULL', $values);


        // Build the complete "INSERT" statement.
        $insert_query = "INSERT INTO Job_Tickets (" . $columns . ") VALUES (" . $values . ")";


        if ($debug === true)
        {
                echo "<h1>Job_Ticket INSERT Statement Generated</h1>";
                echo "<pre>";
                echo $insert_query;
                echo "</pre>";
        }


        // Insert the job ticket.
        $result = mssql_query($insert_query);

        //INSERT XML CREATION FUNCTION HERE
        // If the order header was inserted...
        if ($result != null)
        {

                // Get the order details.
                $orderdetails = $job_ticket->OrderDetails->OrderDetail;

                // If order details is not an array (which indicates that we have a single orderdetail object)...
                if (!is_array($orderdetails))
                {
                        // Get the single object as an array.
                        $new_orderdetails[] = $orderdetails;
                        unset($orderdetails);
                        $orderdetails = $new_orderdetails;
                }

                // Loop over the order details array...
                foreach ($orderdetails as $orderdetail)
                {
                        orderdetail_insert($db, $job_ticket->ID->_, $orderdetail, $debug);
                }
        }


        return $result;
}

?>