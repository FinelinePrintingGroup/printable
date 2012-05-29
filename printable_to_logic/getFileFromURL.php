<?php

	/*

		Filename:


	*/
	function getFileFromURL ($fileLocation, $jtNumber) {
	
		$fdir = "../job_ticket_files/" . $jtNumber;
		$f = "../job_ticket_files/" . $jtNumber . "/" . $jtNumber . ".pdf";
		mkdir ($fdir, 0777);
		file_put_contents($f, file_get_contents($fileLocation));
		$fsize = filesize ($f);
		
		// if no/bad file.. remove it
		if ($fsize < 200)
		{
			unlink($f);
			rmdir($fdir);
		}
}

?>