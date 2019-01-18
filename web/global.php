<?php
/**
 * Loading Pre-Configuration
 */
include_once realpath('./include/configs/config_data.php');

/**
 * defined custom Constants
 */
define ('INC_PATH'  , $config['base_path'] . '/include' );
define ('CONF_PATH' , $config['base_path'] . '/include/configs' );
define ('CLASS_PATH', $config['base_path'] . '/include/classes' );
define ('FUNC_PATH' , $config['base_path'] . '/include/functions' );

/**
 * complete Configuration
 */
$config['baseurl']   = $config['protocol'] . '://' . $config['host'] . $config['script'];
$config['templates'] = $config['base_path'] . '/template';

$config['inc_path']   = INC_PATH;
$config['conf_path']  = CONF_PATH;
$config['class_path'] = CLASS_PATH;
$config['func_path']  = FUNC_PATH;

/**
 * Class-Loader
 */
include_once INC_PATH . '/autoloader.php';

/**
 * Default-Functions
 */
include_once FUNC_PATH . '/file.php';
include_once FUNC_PATH . '/xml.php';

/**
 * Init
 */
$site = new Registry();
$site -> fetch_config();
$site -> fetch_xml();
?>