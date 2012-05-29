<?php
/*
  Filename: index.php
 */

require_once ("settings.php");
?>	

<html>
    <head>
        <title>Test Web to Print Bridge</title>
    </head>
    <body>

        <h1>Test Web to Print Bridge</h1>

        <p>
            &bull; <a href="load_printable_orders/!load_printable_orders.php">Load New Orders From Printable</a><br>

        </p>

        <p>
            &bull; <a href="load_printable_job_tickets/!get_job_ticket_files.php">Get Files</a><br>
        </p>

        <p>
            &bull; <a href="load_printable_job_tickets/!load_printable_job_tickets.php">Load New Job Tickets From Printable</a><br>

        </p>


        <h1>Environment</h1>

        <p>
            &bull; SQL_Host: <?php echo SQL_Host; ?><br>
            &bull; Debug_Mode: <?php var_dump(Debug_Mode); ?><br>
        </p>

    </body>
</html>