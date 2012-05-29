<?php

/*
Filename:
*/

function get_shipmentNumber($dbLogic)
{

    $query = "SELECT MAX(ShipmentNumber) AS Max_shipmentNumber FROM Shipments";

    $result = mssql_query($query, $dbLogic);

    $record = mssql_fetch_array($result);

    $max_shipmentNumber = $record["Max_shipmentNumber"];
    $shipmentnumber = $max_shipmentNumber + 1;
    // + 1
    //echo $shipmentnumber;

    mssql_free_result($result);
    unset($query);
    unset($max_shipmentNumber);
    unset($record);
    return $shipmentnumber;
}

?>