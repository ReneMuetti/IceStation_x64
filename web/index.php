<?php
error_reporting(E_ALL & ~ E_NOTICE);
ini_set ('display_errors', 'On');

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'index');

// ######################### REQUIRE BACK-END ############################
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$renderer = new Templater();
$renderer -> loadTemplate('page.htm');
    $renderer -> renderDebugOutput($site);
print_output($renderer -> renderTemplate());
?>