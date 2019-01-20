<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'ices0log');

// ######################### REQUIRE BACK-END ############################
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$renderer = new Templater();

// Navbar
$renderer -> loadTemplate('navbar.htm');
    $renderer -> setVariable('header_url_home'       , $site -> config['baseurl'] . '/index.php');
    $renderer -> setVariable('header_url_playlist'   , $site -> config['baseurl'] . '/playlist.php');
    $renderer -> setVariable('header_url_main_log'   , $site -> config['baseurl'] . '/mainlog.php');
    $renderer -> setVariable('header_url_ices0_log'  , 'javascript:void(0);');
    $renderer -> setVariable('header_home_status'    , '');
    $renderer -> setVariable('header_playlist_status', '');
    $renderer -> setVariable('header_mainlog_status' , '');
    $renderer -> setVariable('header_ices0log_status', '-current');
$navbar = $renderer -> renderTemplate();

$content = '';

// Rendering Main-Page
$renderer -> loadTemplate('page.htm');
    $renderer -> setVariable('page_content', $content);
    $renderer -> setVariable('navbar'      , $navbar);
    $renderer -> renderDebugOutput($site);
    $renderer -> renderDebugOutput($renderer);
print_output($renderer -> renderTemplate());
?>