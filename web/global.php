<?php
include_once realpath('./config.php');

define ('INC_PATH'  , $config['base_path'] . '/include' );
define ('CLASS_PATH', $config['base_path'] . '/include/classes' );
define ('FUNC_PATH' , $config['base_path'] . '/include/functions' );

$config['baseurl']    = $config['protocol'] . '://' . $config['host'] . $config['script'];
$config['inc_path']   = INC_PATH;
$config['class_path'] = CLASS_PATH;
$config['func_path']  = FUNC_PATH;

include_once INC_PATH . '/autoloader.php';
?>