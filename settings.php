<?php

/*

  Filename:

  settings.php

 */


// Tokens assigned by Printable.
//FL Tokens
define('Printable_Token_Get_Order', "4B7C39D64F131234A7822C0692213D3C");
define('Printable_Token_Job_Ticket', "4B7C39D64F131234A7822C0692213D3C");


// URIs to the Printable Web service WSDL files.
define('Printable_URI_Get_Order', "https://services.printable.com/TRANS/0.9/Order.asmx?wsdl");
define('Printable_URI_Job_Ticket', "https://services.printable.com/TRANS/0.9/JobTicket.asmx?wsdl");
define('Printable_URI_Get_Order_Settlement', "https://services.printable.com/TRANS/0.9/settlement.asmx?wsdl");
define('Printable_URI_Invoice', "https://services.printable.com/TRANS/0.9/Invoice.asmx?wsdl");
define('Printable_URI_Closeout', "https://services.printable.com/TRANS/0.9/closeout.asmx?wsdl");
define('Printable_URI_Packing_Slip', "https://services.printable.com/TRANS/0.9/PackingSlip.asmx?wsdl");

// SQL Server database credentials.
//Printable
define('SQL_Host', "SQL1");
define('SQL_Login', "phptest");
define('SQL_Password', "test");

//Logic
//define ('Logic_SQL_Host', "localhost");	//
//define ('Logic_SQL_Login', "printable");
//define ('Logic_SQL_Password', "printable");
define('Logic_SQL_Host', "SQL1"); //
define('Logic_SQL_Login', "printable");
define('Logic_SQL_Password', "printable");

define('Super_Host', "SQL1");
define('Super_Login', "FPGwebservice");
define('Super_Password', "kissmygrits");

// Debug Mode (true / false)
define('Debug_Mode', true);


// Mail Settings
ini_set("SMTP", "192.168.240.27");
ini_set("smtp_port", "25");
ini_set('sendmail_from', 'printable@finelink.com');

// change for live
define('OutPutType_Plate_Email', 'printableajt@finelink.com'); // prepress@finelink.com
define('OutPutType_Digital_Email', 'printableajt@finelink.com'); // prepress@finelink.com
define('OutPutType_FG_Email', 'printableajt@finelink.com,shipping@finelink.com,rayv@finelink.com'); //  shipping@finelink.com
define('OutPutType_ASI_Email', 'printableajt@finelink.com'); //  asi@finelink.com
define('OutPutType_Wide_Email', 'printableajt@finelink.com'); // wideformat@finelink.com
define('OutPutType_Outside_Email', 'printableajt@finelink.com'); // purchasing@finelink.com
// Display errors.
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('memory_limit', '128M');
?>