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
echo '<pre>';
var_dump($site);
echo '</pre>';
?>