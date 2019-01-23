<?php
// #############################################################################
/**
* Unicode-safe version of htmlspecialchars()
*
* @param	string	Text to be made html-safe
*
* @return	string
*/
function htmlspecialchars_uni($text, $entities = true)
{
	return str_replace(
		// replace special html characters
		array('<', '>', '"'),
		array('&lt;', '&gt;', '&quot;'),
		// translates all non-unicode entities
		preg_replace('/&(?!' . ($entities ? '#[0-9]+|shy' : '(#[0-9]+|[a-z]+)') . ';)/si',
			         '&amp;',
			         $text
		            )
	);
}


// #############################################################################
/**
* Convert String to sepcified Charset
*
* @param	string	Text to be converted
* @param    bool    using PHP-Function htmlentities for output
*
* @return	string
*/
function output_string($string = '', $htmlentities = true)
{
    global $site;

    if ( $htmlentities ) {
        return htmlentities($string, ENT_XHTML, $site -> user_config['output_charset'] );
    }
    else {
        return mb_convert_encoding($string, $site -> user_config['output_iso_charset'] );
    }
}
?>