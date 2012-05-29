<?php
    function get_max_line_num($oID, $shippingAddress_ID)
    {
        $db = mssql_connect ("SQL1", "FPGwebservice", "kissmygrits") or die ("Unable to connect to SQL Server.");
        
        $count = 0;

        $sql_getMAX = "select count(*) as max_line
                       from pLogic.dbo.ShipmentItems
                       where ShipmentNumber = (select ShipmentNumber
                            from pLogic.dbo.Shipments
                            where FGOrder = (select OrderN
                                from pLogic.dbo.FGIOrderMast
								where WebOrderID = '" . $oID . "'
								and WebContact = '" . $shippingAddress_ID . "'))";

        $result_MAX = mssql_query ($sql_getMAX, $db);
        if (!$result_MAX)
        {
            echo "MSSQL Query failed: " . mssql_get_last_message() . "<br />\n";
            error_log('Get MAX query failed for Job Ticket: ' . $jt_number);
        }
        else
        {
            while ($row = mssql_fetch_array($result_MAX))
            {
                $count = $row[0] + 1;
            }
        }

        return $count;                
    }
?>
