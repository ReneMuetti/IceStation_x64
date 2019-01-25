<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_deleterelayserver');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$site -> input -> clean_array_gpc('p', array(
                                     'server' => TYPE_UINT
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => ''
          );

if ( !empty($site -> GPC['server']) AND strlen($site -> GPC['server']) ) {
    $saved_servers = read_xml( $site -> config['relayserver'] );
    $search_server = 'server_' . $site -> GPC['server'];

    if ( array_key_exists($search_server, $saved_servers) ) {
        unset($saved_servers[$search_server]);

        $xml_content  = buildRelayServers($saved_servers);
        $write_result = write_xml($site -> config['relayserver'], $xml_content);
    }
    else {
        $result['error'] = true;
        $result['code']  = output_string($site -> user_lang['global']['ajax_delete_relay_found_error'], false);
    }
}
else {
    $result['error'] = true;
    $result['code']  = output_string($site -> user_lang['global']['ajax_delete_relay_param_error'], false);
}

echo json_encode($result);
?>