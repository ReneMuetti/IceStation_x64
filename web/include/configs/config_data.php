<?php
/**
 * Gobla System-Configuration
 */
$config = array(
    // Server-Variables
    'host'     => $_SERVER['HTTP_HOST'],
    'https'    => $_SERVER['HTTPS'],
    'protocol' => $_SERVER['REQUEST_SCHEME'],
    'script'   => $_SERVER['SCRIPT_NAME'],
    'doc_root' => $_SERVER['DOCUMENT_ROOT'],

    // System-Paths
    'base_path' => getcwd(),
    'log_path'  => getcwd() . '/log',
);

?>