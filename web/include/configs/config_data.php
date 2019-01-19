<?php
/**
 * Gobla System-Configuration
 */
$local_home = realpath('../');
$web_dir    = getcwd();
$xml_path   = '/root/.icestation';

$config = array(
    // Server-Variables
    'host'        => $_SERVER['HTTP_HOST'],
    'https'       => $_SERVER['HTTPS'],
    'protocol'    => $_SERVER['REQUEST_SCHEME'],
    'script'      => $_SERVER['SCRIPT_NAME'],
    'doc_root'    => $_SERVER['DOCUMENT_ROOT'],
    'server_addr' => $_SERVER["SERVER_ADDR"],
    'server_name' => $_SERVER["SERVER_NAME"],
    'server_port' => $_SERVER["SERVER_PORT"],

    // System-Paths
    'base_path' => $web_dir,
    'log_path'  => $web_dir . '/log',

    // Config-XMLs
    'icecast' => $local_home . $xml_path . '/icecast.xml',
    'ices0'   => $local_home . $xml_path . '/ices0.xml',
    'ices2'   => $local_home . $xml_path . '/ices2.xml',
);

?>