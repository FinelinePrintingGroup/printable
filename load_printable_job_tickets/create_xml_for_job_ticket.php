<?php
header("Content-Type: text/plain");

$db2 = mssql_connect("SQL1", "FPGwebservice", "kissmygrits") or die("Unable to connect to SQL Server");

//Retrieves the filename from the OutputFileURL based upon the last / in the string
function get_filename($string)
{
    $string = substr(strrchr($string, "/"), 1);
    $string = trim($string);
    return $string;
}

//Replaces all the bad characters we don't care to see
function fix_chars($stuff)
{
    $var = str_replace(array("&"), " + ", $stuff);
    $var = str_replace(array("’", "‘", "“", "”"), "'", $var);
    $var = str_replace(array("<br>", "<br />", "<br/>"), " - ", $var);
    return $var;    
}

//Retrieves values from the custom view based upon JT-###### string
function create_xml_for_job_ticket($db2, $job_ticket)
{
    $JobTicketNum = $job_ticket;
    
    $query = "SELECT TOP 1 *
              FROM printable.dbo.vw_PHP_PrinergyXML
              WHERE JobTicketNumber = '" . $JobTicketNum . "'
              ORDER BY JobTicketNumber Desc";
    
    //Primary Data
    $result = mssql_query($query);
    $record = mssql_fetch_array($result);
    $Job_Ticket_ID = $record["Job_Ticket_ID"];
    $JobN = $record["JobN"];
    $Qty = $record["Quantity"];
    $inGeneral = $record["inGeneral"];
    $inPaper = $record["inPaper"];
    $inFilm = $record["inFilm"];
    $inPress = $record["inPress"];
    $inBind = $record["inBind"];
    $inShipping = $record["inShipping"];
    $FileName = get_filename($record["OutputFileURL"]);
    $CompanyID = $record["Company_ID"];
    $ProductID = $record["Product_ID"];
    $SKU_ID = $record["SKU_ID"];
    $ProductName = $record["ProductName"];
    $ProductDescription = $record["ProductDescription"];
    $ShippingMethod = $record["Shipping_Method"];
    $SKU_Name = $record["SKU_Name"];
    $OrderType = $record["OrderType"];
    $DueDate = $record["DueDate"];
    $Ship_Add1 = $record["ShippingAddress_Address1"];
    $Ship_Add2 = $record["ShippingAddress_Address2"];
    $Ship_Add3 = $record["ShippingAddress_Address3"];
    $Ship_Add4 = $record["ShippingAddress_Address4"];
    $Ship_City = $record["ShippingAddress_City"];
    $Ship_State = $record["ShippingAddress_State"];
    $Ship_Zip = $record["ShippingAddress_Zip"];
    $Ship_Company = $record["ShippingAddress_CompanyName"];
    $Ship_Attn = $record["ShippingAddress_Attn"];
    
    //Secondary Info
    $OutputFileURL = $record["OutputFileURL"];
     
    //create the xml document
    $xmlDoc = new DOMDocument();
    $root = $xmlDoc->appendChild($xmlDoc->createElement("jt_xml"));
        $root->appendChild($xmlDoc->createElement("LogicJobN", fix_chars($JobN)));
        $root->appendChild($xmlDoc->createElement("JobTicketNum", fix_chars($JobTicketNum)));
        $root->appendChild($xmlDoc->createElement("Qty", fix_chars($Qty)));
        $root->appendChild($xmlDoc->createElement("GeneralInst", fix_chars($inGeneral)));
        $root->appendChild($xmlDoc->createElement("PaperInst", fix_chars($inPaper)));
        $root->appendChild($xmlDoc->createElement("FilmInst", fix_chars($inFilm)));
        $root->appendChild($xmlDoc->createElement("PressInst", fix_chars($inPress)));
        $root->appendChild($xmlDoc->createElement("BindInst", fix_chars($inBind)));
        $root->appendChild($xmlDoc->createElement("ShippingInst", fix_chars($inShipping)));
        $root->appendChild($xmlDoc->createElement("FileName", fix_chars($FileName)));
        $root->appendChild($xmlDoc->createElement("ShippingMethod", fix_chars($ShippingMethod)));
        $root->appendChild($xmlDoc->createElement("Company_ID", fix_chars($CompanyID)));
        $root->appendChild($xmlDoc->createElement("Product_ID", fix_chars($ProductID)));
        $root->appendChild($xmlDoc->createElement("SKU_ID", fix_chars($SKU_ID)));
        $root->appendChild($xmlDoc->createElement("ProductName", fix_chars($ProductName)));
        $root->appendChild($xmlDoc->createElement("ProductDescription", fix_chars($ProductDescription)));
        //Secondary Data
        $root->appendChild($xmlDoc->createElement("OutputFileURL", $OutputFileURL));
        $root->appendChild($xmlDoc->createElement("Job_Ticket_ID", fix_chars($Job_Ticket_ID)));
        $root->appendChild($xmlDoc->createElement("OrderType", fix_chars($OrderType)));
        $root->appendChild($xmlDoc->createElement("DueDate", fix_chars($DueDate)));
        $root->appendChild($xmlDoc->createElement("SKU_Name", fix_chars($SKU_Name)));
        $root->appendChild($xmlDoc->createElement("Shipping_Add1", fix_chars($Ship_Add1)));
        $root->appendChild($xmlDoc->createElement("Shipping_Add2", fix_chars($Ship_Add2)));
        $root->appendChild($xmlDoc->createElement("Shipping_Add3", fix_chars($Ship_Add3)));
        $root->appendChild($xmlDoc->createElement("Shipping_Add4", fix_chars($Ship_Add4)));
        $root->appendChild($xmlDoc->createElement("Shipping_City", fix_chars($Ship_City)));
        $root->appendChild($xmlDoc->createElement("Shipping_State", fix_chars($Ship_State)));
        $root->appendChild($xmlDoc->createElement("Shipping_Zip", fix_chars($Ship_Zip)));
        $root->appendChild($xmlDoc->createElement("Shipping_Company", fix_chars($Ship_Company)));
        $root->appendChild($xmlDoc->createElement("Shipping_Attn", fix_chars($Ship_Attn)));
        

    //make the output pretty
    header("Content-Type: text/plain");
    $xmlDoc->formatOutput = true;
    //$xmlDoc->saveXML();
    
    if (file_put_contents("../prinergyFiles/".$job_ticket.".xml", $xmlDoc->saveXML()) === false)
    {
        error_log('XML creation failed : ' . $job_ticket);
    }
    else
    {
        error_log('XML creation success : ' . $job_ticket);
    }
}

//Updates the OrderDetails table. Set column flag XmlCreated = 1
function update_xmlCreated ($job_ticket, $db2)
{
    $query_update = "UPDATE printable.dbo.OrderDetails
                     SET XmlCreated = 1
                     WHERE SupplierWorkOrder_Name = '" . $job_ticket . "'";
    
    $result_update = mssql_query($query_update, $db2);
    unset($query_update);
    unset($result_update);
}

//Grabs all JT-##### that have not had their XML file created. Gets new files within the past 720 minutes / 12 hours
$query_jt = "SELECT SupplierWorkOrder_Name
             FROM printable.dbo.OrderDetails
             WHERE XmlCreated = 0
             AND datediff(minute, cast(DateTime_Created as datetime), getdate())<= 720";

//Execute the query
$querys = mssql_query($query_jt, $db2);
if (!$querys)
{
    echo "Oh nooooooooo!";
}
else
{
    //Loop through the results
    while ($row = mssql_fetch_array($querys))
    {
        $jt_ID = $row["SupplierWorkOrder_Name"];
        create_xml_for_job_ticket($db2, $jt_ID);
        update_xmlCreated($jt_ID, $db2);
    }
}

?>
