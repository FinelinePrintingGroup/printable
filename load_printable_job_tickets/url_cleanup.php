<?php

// This file is only the logic needed to find URLs that are affected by the legacy systems. 
// Incoming URL is not set into a variable.
// Outgoing URL is not set either.

function url_cleanup($fileURL)
{
    // Static URL
    $preURL = "http://images.printable.com/nonimpositions/";

    // Search for legacy error
    @$errIndex = strpos($fileURL, "//", 20);

    // If legacy error found,
    // remove everything before the '//'
    // and concatenate it to static URL
    if ($errIndex !== false)
    {
        $postURL = substr($fileURL, (int) $errIndex + 2);
        $fileURL = $preURL . $postURL;
    }

    // Return the file URL
    return $fileURL;
}

?>