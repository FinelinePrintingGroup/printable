<?php

/*

  Filename:

  load_printable_job_tickets/get_job_tickets_by_date.php


 */

function get_job_tickets_by_date ($start_date, $end_date, $debug) {

// Initialize a SOAP client.
$soap_client = new SoapClient (Printable_URI_Job_Ticket, array('trace' => 1, 'connection_timeout' => 60)) or die ("Unable to initialize SOAP client.");


// Prepare the request.
$request->JobTicketRequestByDate->PartnerCredentials->Token = Printable_Token_Job_Ticket;
$request->JobTicketRequestByDate->DateRange->Start = date("c", strtotime($start_date));
$request->JobTicketRequestByDate->DateRange->End = date("c", strtotime($end_date));


// Call the JobTicketRequestByDate method and store the results.
try
{
        $result = $soap_client->GetJobTicketsByDate ($request);
}
catch (Exception $e)
{
        error_log("Soap Client Error: " . $e->getMessage());
}

// If job tickets were returned...
if (isset($result->GetJobTicketResponse->JobTicket)) {
$job_tickets = $result->GetJobTicketResponse->JobTicket;
if (!is_array($job_tickets) ) {
$new_job_tickets[] = $job_tickets;
unset ($job_tickets);
$job_tickets = $new_job_tickets;
}
} else {
$job_tickets = null;
}

if ($debug === true) {

if ($job_tickets != null) {

echo "<p>";
echo "<h1>Job Tickets</h1>";
echo sizeof($job_tickets) . " Job Tickets Returned...";
echo "</p>";

echo "<p><hr></p>";

echo "<p>";
echo "<ul>";
foreach ($job_tickets as $job_ticket) {
echo "<li>" . $job_ticket->JobTicketNumber . "</li>";
}
echo "</ul>";
echo "</p>";

echo "<p><hr></p>";

echo "<h1>Response From Web Service</h1>";
echo "<pre>";
//print_r ($result);
echo "</pre>";

} else {

echo "<p>";
echo "<h1>Orders</h1>";
echo "No Orders Returned.";
echo "</p>";

}

}


return $job_tickets;

}
?>