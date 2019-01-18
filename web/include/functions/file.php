<?php
// #############################################################################
/**
* Returns the contents of a file
*
* @param	string	Path to file (including file name)
*
* @return	string	If file does not exist, returns an empty string
*/
function file_read($path)
{
    // On some versions of PHP under IIS, file_exists returns false for uploaded files,
    // even though the file exists and is readable. http://bugs.php.net/bug.php?id=38308
    if(!file_exists($path) AND !is_uploaded_file($path))
    {
        return '';
    }
    else
    {
        return @ file_get_contents($path);
    }
}

// #############################################################################
/**
* Converts shorthand string version of a size to bytes, 8M = 8388608
*
* @param	string			The value from ini_get that needs converted to bytes
*
* @return	integer			Value expanded to bytes
*/
function ini_size_to_bytes($value)
{
    $value  = trim($value);
    $retval = intval($value);

    switch(strtolower($value[strlen($value) - 1]))
    {
        case 'g': $retval *= 1024;
                  /* break missing intentionally */
        case 'm': $retval *= 1024;
                  /* break missing intentionally */
        case 'k': $retval *= 1024;
                  break;
    }

    return $retval;
}

?>