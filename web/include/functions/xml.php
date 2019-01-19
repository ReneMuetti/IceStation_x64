<?php
function read_xml($xml_file = null)
{
    if ( is_file($xml_file) ) {
        $xml = file_read($xml_file);

        $xmlobj = new XML_Parser($xml);

        if ( $xmlobj -> error_no == 1 )
        {
            throw new Exception('Es wurde kein XML-Code eingelesen und die Variable $path war leer.');
        }

        if( !$arr = $xmlobj -> parse() )
        {
            echo '<pre>';
                var_dump($xml_file);
                var_dump($xml);
                var_dump($xmlobj);

                throw new Exception( sprintf('XML-Fehler: <b>%1$s</b> in Zeile <b>%2$s</b>',
                                             $xmlobj -> error_string(),
                                             $xmlobj -> error_line()
                                            )
	                                 );
            echo '</pre>';
        }

        return $xmlobj -> parseddata;
    }
    else {
        throw new Exception( 'Datei ' . $xml_file . ' wurde nicht gefunden!' );
    }
}

function write_xml()
{
}
?>