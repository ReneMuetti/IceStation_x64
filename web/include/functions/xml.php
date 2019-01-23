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

function write_xml($xml_file = null, $xml_data = null)
{
    if ( is_file($xml_file) ) {
        $xml_data = "<?xml version=\"1.0\"?>\n" . $xml_data;
        return file_write($xml_file, $xml_data);
    }
    else {
        throw new Exception( 'Datei ' . $xml_file . ' wurde nicht gefunden!' );
    }
}

function buildRelayServers($xml_data = null)
{
    global $site;

    if ( !count($xml_data) ) {
        return false;
    }
    else {
        $xml  = new XML_Builder($site, CHARSET);
        $xml -> add_group('relayserver');

        foreach( $xml_data AS $key => $value ) {
            if ( is_int($key) ) {
                $xml -> add_group('server_' . $key);
            }
            else {
                $xml -> add_group($key);
            }

            foreach( $value AS $value_key => $value_param ) {
                $xml -> add_tag($value_key, $value_param);
            }

            $xml -> close_group();
        }
        $xml -> close_group();

        return $xml -> output();
    }
}
?>