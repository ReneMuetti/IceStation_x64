<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_addrelayserver');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$site -> input -> clean_array_gpc('p', array(
                                     'name'   => TYPE_NOHTML,
                                     'port'   => TYPE_UINT,
                                     'mount'  => TYPE_NOHTML,
                                     'demand' => TYPE_BOOL,
                                     'meta'   => TYPE_BOOL
                                 ));

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => ''
          );

if ( strlen($site -> GPC['name']) AND !empty($site -> GPC['port']) AND strlen($site -> GPC['mount']) ) {
    $localmount = rand(100000, 999999);

    $saved_servers = read_xml( $site -> config['relayserver'] );

    if ( !is_array($saved_servers) OR !count($saved_servers) ) {
        $saved_servers = array();
    }

    $saved_servers['server_' . $localmount] = array(
                                                  'name'   => $site -> GPC['name'],
                                                  'port'   => $site -> GPC['port'],
                                                  'mount'  => str_replace('/', '', $site -> GPC['mount']),
                                                  'demand' => $site -> GPC['demand'],
                                                  'meta'   => $site -> GPC['meta'],
                                              );

    $xml_content  = buildRelayServers($saved_servers);
    $write_result = write_xml($site -> config['relayserver'], $xml_content);

    $result['message'] = $localmount;
}
else {
    $result['error'] = true;
    $result['code']  = output_string($site -> user_lang['global']['ajax_new_relay_param_error'], false);

    if ( !strlen($site -> GPC['name']) ) {
        $result['code'] .= "\n" . output_string($site -> user_lang['global']['ajax_new_relay_no_name'], false);
    }
    if ( empty($site -> GPC['port']) ) {
        $result['code'] .= "\n" . output_string($site -> user_lang['global']['ajax_new_relay_no_port'], false);
    }
    if ( !strlen($site -> GPC['mount']) ) {
        $result['code'] .= "\n" . output_string($site -> user_lang['global']['ajax_new_relay_no_mount'], false);
    }
}

echo json_encode($result);
?>