<?php

/*

  Filename:

  load_printable_job_tickets/get_max_job_ticket_create_date.php


 */

function get_max_job_ticket_create_date($db, $debug)
{
        // TIME ZONE SETTING FOR ALL "DATE" FUNCTIONS
        date_default_timezone_set("America/Indianapolis");

        $query = "SELECT MAX(CreatedDate) AS Max_CreateDate FROM Job_Tickets";

        $result = mssql_query($query);

        $record = mssql_fetch_array($result);

        // OLD SETTING
        //$max_job_ticket_create_date = $record["Max_CreateDate"];
        // NEW SETTING TO TAKE CURRENT DATE AND SUBTRACT 3 DAYS
        $date = $record["Max_CreateDate"];

        if ((date('H', strtotime("now")) >= 2) && (date('H', strtotime("now")) < 3))
        {
                error_log("It's between the late night hours!!!");
                $newdate = strtotime("-1 month", strtotime($date));
        }
        else
        {
                $newdate = strtotime("-3 day", strtotime($date));
                //$newdate = strtotime("-1 month", strtotime($date)); // Use this for manually pushing back 1 month.
        }

        $max_job_ticket_create_date = date("M d Y", $newdate);

        //$max_job_ticket_create_date = "2011-11-17";

        if ($max_job_ticket_create_date == null)
        {
                $max_job_ticket_create_date = "2010-01-31";
        }

        if ($debug === true)
        {

                echo "<p>";
                echo "<h1>Max Job Ticket Create Date</h1>";
                echo $max_job_ticket_create_date;
                echo "</p>";
        }

        return $max_job_ticket_create_date;
}

?>