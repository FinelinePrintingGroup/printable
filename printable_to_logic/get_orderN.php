<?php
    /*
            Filename:
    */
    function get_orderN ($dbLogic) 
    {
        $query = "SELECT MAX(orderN) AS Max_orderN FROM FGIOrderMast";

        $result = mssql_query ($query, $dbLogic);

        $record = mssql_fetch_array ($result);

        $max_orderN = $record["Max_orderN"];
        $ordern = $max_orderN + 1;
        // + 1
        //echo $ordern;

        mssql_free_result($result);
        unset($query);
        unset($max_orderN);
        unset($record);
        
        return $ordern;
    }
?>