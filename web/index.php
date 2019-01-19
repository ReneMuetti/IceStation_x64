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

// left Col (Main-Settings)
$renderer -> loadTemplate('config-main-settings.htm');
$left_col = $renderer -> renderTemplate();

// right Col (Main-Settings)
$renderer -> loadTemplate('config-servers.htm');
$right_col = $renderer -> renderTemplate();

// Rendering 2-Col-Layout
$renderer -> loadTemplate('two-col.htm');
    $renderer -> setVariable('col_left' , $left_col);
    $renderer -> setVariable('col_right', $right_col);
$content = $renderer -> renderTemplate();

// Rendering Main-Page
$renderer -> loadTemplate('page.htm');
    $renderer -> setVariable('page_content', $content);
    $renderer -> renderDebugOutput($site);
    $renderer -> renderDebugOutput($renderer);
print_output($renderer -> renderTemplate());
?>