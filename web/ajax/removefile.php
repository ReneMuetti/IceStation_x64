<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_removefile');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$site -> input -> clean_array_gpc('p', array(
                                     'fileID'     => TYPE_UINT,
                                     'selectList' => TYPE_NOHTML
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => ''
          );

if ( ($site -> GPC['fileID'] >= 0) AND strlen($site -> GPC['selectList']) ) {
    $playlister = new PlayLister();
    $return = $playlister -> removeFile( $site -> GPC['fileID'], $site -> GPC['selectList'] );

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

    if ( empty($site -> GPC['fileID']) ) {
        $errors[] = output_string($site -> user_lang['global']['ajax_playlist_remove_file_id_error'], true);
    }
    if( ! strlen($site -> GPC['selectList']) ) {
        $errors[] = output_string($site -> user_lang['global']['ajax_playlist_no_list_selected'], true);
    }

    $result['code'] = implode("\n", $errors);
}

echo json_encode($result);
?>