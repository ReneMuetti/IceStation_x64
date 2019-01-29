<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_clearcurrentlist');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$site -> input -> clean_array_gpc('p', array(
                                     'selectList' => TYPE_NOHTML
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => ''
          );

if ( strlen($site -> GPC['selectList']) ) {
    $playlister = new PlayLister();
    $return = $playlister -> clearCurrentPlaylist( $site -> GPC['selectList'] );

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

    $result['code'] = implode("\n", $errors);
}

echo json_encode($result);
?>