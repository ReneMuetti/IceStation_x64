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

if ( !is_array($all_servers) OR !count($all_servers) ) {
    //
}
else {
    //
}
?>