<?php
/**
 * Enable Error-Reposting vor Development
 */
error_reporting(E_ALL & ~ E_NOTICE);
ini_set ('display_errors', 'On');

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
define ('BASE_URL'  , $config['protocol'] . '://' . $config['host'] . dirname($config['script']) );
define ('CHARSET'   , ini_get('default_charset'));
define ('SAPI_NAME' , php_sapi_name() );
define ('MIN_LIMIT' , 1800);

/**
 * complete Configuration
 */
$config['charset']   = CHARSET;
$config['baseurl']   = BASE_URL;
$config['skins']     = $config['base_path'] . '/skin';
$config['templates'] = $config['base_path'] . '/skin/template';
$config['languages'] = $config['base_path'] . '/language';

// Multimedia-Settings
$config['multimedia_root'] = realpath('/share/Multimedia');
$config['multimedia_link'] = '/share/Multimedia';

$config['inc_path']   = INC_PATH;
$config['conf_path']  = CONF_PATH;
$config['class_path'] = CLASS_PATH;
$config['func_path']  = FUNC_PATH;

// Relay-Server
$config['relayserver'] = CONF_PATH . '/relayserver.xml';
$config['userconfig']  = CONF_PATH . '/custom_config.xml';

/**
 * Class-Loader
 */
include_once INC_PATH . '/autoloader.php';

/**
 * Default-Functions
 */
include_once FUNC_PATH . '/file.php';
include_once FUNC_PATH . '/xml.php';
include_once FUNC_PATH . '/functions.php';

/**
 * Init
 */
$site = new Registry();
$site -> fetch_config();
$site -> fetch_xml();
?>