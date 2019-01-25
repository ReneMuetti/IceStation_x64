<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ajax_getrelayserver');

// ######################### REQUIRE BACK-END ############################
chdir('../');
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$all_servers = read_xml( $site -> config['relayserver'] );

$result = array(
              'error'   => false,
              'code'    => output_string($site -> user_lang['global']['ajax_no_error'], false),
              'message' => '',
              'count'   => 0
          );

if ( is_array($all_servers) AND count($all_servers) ) {
    $servers = array();
    $id = 0;

    foreach( $all_servers AS $server => $data ) {
        $servers[$id] = array(
                            'internal' => substr($server, 7),
                            'name'     => $data['name'],
                            'port'     => $data['port'],
                            'mount'    => str_replace('/', '', $data['mount']),
                            'demand'   => ( $data['demand'] ? true : false ),
                            'meta'     => ( $data['meta']   ? true : false )
                        );
        $id++;
    }

    $result['count']   = count($servers);
    $result['message'] = $servers;
}
else {
    $result['message'] = output_string($site -> user_lang['configuration']['relay_list_has_no_items'], false);
}

echo json_encode($result);
?>