<?php

/*

  Filename:

  load_printable_orders/get_orders_by_date.php



 */

function get_orders_by_date($start_date, $end_date, $debug)
{

        // Initialize a SOAP client.
        $soap_client = new SoapClient(Printable_URI_Get_Order, array('trace' => 1)) or die("Unable to initialize SOAP client.");


        // Prepare the request.
        $request->OrderRequestByDate->PartnerCredentials->Token = Printable_Token_Get_Order;
        $request->OrderRequestByDate->DateRange->Start = date("c", strtotime($start_date));
        $request->OrderRequestByDate->DateRange->End = date("c", strtotime($end_date));


        // Call the GetOrdersByDate method and store the results.
        try
        {
                $result = $soap_client->GetOrdersByDate($request);
        }
        catch (SoapFault $e)
        {
                error_log("SoapFault: " . $e->getMessage());
        }
        catch (Exception $e)
        {
                error_log("Exception: " . $e->getMessage());
        }

        // If orders were returned...
        if (isset($result->GetOrdersByDateResult->GetOrdersResponse->Orders->Order))
        {
                $orders = $result->GetOrdersByDateResult->GetOrdersResponse->Orders->Order;
                if (!is_array($orders))
                {
                        $new_orders[] = $orders;
                        unset($orders);
                        $orders = $new_orders;
                }
        }
        else
        {
                $orders = null;
        }

        if ($debug === true)
        {

                if ($orders != null)
                {

                        echo "<p>";
                        echo "<h1>Orders</h1>";
                        echo $result->GetOrdersByDateResult->GetOrdersResponse->Summary->Count . " Orders Returned...";
                        echo "</p>";

                        echo "<p><hr></p>";

                        echo "<p>";
                        echo "<ul>";
                        foreach ($orders as $order)
                        {
                                echo "<li>" . $order->OrderNumber . "</li>";
                                echo "<li>" . $order->ID->_ . "</li>";
                                echo "<br/><br/>";
                        }
                        echo "</ul>";
                        echo "</p>";

                        echo "<p><hr></p>";

                        echo "<h1>Response From Web Service</h1>";
                        echo "<pre>";
                        //print_r ($result);
                        echo "</pre>";
                }
                else
                {

                        echo "<p>";
                        echo "<h1>Orders</h1>";
                        echo "No Orders Returned.";
                        echo "</p>";
                }
        }
// display what was sent to the server (the request)
        // echo "<p>Request :".htmlspecialchars($soap_client->__getLastRequest()) ."</p>";
        // display the response from the server
        //echo "<p>Response:".htmlspecialchars($soap_client->__getLastResponse())."</p>";

        return $orders;
}

?>