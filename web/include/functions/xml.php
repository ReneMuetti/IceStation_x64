<?php
function read_xml($xml_file = null)
{
    $xml = file_read($xml_file);

    $xmlobj = new XML_Parser($xml);

    if ( $xmlobj -> error_no == 1 )
    {
        throw new Exception('Es wurde kein XML-Code eingelesen und die Variable $path war leer.');
    }

    if( !$arr = $xmlobj -> parse() )
    {
        throw new Exception( sprintf('XML-Fehler: <b>%1$s</b> in Zeile <b>%2$s</b>',
                                     $xmlobj -> error_string(),
                                     $xmlobj -> error_line()
                                    )
	                         );
    }

    return $xmlobj -> parseddata;
}

function write_xml()
{
}
?>