<?php

/*
  Filename:
 */

function insert_fgi($db, $jt_number, $debug)
{
        require_once ("get_orderN.php");
        require_once ("get_shipmentNumber.php");
        require_once ("send_mail.php");
        require_once ("get_max_line_num_per_JT.php");

        if ($debug == true)
        {
                echo "<h1>Start FGI insert : " . $jt_number . "</h1>";
        }

        $today = date("m") . '/' . date("d") . '/' . date("Y");
        $tomorrow = "1900-01-01";
        //$tomorrow  = date("m")  . '/' . (date("d")+1) . '/' . date("Y");

        $sqlJT = "Select * from Job_Tickets WHERE JobTicketNumber = '" . mssql_addslashes($jt_number) . "'";
        $resultJT = mssql_query($sqlJT, $db);
        // get DeliveryDate, ShippingAddress_Description, BillingAddress_Description, Company_ID, Job_Ticket_ID
        $recordJT = mssql_fetch_array($resultJT);
        $date = "2030-01-01 11:00";
        $dueDate = $recordJT['DeliveryDate'];

        if (strtotime($dueDate) < strtotime($date))
        {
                $date = $dueDate;
        }


        $shippingAddress_Description = $recordJT['ShippingAddress_Description'];
        $billingAddress_Description = $recordJT['BillingAddress_Description'];
        $createdDate = $recordJT['CreatedDate'];
        $company_id = $recordJT['Company_ID'];
        $jtID = $recordJT['Job_Ticket_ID'];
        $jtNumber = $recordJT['JobTicketNumber'];
        $email = $recordJT['Email'];

        // query table CustomerInfo using $company_id
        $sqlCI = "Select * from CustomerInfo WHERE Company_ID = '" . mssql_addslashes($company_id) . "'";
        $resultCI = mssql_query($sqlCI, $db);
        $recordCI = mssql_fetch_array($resultCI);
        $custN = $recordCI['LogicCustN'];
        $salesN = $recordCI['LogicSalesN'];
        $plannerN = $recordCI['LogicPlannerN'];
        $fgibillforship = $recordCI['FGIBillForShip'];
        $shipMethodN = $recordCI['ShippingMethod'];


        if ($custN == 0)
        {
                error_log("Customer Number = 0 for " . $jt_number);
        }



        $sqlOD = "Select * from OrderDetails WHERE SupplierWorkOrder_Name = '" . mssql_addslashes($jt_number) . "'";
        $resultOD = mssql_query($sqlOD, $db);
        if (!$resultOD)
        {
                echo "MSSQL Query failed: " . mssql_get_last_message() . "<br />\n";
                echo $sqlOD . "<br />\n";
        }

        $cost = 0;
        $qty = 0;
        $extrajobinfo = '';
        $product_id = '';
        $productType = '';
        $CustPON = '';
        $oID = '';
        $odID = '';
        $fginum = 0;
        $outputType = '';
        $isPurchase = '';

        //connect to logic db
        $dbLogic = mssql_connect(Logic_SQL_Host, Logic_SQL_Login, Logic_SQL_Password) or die("Unable to connect to SQL Server.");

        // Iterate through returned records
        while ($row = mssql_fetch_array($resultOD))
        {
                //$count = 1;
                //$lastorderN = 0;
                //$lastshipmentNumber = 0;
                // select earliest date...
                $tempDate = $row['Shipping_Date'];
                $product_id = $row['Product_ID'];
                $CustPON = $row['OrderNumber'];
                $oID = $row['Order_ID'];
                $odID = $row['OrderDetail_ID'];
                $shippingMethod = $row['Shipping_Method'];
                $shippingInstructions = $row['Shipping_Instructions'];
                $shippingAddress_ID = $row['ShippingAddress_ID'];

                //Retrieve current line numbers in ShipmentItems and increment by
                $count = get_max_line_num($oID, $shippingAddress_ID); //Automatically increments it +1
                $phoneNumber = $row['ShippingAddress_PhoneNumber'];
                $shippingMethodID = $shipMethodN;

                //retrieve shipVia and shipVendor from pLogic ShipMethods Table
                $SM = "Select * from ShipMethods WHERE KeyN = '" . mssql_addslashes($shipMethodN) . "'";
                $resultSM = mssql_query($SM, $dbLogic);
                $recordSM = mssql_fetch_array($resultSM);

                $shippingMethodVIA = $recordSM['Description'];
                $shippingMethodVendor = $recordSM['VendorN'];

                if (stristr($shippingMethod, 'ups'))
                {
                        $shippingMethodID = 2;
                        $shippingMethodVIA = "UPS";
                        $shippingMethodVendor = 6625;
                }



                 // INSERT RUSH PROCESSING
                 if (stristr($shippingMethod, 'RUSH'))
                {
                        $now = strtotime("now");
                        if (date('H', $now) >= 16)
                        {
                                //After 4:00PM
                                $date = strtotime("+3 day", $now);
                                $date = date("M d Y H:iA", $date);
                                error_log("RUSH FG Order processed after 4:00PM  (" . $oID . ")");
                        }
                        else
                        {
                                ///Before 4:00PM
                                $date = strtotime("+2 day", $now);
                                $date = date("M d Y H:iA", $date);
                                error_log("RUSH FG Order processed before 4:00PM  (" . $oID . ")");
                        }
                }

                $CompanyName = $row['ShippingAddress_CompanyName'];
                $AddrLine1 = $row['ShippingAddress_Address1'];
                $AddrLine2 = $row['ShippingAddress_Address2'];
                $AddrLine3 = $row['ShippingAddress_Address3'] . " " . $row['ShippingAddress_Address4'];
                $AddrLine4 = $row['ShippingAddress_Address4'];
                $City = $row['ShippingAddress_City'];
                $StateProv = $row['ShippingAddress_State'];
                $PostalCode = $row['ShippingAddress_Zip'];
                $Attn = $row['ShippingAddress_Attn'];
                $CountryCode = $row['ShippingAddress_Country'];
                $qty = $row['Quantity'];
                //divide price_cost_seller by quantity to RE-determine unit pricing
                $pricecostseller = $row['Price_Cost_Seller'];
                if ($qty == 0)
                {
                        $priceunit = 0;
                }
                else
                {
                        $priceunit = ($pricecostseller / $qty);
                }

                $desc = $row['SKUDescription'];

                $fgiOD = $row['SKUInventorySettings_Location'];
                // Search for fgi text
                $errIndex = strpos($fgiOD, "FGI#", 0);
                // If fgi textfound,
                // remove everything before FGItext
                if ($errIndex !== false)
                {
                        $fginum = substr($fgiOD, (int) $errIndex + 4);
                }
                elseif (is_numeric($row['SKUInventorySettings_Location']))
                {
                        $fginum = $row['SKUInventorySettings_Location'];
                }
                else
                {
                        $fginum = 25;
                }


                $sqlFOM = "Select PriceUnit, CustomerOwned, Handling, ItemDescr from FGInvMaster WHERE ItemN = '" . mssql_addslashes($fginum) . "'";
                $resultFOM = mssql_query($sqlFOM, $dbLogic);
                $recordFOM = mssql_fetch_array($resultFOM);
                //$priceunit = $recordFOM['PriceUnit'];
                $customerowned = $recordFOM['CustomerOwned'];
                $billcustyn = 0;
                if ($customerowned == 0)
                {
                        $billcustyn = 1;
                }
                $handling = $recordFOM['Handling'];
                $itemdescr = $recordFOM['ItemDescr'];


                //*************************
                //wrap Finished Goods Order Master (FOM) and Shipment (S) entry allowing one Pick Ticket and Shipment per Printable order
                //*************************
                //check to see if orderid is already in fg order mast table
                $chkFOM = "Select OrderN
                     from FGIOrderMast
                     WHERE WebOrderID = '" . mssql_addslashes($oID) . "'
                     and WebContact = '" . mssql_addslashes($shippingAddress_ID) . "'";
                $resultchkFOM = mssql_query($chkFOM, $dbLogic);

                // if order id is NOT in FGIOrderMast, enter new FG Order & Shipment
                if (!mssql_num_rows($resultchkFOM))
                {
                        $orderN = get_orderN($dbLogic); //get the next OrderN
                        $shipmentNumber = get_shipmentNumber($dbLogic); //get the next ShipmentNumber
                        // Create a list of the columns that will be inserted into.
                        $FOMcolumns = "[OrderN], [CustomerN], [PON], [ShipMethodN], [ShipVia], [SalesmanN], [DateEntered], [BillForShip], [OrderStatus], [WebOrderID], [WebContact], [OrderType], [NoPartials], [OrderSource], [Comments]";

                        // Create a list of the values that will be inserted.
                        $FOMvalues = $FOMcolumns;
                        $FOMvalues = str_replace("[OrderN]", $orderN, $FOMvalues);
                        $FOMvalues = str_replace("[CustomerN]", $custN, $FOMvalues);
                        if ($company_id == 13126)
                        {
                                $FOMvalues = str_replace("[PON]", "'" . mssql_addslashes($AddrLine4) . "'", $FOMvalues);
                        }
                        else
                        {
                                $FOMvalues = str_replace("[PON]", "'" . mssql_addslashes($CustPON) . "'", $FOMvalues);
                        }
                        $FOMvalues = str_replace("[ShipMethodN]", $shippingMethodID, $FOMvalues);
                        $FOMvalues = str_replace("[ShipVia]", "'" . mssql_addslashes($shippingMethodVIA) . "'", $FOMvalues);
                        $FOMvalues = str_replace("[SalesmanN]", $salesN, $FOMvalues);
                        $FOMvalues = str_replace("[DateEntered]", "'" . mssql_addslashes($today) . "'", $FOMvalues);
                        $FOMvalues = str_replace("[BillForShip]", $fgibillforship, $FOMvalues);
                        $FOMvalues = str_replace("[OrderStatus]", 0, $FOMvalues);
                        $FOMvalues = str_replace("[WebOrderID]", $oID, $FOMvalues);
                        $FOMvalues = str_replace("[WebContact]", $shippingAddress_ID, $FOMvalues);
                        $FOMvalues = str_replace("[OrderType]", 0, $FOMvalues);
                        $FOMvalues = str_replace("[NoPartials]", 0, $FOMvalues);
                        $FOMvalues = str_replace("[OrderSource]", 0, $FOMvalues);
                        $FOMvalues = str_replace("[Comments]", "'" . mssql_addslashes($jtNumber) . "'", $FOMvalues);

                        //COMMA ERROR HANDLING - REPLACE WITH A ZERO INSTEAD
                        $FOMvalues = str_replace(',,', ', ,', $FOMvalues);
                        $FOMvalues = str_replace(", ,", ",'0',", $FOMvalues);

                        // Build the complete "INSERT" statement.
                        $FOMinsert_query = "INSERT INTO FGIOrderMast (" . $FOMcolumns . ") VALUES (" . $FOMvalues . ")";
                        $FOMresult = mssql_query($FOMinsert_query, $dbLogic);

                        // Create a list of the columns that will be inserted into.
                        $Scolumns = "[ShipmentNumber], [CarrierN], [ShipDate], [ShipMethodN], [ShippedTime], [Addressee], [AddrLine1], [AddrLine2], [City], [StateProv], [PostalCode], [ShiptoAttn], [TelephoneN], [ShippingVendor], [DivisionN], [DelInstruction], [FGOrder], [AddrLine3], [CountryCode], [CustomerN], [ShippingTerms], [ShipmentStatus]";
						// removed [Email], from shipment insert
						
                        // Create a list of the values that will be inserted.
                        $Svalues = $Scolumns;
                        $Svalues = str_replace("[ShipmentNumber]", $shipmentNumber, $Svalues);
                        $Svalues = str_replace("[CarrierN]", "'" . mssql_addslashes(' ') . "'", $Svalues);
                        $Svalues = str_replace("[ShipDate]", "'" . mssql_addslashes($tomorrow) . "'", $Svalues);
                        $Svalues = str_replace("[ShipMethodN]", "'" . mssql_addslashes($shippingMethodID) . "'", $Svalues);
                        $Svalues = str_replace("[ShippedTime]", 0, $Svalues);
                        $Svalues = str_replace("[Addressee]", "'" . mssql_addslashes($CompanyName) . "'", $Svalues);
                        $Svalues = str_replace("[AddrLine1]", "'" . mssql_addslashes($AddrLine1) . "'", $Svalues);
                        $Svalues = str_replace("[AddrLine2]", "'" . mssql_addslashes($AddrLine2) . "'", $Svalues);
                        $Svalues = str_replace("[City]", "'" . mssql_addslashes($City) . "'", $Svalues);
                        $Svalues = str_replace("[StateProv]", "'" . mssql_addslashes($StateProv) . "'", $Svalues);
                        $Svalues = str_replace("[PostalCode]", "'" . mssql_addslashes($PostalCode) . "'", $Svalues);
                        $Svalues = str_replace("[ShiptoAttn]", "'" . mssql_addslashes($Attn) . "'", $Svalues);
                        $Svalues = str_replace("[TelephoneN]", "'" . mssql_addslashes($phoneNumber) . "'", $Svalues);
                        $Svalues = str_replace("[ShippingVendor]", $shippingMethodVendor, $Svalues);
                        $Svalues = str_replace("[DivisionN]", 1, $Svalues);
                        $Svalues = str_replace("[DelInstruction]", "'" . mssql_addslashes($shippingInstructions) . "'", $Svalues);
                        $Svalues = str_replace("[FGOrder]", $orderN, $Svalues);
                        $Svalues = str_replace("[AddrLine3]", "'" . mssql_addslashes($AddrLine3) . "'", $Svalues);

                        if (($CountryCode == "USA") || ($CountryCode == "United States") || ($CountryCode == "US"))
                        {
                                $CountryCode = "USA";
                        }
                        else if ($CountryCode == "Canada")
                        {
                                $CountryCode = "CAN";
                        }
                        else if ($CountryCode == "Mexico")
                        {
                                $CountryCode = "MEX";
                        }
                        else
                        {
                                $CountryCode = "AAA";
                        }

                        $Svalues = str_replace("[CountryCode]", "'" . mssql_addslashes('USA') . "'", $Svalues);
                        //$Svalues = str_replace("[Email]", "'" . mssql_addslashes($email) . "'", $Svalues);
                        $Svalues = str_replace("[CustomerN]", $custN, $Svalues);
                        if ($company_id == 13126)
                        {
                                $Svalues = str_replace("[ShippingTerms]", 2, $Svalues);
                        }
                        else
                        {
                                $Svalues = str_replace("[ShippingTerms]", 0, $Svalues);
                        }
                        $Svalues = str_replace("[ShipmentStatus]", 0, $Svalues);

                        //COMMA ERROR HANDLING - REPLACE WITH A ZERO INSTEAD
                        $Svalues = str_replace(',,', ', ,', $Svalues);
                        $Svalues = str_replace(", ,", ",'0',", $Svalues);

                        // Build the complete "INSERT" statement.
                        $Sinsert_query = "INSERT INTO Shipments (" . $Scolumns . ") VALUES (" . $Svalues . ")";
                        $Sresult = mssql_query($Sinsert_query, $dbLogic);

                        if (!$Sresult)
                        {
                                error_log("INSERT error, insert_fgi.php, line 210, Shipment Number: " . $shipmentNumber . ", FG Order Num: " . $orderN);
                        }
                }
                else
                {
                        while ($row = mssql_fetch_array($resultchkFOM))
                        {
                                $orderN = $row[0];
                        }

                        $q_getShipmentNumber = "select ShipmentNumber
                                    from pLogic.dbo.Shipments
                                    where FGOrder = '" . $orderN . "'";

                        $result_shipNum = mssql_query($q_getShipmentNumber, $dbLogic);
                        while ($row2 = mssql_fetch_array($result_shipNum))
                        {
                                $shipmentNumber = $row2[0];
                        }
                }

                // Now insert details
                // Create a list of the columns that will be inserted into.
                $FODcolumns = "[OrderN], [OrderSeqN], [ItemN], [LastPLN], [OrderAuditN], [QtyOrdered], [QtyRemaining], [Comments], [DateDue], [ORPriceUnit], [BillCustyn], [Finalyn], [Handling], [FirstShipmentN], [USADataAttached], [UserItemDesc]";

                // Create a list of the values that will be inserted.
                $FODvalues = $FODcolumns;
                $FODvalues = str_replace("[OrderN]", $orderN, $FODvalues);
                //$FODvalues = str_replace("[OrderSeqN]", 1, $FODvalues);
                $FODvalues = str_replace("[OrderSeqN]", $count, $FODvalues);
                $FODvalues = str_replace("[ItemN]", $fginum, $FODvalues);
                $FODvalues = str_replace("[LastPLN]", 0, $FODvalues);
                //$FODvalues = str_replace("[OrderAuditN]", 1, $FODvalues);
                $FODvalues = str_replace("[OrderAuditN]", $count, $FODvalues);
                $FODvalues = str_replace("[QtyOrdered]", $qty, $FODvalues);
                $FODvalues = str_replace("[QtyRemaining]", $qty, $FODvalues);
                $FODvalues = str_replace("[Comments]", "'" . mssql_addslashes($odID) . "'", $FODvalues);
                $FODvalues = str_replace("[DateDue]", "'" . mssql_addslashes($date) . "'", $FODvalues);
                $FODvalues = str_replace("[ORPriceUnit]", $priceunit, $FODvalues);
                $FODvalues = str_replace("[BillCustyn]", $billcustyn, $FODvalues);
                $FODvalues = str_replace("[Finalyn]", 0, $FODvalues);
                $FODvalues = str_replace("[Handling]", $handling, $FODvalues);
                $FODvalues = str_replace("[FirstShipmentN]", 0, $FODvalues); //$shipmentNumber
                $FODvalues = str_replace("[USADataAttached]", 0, $FODvalues);
                $FODvalues = str_replace("[UserItemDesc]", "'" . mssql_addslashes($odID) . "'", $FODvalues);
                // Build the complete "INSERT" statement.
                $FODinsert_query = "INSERT INTO FGIOrderDetl (" . $FODcolumns . ") VALUES (" . $FODvalues . ")";
                $FODresult = mssql_query($FODinsert_query, $dbLogic);

                // Create a list of the columns that will be inserted into.
                $SIcolumns = "[ShipmentNumber], [LineN], [FinalShipyn], [Quantity], [MinorReference], [ShipmentType], [ItemDescLine1], [NbrOfCartons], [Weight], [DateCharged], [FGItemNum], [UserItemDesc]";

                // Create a list of the values that will be inserted.
                $SIvalues = $SIcolumns;
                $SIvalues = str_replace("[ShipmentNumber]", $shipmentNumber, $SIvalues);
                //$SIvalues = str_replace("[LineN]", 1, $SIvalues);
                $SIvalues = str_replace("[LineN]", $count, $SIvalues);
                $SIvalues = str_replace("[FinalShipyn]", 0, $SIvalues);
                $SIvalues = str_replace("[Quantity]", $qty, $SIvalues);
                //$SIvalues = str_replace("[MinorReference]", 1, $SIvalues);
                $SIvalues = str_replace("[MinorReference]", $count, $SIvalues);
                $SIvalues = str_replace("[ShipmentType]", 3, $SIvalues);
                $SIvalues = str_replace("[ItemDescLine1]", "'" . mssql_addslashes($itemdescr) . "'", $SIvalues);
                $SIvalues = str_replace("[NbrOfCartons]", 1, $SIvalues);
                $SIvalues = str_replace("[Weight]", 1, $SIvalues);
                $SIvalues = str_replace("[DateCharged]", "'" . mssql_addslashes($tomorrow) . "'", $SIvalues);
                $SIvalues = str_replace("[FGItemNum]", $fginum, $SIvalues);
                $SIvalues = str_replace("[UserItemDesc]", mssql_addslashes($odID), $SIvalues);

                // Build the complete "INSERT" statement.
                $SIinsert_query = "INSERT INTO ShipmentItems (" . $SIcolumns . ") VALUES (" . $SIvalues . ")";
                $SIresult = mssql_query($SIinsert_query, $dbLogic);

                $log_stuff = "FGINumber: " . $orderN . " - Entered  -  OD_ID: " . $odID;
                error_log($log_stuff);

                if ($count == 1)
                {
                        send_mail("FGINumber", $orderN, $desc, $date, $qty, '', $isPurchase, 'Pick', $jt_number);
                }
        }

        mssql_close($dbLogic);
}

?>