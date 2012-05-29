<?php

/*

  Filename:

  load_printable_orders/!load_printable_orders.php


 */


// Extend maximum execution time to 600 seconds.
set_time_limit(900);


require_once ("../settings.php");
require_once ("../custom_functions.php");
require_once ("get_max_order_create_date.php");
require_once ("get_orders_by_date.php");
require_once ("order_insert.php");


// Open a connection to SQL Server.
$db = mssql_connect(SQL_Host, SQL_Login, SQL_Password);
if (!$db)
{
        die('Something went wrong while connecting to MSSQL');
}
else
{
        
}
// Get the create date of the last order received.
$start_date = get_max_order_create_date($db, Debug_Mode);
//$start_date = "9/18/2011";
// Get any new orders received.
$new_orders = get_orders_by_date($start_date, date("c"), Debug_Mode);


// Loop over the new orders...
$new_orders_list = null;
if ($new_orders != null)
{
        foreach ($new_orders as $order)
        {
                // error_log("Order: " . $order->OrderNumber);
                // Save the order in a text file.
                ob_start();
                var_dump($order);
                $var = ob_get_contents();
                ob_end_clean();
                $filename = preg_replace("/[^a-z0-9-]/", "_", strtolower($order->OrderNumber));
                file_put_contents("../printable_responses/printable_FL_order_" . $filename . ".txt", $var);

                // Insert the new order.
                $result = order_insert($db, $order, Debug_Mode);

                // If the order was inserted...
                if ($result != null)
                {
                        $new_orders_list .= "<li>" . $order->OrderNumber . "</li>";
                }
        }
}


// Display response to the user...
echo "<p>";
echo "<h1>New Orders Received Since " . date("r", strtotime($start_date)) . "</h1>";
echo "</p>";

echo "<p>";
if ($new_orders_list != null)
{
        echo "<ul>";
        echo $new_orders_list;
        echo "</ul>";
}
else
{
        echo "None.";
}
echo "</p>";
?>	
