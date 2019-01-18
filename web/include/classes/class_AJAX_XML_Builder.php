<?php
// #############################################################################

class AJAX_XML_Builder extends XML_Builder
{
    function escape_cdata($xml)
    {
        $xml = preg_replace('#[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]#', '', $xml);

        return str_replace(array('<![CDATA[', ']]>'), array('<=!=[=C=D=A=T=A=[', ']=]=>'), $xml);
    }
}

?>