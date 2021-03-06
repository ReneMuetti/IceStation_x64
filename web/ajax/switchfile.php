<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_switchfile');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$site -> input -> clean_array_gpc('p', array(
                                     'direction'  => TYPE_NOHTML,
                                     'fileID'     => TYPE_UINT,
                                     'selectList' => TYPE_NOHTML
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => ''
          );

$methods = array('up', 'down');

if ( ($site -> GPC['fileID'] >= 0) AND in_array($site -> GPC['direction'], $methods) AND strlen($site -> GPC['selectList']) ) {
    $playlister = new PlayLister();

    if ( $site -> GPC['direction'] == 'up' ) {
        $return = $playlister -> switchFile( $site -> GPC['fileID'], $site -> GPC['fileID'] - 1, $site -> GPC['selectList'] );
    }
    else {
        $return = $playlister -> switchFile( $site -> GPC['fileID'], $site -> GPC['fileID'] + 1, $site -> GPC['selectList'] );
    }

    $result['error'] = $return['error'];

    if ( $return['error'] == true ) {
        $result['code']  = $return['message'];
    }
    else {
        $result['message']  = $return['message'];
    }
}
else {
    $result['error'] = true;
    $errors = array();

    if( ! strlen($site -> GPC['selectList']) ) {
        $errors[] = output_string($site -> user_lang['global']['ajax_playlist_no_list_selected'], true);
    }
    if ( !in_array($site -> GPC['direction'], $methods) ) {
        $errors[] = output_string($site -> user_lang['global']['ajax_playlist_switch_file_method_error'], true);
    }
    if ( empty($site -> GPC['fileID']) ) {
        $errors[] = output_string($site -> user_lang['global']['ajax_playlist_switch_file_id_error'], true);
    }

    $result['code'] = implode("\n", $errors);
}

echo json_encode($result);
?>