<?php

// MSSQL repalcement for the PHP "addslashes" function (which doesn't properly delimit single quotes in the string).
// This function delimits single quotes with single quotes, and is therefore MSSQL compatible.
function mssql_addslashes($string)
{
        $string = str_replace("'", "''", $string);
        return $string;
}

function mssql_replace($string)
{
        $string = str_replace("'", "''", $string);
        $string = (string) str_replace(array("\r", "\r\n", "\n"), '', $string);
        return $string;
}

function startsWith($haystack, $needle)
{
        $length = strlen($needle);
        if (substr($haystack, 0, $length) === $needle)
        {
                return false;
        }
        else
        {
                return true;
        }
}

?>