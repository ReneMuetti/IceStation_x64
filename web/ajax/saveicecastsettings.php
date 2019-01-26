<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_saveicecastsettings');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$site -> input -> clean_array_gpc('p', array(
                                     'skin'       => TYPE_NOHTML,
                                     'language'   => TYPE_NOHTML,
                                     'charset'    => TYPE_NOHTML,
                                     'isocharset' => TYPE_NOHTML
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => ''
          );

$skins = new Skins();
$skinlist = $skins -> getSkins();

$langs = new Language();
$langlist = $langs -> getLanguages();


if ( !strlen($site -> GPC['skin']) OR !in_array($site -> GPC['skin'], $skinlist) ) {
    $result['error'] = true;
    $result['code']  = output_string($site -> user_lang['global']['ajax_icestation_skin_error'], false);
}
if ( !strlen($site -> GPC['language']) OR !in_array($site -> GPC['language'], $langlist) ) {
    $result['error'] = true;
    $result['code']  = output_string($site -> user_lang['global']['ajax_icestation_lang_error'], false);
}
if ( !strlen($site -> GPC['charset']) ) {
    $result['error'] = true;
    $result['code']  = output_string($site -> user_lang['global']['ajax_icestation_charset_error'], false);
}
if ( !strlen($site -> GPC['isocharset']) ) {
    $result['error'] = true;
    $result['code']  = output_string($site -> user_lang['global']['ajax_icestation_isocharset_error'], false);
}

if ( $result['error'] == false ) {
    $configUser = read_xml( $site -> config['userconfig'] );
        $configUser['skin']               = $site -> GPC['skin'];
        $configUser['language']           = $site -> GPC['language'];
        $configUser['output_charset']     = $site -> GPC['charset'];
        $configUser['output_iso_charset'] = $site -> GPC['isocharset'];
        $xmlUser = buildXmlConfig($configUser, 'user_config');
    $errUser = write_xml($site -> config['userconfig'], $xmlUser);

    if ( $errUser == false ) {
        $result['error'] = true;
        $result['code']  = output_string($site -> user_lang['global']['ajax_error_write_file'], false) . ' ' . basename($site -> config['userconfig']);
    }
}

echo json_encode($result);
?>