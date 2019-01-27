<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_opendirectory');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$ds = DIRECTORY_SEPARATOR;

$site -> input -> clean_array_gpc('p', array(
                                     'directory' => TYPE_NOHTML,
                                     'rootdir'   => TYPE_NOHTML
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => '',
              'newroot' => '',
              //'debug'   => '',
          );

if ( strlen($site->GPC['rootdir']) AND strlen($site->GPC['directory']) ) {
    $listener = new DirectoryLister( $site->GPC['rootdir'] . $ds  . $site->GPC['directory'] );
    $result['message'] = $listener -> getCurrentDirectory();
    //$result['debug']   = $listener -> getLastTempDir();

    $newPath = $site -> config['multimedia_root'] . $ds . $site->GPC['rootdir'] . $ds . $site->GPC['directory'];
    $newPath = realpath($newPath);
    $newPath = str_replace($site -> config['multimedia_root'], '.', $newPath);
    if ( $newPath == '.' ) {
        $newPath .= DIRECTORY_SEPARATOR;
    }

    $result['newroot'] = $newPath;
}
else {
    $result['error'] = true;
    $result['code']  = output_string($site -> user_lang['global']['ajax_change_directory_error'], false);
}

echo json_encode($result);
?>