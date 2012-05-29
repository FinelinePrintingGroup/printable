<?php

	/*

		Filename:


	*/
	function send_mail ($type, $num, $desc, $date, $qty, $link, $ispurchase, $outputtype, $jt_number) {
	
		$fdir = "\\\\plm\\job_ticket_files\\" . $link;	
		$location = '';
		if (is_dir($fdir))
			$location = realpath($fdir);
	
		if ($outputtype == 'Plate')
			$to  = OutPutType_Plate_Email;		
		elseif ($outputtype == 'Digital')
			$to  = OutPutType_Digital_Email;
		elseif ($outputtype == 'Pick')
			$to  = OutPutType_FG_Email;	
		elseif ($outputtype == 'ASI')
			$to  = OutPutType_ASI_Email;
		elseif ($outputtype == 'Wide')
			$to  = OutPutType_Wide_Email;
		elseif ($outputtype == 'Outside')
			$to  = OutPutType_Outside_Email;	
		else
			$to = 'printableajt@finelink.com';

			// subject
			$subject = 'New ' . $type . ' - ' . $num;

			// message
			$message = '
			<html>
			<head>
			  <title></title>
			</head>
			<body>			  
			  <table>				
				<tr>
				  <td>' . $type . ':</td><td>' . $num . '</td>
				</tr>
				<tr>
					<td>JT Number:</td><td>' . $jt_number . '</td>
				</tr>
				<tr>
				  <td valign="top">Description:</td><td valign="top">' . $desc . '</td>
				</tr>
				<tr>
				  <td>DueDate:</td><td>' . $date . '</td>
				</tr>
				<tr>
				  <td>Quantity:</td><td>' . $qty . '</td>
				</tr>
			  </table>
			</body>
			</html>
			';

			/*

				<tr>
				  <td>File Path(server):</td><td>' . $location . '</td>
				</tr>					
				<tr>
				  <td>OutputType:</td><td>' . $outputtype . '</td>
				</tr>					
			*/
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers			
			$headers .= 'From: <printable@finelink.com>' . "\r\n";
			if ($ispurchase == 'Y' && $outputtype != 'Outside')
			{
				$headers .= 'Cc: ' . OutPutType_Outside_Email . "\r\n";
			}

			// Mail it
			mail($to, $subject, $message, $headers);
                                 error_log("Email sent to: " . $to . " - " . $jt_number . " - " . $subject  );
					
		
}

?>