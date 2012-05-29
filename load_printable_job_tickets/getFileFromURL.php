<?php

/*

  Filename:


 */

function remote_file_size($url)
{
    $head = "";
    $url_p = parse_url($url);
    $host = $url_p["host"];
    if (!preg_match("/[0-9]*\.[0-9]*\.[0-9]*\.[0-9]*/", $host))
    {
        // a domain name was given, not an IP
        $ip = gethostbyname($host);
        if (!preg_match("/[0-9]*\.[0-9]*\.[0-9]*\.[0-9]*/", $ip))
        {
            //domain could not be resolved
            return -1;
        }
    }
    $port = 80;
    $path = $url_p["path"];
    //echo "Getting " . $host . ":" . $port . $path . " ...";

    $fp = fsockopen($host, $port, $errno, $errstr, 20);
    if (!$fp)
    {
        return false;
    }
    else
    {
        fputs($fp, "HEAD " . $url . " HTTP/1.1\r\n");
        fputs($fp, "HOST: " . $host . "\r\n");
        fputs($fp, "User-Agent: http://www.example.com/my_application\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        $headers = "";
        while (!feof($fp))
        {
            $headers .= fgets($fp, 128);
        }
    }
    fclose($fp);
    //echo $errno .": " . $errstr . "<br />";
    $return = -2;
    $arr_headers = explode("\n", $headers);
    // echo "HTTP headers for <a href='" . $url . "'>..." . substr($url,strlen($url)-20). "</a>:";
    // echo "<div class='http_headers'>";
    foreach ($arr_headers as $header)
    {
        // if (trim($header)) echo trim($header) . "<br />";
        $s1 = "HTTP/1.1";
        $s2 = "Content-Length: ";
        $s3 = "Location: ";
        if (substr(strtolower($header), 0, strlen($s1)) == strtolower($s1))
            $status = substr($header, strlen($s1));
        if (substr(strtolower($header), 0, strlen($s2)) == strtolower($s2))
            $size = substr($header, strlen($s2));
        if (substr(strtolower($header), 0, strlen($s3)) == strtolower($s3))
            $newurl = substr($header, strlen($s3));
    }
    // echo "</div>";
    if (intval($size) > 0)
    {
        $return = intval($size);
    }
    else
    {
        $return = $status;
    }
    // echo intval($status) .": [" . $newurl . "]<br />";
    if (intval($status) == 302 && strlen($newurl) > 0)
    {
        // 302 redirect: get HTTP HEAD of new URL
        $return = remote_file_size($newurl);
    }
    return $return;
}

function getFileFromURL($fileLocation, $jtNumber, $OD_ID, $db)
{

    $remoteFSize = remote_file_size($fileLocation);
    // File sizes below 200 bytes are empty, greater than 20 MB will cause a time out
    //echo '<br>REMOTE FILE SIZE: ' . $remoteFSize . ' fname: ' . $fileLocation . '<br>';

    $fdir = "../job_ticket_files/" . $jtNumber;
    $filecount = 0;
    $isDir = false;
    if (is_dir($fdir))
    {
        $isDir = true;
        if (glob($fdir . '/*') != false)
        {
            $filecount = count(glob($fdir . '/*'));
        }
        else
        {
            $filecount = 1;
        }
    }

    if ($remoteFSize > 200 && $remoteFSize < 20000001)
    {
        if (!$isDir)
        {
            mkdir($fdir, 0777);
        }
        //DOWNLOAD WITH FILECOUNT (ORIGINAL)
        //$f = "../job_ticket_files/" . $jtNumber . "/" . $jtNumber . '_' . $filecount . ".pdf";
        //file_put_contents($f, file_get_contents($fileLocation));

//			//PRINERGY FILES
//			$f1 = "../PrinergyFiles/" . $jtNumber . '_' . $filecount . ".pdf";
//			file_put_contents($f1, file_get_contents($fileLocation));
        //DOWNLOAD WITH ACTUAL FILENAME
        $filename = $fileLocation;
        $filename = substr(strrchr($filename, "/"), 1);
        $filename = str_replace(".pdf", '', $filename);
        $filename = trim($filename);
        $f2 = "../job_ticket_files/" . $jtNumber . "/" . $filename . ".pdf";
        
        $file = file_get_contents($fileLocation);
        
        if ($file === false)
        {
            error_log('File GET error for ' . $jtNumber);
        }
        else
        {
            if (file_put_contents($f2, $file) === false)
            {
                error_log('File PUT error for ' . $jtNumber);
            }
            else
            {
                error_log('File download successful for ' . $jtNumber);
                updateOD($OD_ID, $db);
            }
        }   
    }
    elseif ($remoteFSize > 20000000)
    {
        if (!$isDir)
        {
            mkdir($fdir, 0777);
        }
        ob_start();
        echo ($fileLocation);
        $var = ob_get_contents();
        ob_end_clean();
        $filename = 'FileTooLargeURLInside';
        file_put_contents("../job_ticket_files/" . $jtNumber . "/" . $filename . '_' . $filecount . ".txt", $var);
        updateOD($OD_ID, $db);
    }
}

function updateOD($OD_ID, $db)
{
    //Update OD to inserted
    $sqlupdate = "Update OrderDetails Set FileDownloaded = 1 Where OrderDetail_ID = '" . mssql_addslashes($OD_ID) . "'";
    $resultupdate = mssql_query($sqlupdate, $db);
    unset($sqlupdate);
    unset($resultupdate);
}

?>