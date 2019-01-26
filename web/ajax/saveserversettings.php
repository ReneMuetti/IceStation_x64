<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_saveserversettings');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$minBitRate = 64;
$maxBitRate = 320;

$site -> input -> clean_array_gpc('p', array(
                                     'port'          => TYPE_UINT,
                                     'password'      => TYPE_NOHTML,
                                     'restartIces0'  => TYPE_BOOL,
                                     'randomIces0'   => TYPE_BOOL,
                                     'nameIces0'     => TYPE_NOHTML,
                                     'genreIces0'    => TYPE_NOHTML,
                                     'descrIces0'    => TYPE_NOHTML,
                                     'urlIces0'      => TYPE_NOHTML,
                                     'publicIces0'   => TYPE_BOOL,
                                     'recodeIces0'   => TYPE_BOOL,
                                     'bitrateIces0'  => TYPE_UINT,
                                     'channelsIces0' => TYPE_UINT
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => ''
          );

$errors = array();

if ( empty($site -> GPC['port']) OR ( $site -> GPC['port'] <= 80 ) ) {
    $result['error'] = true;
    $errors[] = output_string($site -> user_lang['global']['ajax_configuration_no_port'], false);
}
if ( empty($site -> GPC['password']) OR !strlen($site -> GPC['password']) ) {
    $result['error'] = true;
    $errors[] = output_string($site -> user_lang['global']['ajax_configuration_no_password'], false);
}
if ( empty($site -> GPC['nameIces0']) OR !strlen($site -> GPC['nameIces0']) ) {
    $result['error'] = true;
    $errors[] = output_string($site -> user_lang['global']['ajax_configuration_no_ices0_name'], false);
}
if ( empty($site -> GPC['genreIces0']) OR !strlen($site -> GPC['genreIces0']) ) {
    $result['error'] = true;
    $errors[] = output_string($site -> user_lang['global']['ajax_configuration_no_ices0_genre'], false);
}
if ( empty($site -> GPC['urlIces0']) OR !strlen($site -> GPC['urlIces0']) ) {
    $result['error'] = true;
    $errors[] = output_string($site -> user_lang['global']['ajax_configuration_no_ices0_url'], false);
}
if ( empty($site -> GPC['bitrateIces0']) OR ( $site -> GPC['bitrateIces0'] < $minBitRate ) ) {
    $result['error'] = true;
    $errors[] = output_string($site -> user_lang['global']['ajax_configuration_ices0_bitrate_error'], false);
}
if ( empty($site -> GPC['channelsIces0']) OR ( $site -> GPC['channelsIces0'] < 1 ) OR ( $site -> GPC['channelsIces0'] > 2 ) ) {
    $result['error'] = true;
    $errors[] = output_string($site -> user_lang['global']['ajax_configuration_ices0_channel_error'], false);
}

if ( $result['error'] === true ) {
    $result['code'] = implode("\n", $errors);
    unset($errors);
}
else {
    // save Configuration to XML-Files

    $configIcecast = read_xml( $site -> config['icecast'] );
        $configIcecast['listen-socket']['port']             = $site -> GPC['port'];
        $configIcecast['authentication']['source-password'] = $site -> GPC['password'];
        $xmlIcecast = buildXmlConfig($configIcecast, 'icecast');
    $errIcecast = write_xml($site -> config['icecast'], $xmlIcecast);

    if ( $errIcecast == false ) {
        $result['error'] = true;
        $errors[] = output_string($site -> user_lang['global']['ajax_error_write_file'], false) . ' ' . basename($site -> config['icecast']);
    }

    $configIces0 = read_xml( $site -> config['ices0'] );
        if ( array_key_exists('xmlns:ices', $configIces0) ) {
            unset($configIces0['xmlns:ices']);
        }
        $configIces0['Stream']['Name']        = $site -> GPC['nameIces0'];
        $configIces0['Stream']['Genre']       = $site -> GPC['genreIces0'];
        $configIces0['Stream']['Description'] = $site -> GPC['descrIces0'];
        $configIces0['Stream']['URL']         = $site -> GPC['urlIces0'];
        $configIces0['Stream']['Public']      = ( $site -> GPC['publicIces0'] ? '1' : '0' );
        $configIces0['Stream']['Reencode']    = ( $site -> GPC['recodeIces0'] ? '1' : '0' );
        $configIces0['Stream']['Bitrate']     = $site -> GPC['bitrateIces0'];
        $configIces0['Stream']['Channels']    = $site -> GPC['channelsIces0'];
        $configIces0['Playlist']['Randomize'] = ( $site -> GPC['randomIces0']  ? '1' : '0' );
        $xmlIces0 = buildXmlConfig($configIces0, 'ices:Configuration', array('xmlns:ices' => 'http://www.icecast.org/projects/ices') );
    $errIces0 = write_xml($site -> config['ices0'], $xmlIces0);

    if ( $errIces0 == false ) {
        $result['error'] = true;
        $errors[] = output_string($site -> user_lang['global']['ajax_error_write_file'], false) . ' ' . basename($site -> config['ices0']);
    }

    $configUser = read_xml( $site -> config['userconfig'] );
        $configUser['start_ices0_service'] = ( $site -> GPC['restartIces0'] ? '1' : '0' );
        $configUser['play_ranomized']      = ( $site -> GPC['randomIces0']  ? '1' : '0' );
        $xmlUser = buildXmlConfig($configUser, 'user_config');
    $errUser = write_xml($site -> config['userconfig'], $xmlUser);

    if ( $errUser == false ) {
        $result['error'] = true;
        $errors[] = output_string($site -> user_lang['global']['ajax_error_write_file'], false) . ' ' . basename($site -> config['userconfig']);
    }

    if ( $result['error'] === true ) {
        $result['code'] = implode("\n", $errors);
        unset($errors);
    }
    else {
        // all XML are write
    }
}

echo json_encode($result);
?>