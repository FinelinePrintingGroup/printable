<?php
/*
 *
 *
 *
 *
 */
function insert_logic($db, $jt_number, $debug)
{
        // REQUIRED FILES
        require_once ("get_jobN.php");
        require_once ("insert_fgi.php");
        require_once ("send_mail.php");

        if ($debug === true)
        {
                echo "<h1>Start insert : " . $jt_number . "</h1>";
        }

        $sqlOD = "Select * from OrderDetails WHERE SupplierWorkOrder_Name = '" . mssql_addslashes($jt_number) . "'";
        $resultOD = mssql_query($sqlOD, $db);
        if (!$resultOD)
        {
                echo "MSSQL Query failed: " . mssql_get_last_message() . "<br />\n";
                echo $sqlOD . "<br />\n";
        }

        $cost = 0;
        $shipcost = 0;
        $date = "2030-01-01 11:00";
        $qty = 0;
        $extrajobinfo = '';
        $product_id = '';
        $productType = '';
        $CustPON = '';
        $oID = '';
        $odID = '';
        $fileLink = '';
        $orderType = '';
        $odShipping_Method = '';
        $orderNumber = '';
        $FGIItemNumber = '';
        $SKU_Name = '';
        $Price_Tax_TaxableSalesAmount = '';

        // Iterate through returned records
        while ($row = mssql_fetch_array($resultOD))
        {
                // select earliest date...
                $tempDate = $row['Shipping_Date'];
                $product_id = $row['Product_ID'];
                $orderType = $row['OrderType'];
                $oID = $row['Order_ID'];
                $odID = $row['OrderDetail_ID'];
                $CustPON = $row['OrderNumber'];
                $orderNumber = $row['OrderNumber'];
                $SKU_Name = $row['SKU_Name'];
                $Price_Tax_TaxableSalesAmount = $row['Price_Tax_TaxableSalesAmount'];
                if (strtotime($tempDate) < strtotime($date))
                {
                        $date = $tempDate;
                }

                // add cost....
                $cost = $cost + $row['Price_Cost_Seller'];
                // add shipping cost....
                $shipcost = $shipcost + $row['Price_Cost_Shipping'];
                // add quantities
                $qty = $qty + $row['Quantity'];
                $extrajobinfo .= $row['ProductName'] . chr(13) . chr(10) . $row['SKUDescription'] . chr(13) . chr(10);
                if (!empty($row['OutputFileURL']))
                {
                        $fileLink .= $row['OutputFileURL'] . ' ' . chr(13) . chr(10);
                }

                $odShipping_Method = $row['Shipping_Method'];

                $FGIItemNumber = $row['SKUInventorySettings_Location'];

                if ($orderType == "Refill")
                {
                        $FGIItemNumber = $row['SKUDescription'];                                                   // Get full string from SKU Description
                        $before = explode("FGI#", $FGIItemNumber);                                               // Split string into array of strings by FGI#
                        $FGIItemNumber = explode("(Refill)", $before['1']);                                     // Grab the second array element, Split string into array of strings by (Refill)
                        $FGIItemNumber = $FGIItemNumber['0'];                                                       // Grab the first array element
                        $FGIItemNumber = preg_replace('/[^a-zA-Z0-9]/s', '', $FGIItemNumber);   // Removes non-standard characters from the FGI#
                        error_log("Refill Item: " . $FGIItemNumber);
                }
        }
        $extrajobinforeplaced = rtrim(str_ireplace('<br>', chr(13) . chr(10), $extrajobinfo));

        //IF OrderTYPE=Pick/BACK then FGI insert.
        // UNCOMMENT when removing go live one product
        if ($orderType == 'Pick' || $orderType == 'Back')
        {
                insert_fgi($db, $jt_number, $debug);
                //FGI STUFF
                return;
        }


        $sqlJT = "Select * from Job_Tickets WHERE JobTicketNumber = '" . mssql_addslashes($jt_number) . "'";
        $resultJT = mssql_query($sqlJT, $db);
        $recordJT = mssql_fetch_assoc($resultJT);

        $dueDate = $recordJT['DeliveryDate'];
        //if (strtotime($dueDate) < strtotime($date))
        //{
        $date = $dueDate;
        //}
        $shippingAddress_Description = $recordJT['ShippingAddress_Description'];
        $billingAddress_Description = $recordJT['BillingAddress_Description'];
        $createdDate = $recordJT['CreatedDate'];
        $company_id = $recordJT['Company_ID'];
        $jtID = $recordJT['Job_Ticket_ID'];
        $jtNumber = $recordJT['JobTicketNumber'];
        $jtFileURL = $recordJT['FinalOutputFileURL'];
        $ctMCC = $recordJT['Instructions_PaperDescription'];
        $ctPaper = $recordJT['Instructions_FilmDescription'];
        $ctBind = $recordJT['Instructions_BinderyInstructio'];
        $prodCode = (int) $recordJT['Instructions_ShippingInstructi'];
        $shippingAddress_City = $recordJT['ShippingAddress_City'];
        $shippingAddress_Zip = $recordJT['ShippingAddress_Zip'];

        if ($company_id == 13126)
        {
                //$CustPON = $recordJT['ShippingAddress_Attn'];
                $CustPON = $recordJT['ShippingAddress_Address4'];
        }

        // query table CustomerInfo using $company_id
        $sqlCI = "Select * from CustomerInfo WHERE Company_ID = '" . mssql_addslashes($company_id) . "'";
        $resultCI = mssql_query($sqlCI, $db);
        $recordCI = mssql_fetch_array($resultCI);
        $custN = $recordCI['LogicCustN'];
        $salesN = $recordCI['LogicSalesN'];
        $plannerN = $recordCI['LogicPlannerN'];
        $shipMethodN = $recordCI['ShippingMethod'];

//         if ((($company_id=="13126")&&(startsWith(strtoupper($shippingAddress_City),strtoupper("Ind"))))||(($custN=="13700")&&(startsWith(strtoupper($shippingAddress_City),strtoupper("Ind")))))
//        {
//                error_log("Salesman Changed for JT: " . $jtNumber);
//                $salesN = 50; // Mike Hehmann IU Health Exception
//                $custN = 13701;
//        }

        $outputType = '0';
        $isPurchase = '0';

        if (empty($prodCode))
        {
                $prodCode = 5;
        }
        if (empty($custN))
        {
                $custN = 24100;
        }
        if (empty($salesN))
        {
                $salesN = 45;
        }
        if (empty($plannerN))
        {
                $plannerN = 200;
        }
        if (empty($ctMCC))
        {
                $ctMCC = 0;
        }


        // ONLY GRAB ONE PRODUCT FOR NOW ...
        //if ($product_id == 575 && $company_id = 3554)
        //{
        //echo '<br>jtID ' . $jtID .  '<br>custN ' . $custN .  '<br>salesN ' . $salesN . '<br>plannerN ' . $plannerN . '<br>prodCode ' . $prodCode . '<br>';
        //connect to logic db
        $dbLogic = mssql_connect(Logic_SQL_Host, Logic_SQL_Login, Logic_SQL_Password) or die("Unable to connect to SQL Server.");

        $jobN = get_jobN($dbLogic); //get the next JobN
        // Create a list of the columns that will be inserted into.
        $columns = "[JobN], [CustomersPON], [JobDescription], [CustomerN], [ProductCode], [SalesmanN], [DueDate], [QuotedSales], [JobStatus], [BookedDate], [ProdPlanner], [FOBCode], [Quantity], [ReprintCode], [PreviousJobN], [Commission], [CommissionCode], [SalesAcctN], [ExtraJobInfo], [TaxCode], [FGIItemNumber]";

        // Create a list of the values that will be inserted.
        $values = $columns;
        $values = str_replace("[JobN]", $jobN, $values);
        $values = str_replace("[CustomersPON]", "'" . mssql_addslashes($CustPON) . "'", $values);

        if (stristr($odShipping_Method, 'RUSH'))
        {
                //Don't overwrite $jt_number => it is used in other calls.
                $values = str_replace("[JobDescription]", "'" . mssql_addslashes($jt_number) . " - RUSH!!!" . "'", $values);

                $date = strtotime("now");
                if (date('H', $date) >= 16)
                {
                        //After 4:00PM
                        $date = strtotime("+3 day", $date);
                        $date = date("M d Y H:iA", $date);
                        error_log("RUSH order processed after 4:00PM  (" . $oID . ")");
                }
                else
                {
                        ///Before 4:00PM
                        $date = strtotime("+2 day", $date);
                        $date = date("M d Y H:iA", $date);
                        error_log("RUSH order processed before 4:00PM  (" . $oID . ")");
                }
        }
        else
        {
                $values = str_replace("[JobDescription]", "'" . mssql_addslashes($jt_number) . " - " . mssql_addslashes($SKU_Name) . "'", $values);
        }

        if (strtotime($dueDate) <= strtotime("midnight"))
        {
                error_log("OpenJob DueDate Changed - Before: " . $dueDate . "  (" . $jobN . ")");
                $dueDate = strtotime("+2 day", strtotime("now"));
                $dueDate = date("M d Y H:iA", $dueDate);
        }

        $values = str_replace("[DueDate]", "'" . mssql_addslashes($date) . "'", $values);
        $values = str_replace("[CustomerN]", $custN, $values);
        $values = str_replace("[ProductCode]", $prodCode, $values);
        $values = str_replace("[SalesmanN]", $salesN, $values);
        $values = str_replace("[QuotedSales]", $cost, $values);
        $values = str_replace("[JobStatus]", 0, $values);
        $values = str_replace("[BookedDate]", "'" . mssql_addslashes($createdDate) . "'", $values);
        $values = str_replace("[ProdPlanner]", $plannerN, $values);
        $values = str_replace("[FOBCode]", 1, $values);
        $values = str_replace("[Quantity]", $qty, $values);
        $values = str_replace("[ReprintCode]", 0, $values);
        $values = str_replace("[PreviousJobN]", 0, $values);
        $values = str_replace("[Commission]", 0, $values);
        $values = str_replace("[CommissionCode]", 1, $values);
        $values = str_replace("[SalesAcctN]", 30000, $values);
        $values = str_replace("[ExtraJobInfo]", "'" . mssql_addslashes($extrajobinforeplaced) . "'", $values);
        // New tax code adjustment. Previously setting to 0
        $taxCode = 0;
        if ($Price_Tax_TaxableSalesAmount > 0)
        {
            $taxCode = 100;
        }
        else
        {
            $taxCode = 150;
        }

        $values = str_replace("[TaxCode]", $taxCode, $values);

        //For refill orders, include the FGI# on OpenJob
        if ($orderType == 'Refill')
        {
                error_log("Refill Order");

                if (strlen($FGIItemNumber) > 3) //Checks to see if the FGI Item Number is over 3 characters long. 3 is arbitrary. I didn't want it equating true for spaces or non-FGI characters.
                {
                        $values = str_replace("[FGIItemNumber]", "'" . $FGIItemNumber . "'", $values);
                }
                else
                {
                        $values = str_replace("[FGIItemNumber]", "'" . "25" . "'", $values); // If something is wrong set it to FGI Item Num: 25 which is an ErrorCode Item that alerts Guy.
                }
        }
        // If it's not a REFILL order set that sh*t to 0
        else
        {
                $values = str_replace("[FGIItemNumber]", "'" . "0" . "'", $values);
        }

        //COMMA ERROR HANDLING - REPLACE WITH A ZERO INSTEAD
        $values = str_replace(",,", ", ,", $values);
        //$values = str_replace(", ,",",'0',", $values);
        // Build the complete "INSERT" statement.
        $insert_query = "INSERT INTO OpenJob (" . $columns . ") VALUES (" . $values . ")";



        //error_log($insert_query); //Diagnostic only
        // Insert into OpenJob.
        $result = mssql_query($insert_query, $dbLogic);



        // Insert into table CT_Job JobN and Job_Ticket_ID *note NOT Job_Ticket_Number
        $insert_queryCT_Job = "INSERT INTO CT_Job (JobN, PrintableID, Order_ID, OrderDetail_ID, JobTicket_ID, MCC, MT_PrintCharge, MT_ShipCharges, Printable_BindInst, PTI_FilmInst) VALUES (" . $jobN . ",'" . mssql_addslashes($jtID) . "','" . mssql_addslashes($oID) . "','" . mssql_addslashes($odID) . "','" . mssql_addslashes($jtID) . "','" . mssql_addslashes($ctMCC) . "','" . $cost . "','" . $shipcost . "','" . mssql_addslashes($ctBind) . "','" . mssql_addslashes($ctPaper) . "')";
        //error_log($insert_queryCT_Job);
        $resultCT_Job = mssql_query($insert_queryCT_Job, $dbLogic);

        // Insert into JobShipments
        $sqlJS = "Select * from OrderDetails WHERE SupplierWorkOrder_Name = '" . mssql_addslashes($jt_number) . "'";
        $resultJS = mssql_query($sqlJS, $db);
        $JScount = 1;
        while ($row = mssql_fetch_array($resultJS))
        {
                $JSJobShipmentN = $JScount;

                if (stristr($odShipping_Method, 'RUSH'))
                {
                        if ($shipMethodN == 2)
                        {
                                $shipMethodN = 5;
                        }
                        elseif ($shipMethodN == 7)
                        {
                                $shipMethodN = 11;
                        }
                        else
                        {
                                $shipMethodN = 5; //DEFAULT FOR RUSH ORDERS?
                        }
                }
                else
                {
                        $shipMethodN = 2;
                }

                $JSShippingMethod = 2; // default for now <-- NOT EVEN USED!

                $JSQty = $row['Quantity'];
                $JSCompanyName = $row['ShippingAddress_CompanyName'];
                $JSAddrLine1 = $row['ShippingAddress_Address1'];
                $JSAddrLine2 = $row['ShippingAddress_Address2'];
                $JSAddrLine3 = $row['ShippingAddress_Address3'] . " " . $row['ShippingAddress_Address4'];
                $JSCity = $row['ShippingAddress_City'];
                $JSStateProv = $row['ShippingAddress_State'];
                $JSPostalCode = $row['ShippingAddress_Zip'];
                $JSAttn = $row['ShippingAddress_Attn'];
                $JSShippingNotes = $row['Shipping_Instructions'];
                $JSCountryCode = $row['ShippingAddress_Country'];
                $JSItemDescLine1 = $jt_number;
                $JSDeliveryReqstd = $date;

                if (($JSCountryCode == "USA") || ($JSCountryCode == "United States") || ($JSCountryCode == "US"))
                {
                        $JSCountryCode = "USA";
                }
                else if ($JSCountryCode == "Canada")
                {
                        $JSCountryCode = "CAN";
                }
                else if ($JSCountryCode == "Mexico")
                {
                        $JSCountryCode = "MEX";
                }
                else
                {
                        $JSCountryCode = "AAA";
                }


                // Create a list of the columns that will be inserted into.
                $JScolumns = "[JobN], [JobShipmentN], [ShippingMethod], [QtyToShip], [Addressee], [AddrLine1], [AddrLine2], [City], [StateProv], [PostalCode], [Attention], [ShippingNotes], [AddrLine3], [CountryCode], [ItemDescLine1], [DeliveryReqstd]";

                // Create a list of the values that will be inserted.
                $JSvalues = $JScolumns;
                $JSvalues = str_replace("[JobN]", $jobN, $JSvalues);
                $JSvalues = str_replace("[JobShipmentN]", mssql_addslashes($JSJobShipmentN), $JSvalues);
                $JSvalues = str_replace("[ShippingMethod]", mssql_addslashes($shipMethodN), $JSvalues);
                $JSvalues = str_replace("[QtyToShip]", mssql_addslashes($JSQty), $JSvalues);
                $JSvalues = str_replace("[Addressee]", "'" . mssql_addslashes($JSCompanyName) . "'", $JSvalues);
                $JSvalues = str_replace("[AddrLine1]", "'" . mssql_addslashes($JSAddrLine1) . "'", $JSvalues);
                $JSvalues = str_replace("[AddrLine2]", "'" . mssql_addslashes($JSAddrLine2) . "'", $JSvalues);
                $JSvalues = str_replace("[City]", "'" . mssql_addslashes($JSCity) . "'", $JSvalues);
                $JSvalues = str_replace("[StateProv]", "'" . mssql_addslashes($JSStateProv) . "'", $JSvalues);
                $JSvalues = str_replace("[PostalCode]", "'" . mssql_addslashes($JSPostalCode) . "'", $JSvalues);
                $JSvalues = str_replace("[Attention]", "'" . mssql_addslashes($JSAttn) . "'", $JSvalues);
                $JSvalues = str_replace("[ShippingNotes]", "'" . mssql_addslashes($JSShippingNotes) . "'", $JSvalues);
                $JSvalues = str_replace("[AddrLine3]", "'" . mssql_addslashes($JSAddrLine3) . "'", $JSvalues);
                $JSvalues = str_replace("[CountryCode]", "'" . mssql_addslashes($JSCountryCode) . "'", $JSvalues); //mssql_addslashes($JSCountryCode)
                $JSvalues = str_replace("[ItemDescLine1]", "'" . mssql_addslashes($JSItemDescLine1) . "'", $JSvalues);
                $JSvalues = str_replace("[DeliveryReqstd]", "'" . mssql_addslashes($JSDeliveryReqstd) . "'", $JSvalues);

                // Build the complete "INSERT" statement.
                $JSinsert_query = "INSERT INTO JobShipments (" . $JScolumns . ") VALUES (" . $JSvalues . ")";
                //error_log($JSinsert_query);
                $JSresult = mssql_query($JSinsert_query, $dbLogic);

                $JScount = $JScount + 1;
        }
        unset($JScount);


        if ($debug === true)
        {
                echo "<h1>End insert : " . $jt_number . "</h1>";
                echo "<pre>";
                echo $insert_query;
                echo "</pre>";
                //echo "<br />" . $result . "<br />";
        }

        //if (!empty($outputType))
        //{
        if (stristr($odShipping_Method, 'RUSH'))
        {
                $log_stuff = "RUSH JobN: " . $jobN . " - Entered";
        }
        else
        {
                $log_stuff = "JobN: " . $jobN . " - Entered";
        }
        error_log($log_stuff);

        //error_log("BinderyInstructions = " . $ctBind);

        if (stristr($odShipping_Method, 'RUSH'))
        {
                send_mail("JobN", $jobN, $extrajobinforeplaced, $date, $qty, '', $isPurchase, $outputType, 'RUSH!!! - ' . $jt_number);
        }
        else
        {
                send_mail("JobN", $jobN, $extrajobinforeplaced, $date, $qty, '', $isPurchase, $outputType, $jt_number);
        }
        //$type, $num, $desc, $date, $qty, $link, $ispurchase, $outputtype, $jt_number
        //}

        mssql_close($dbLogic);

        //}  end grab one product
}

?>