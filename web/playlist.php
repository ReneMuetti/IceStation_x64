<?php
// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'playlist');

// ######################### REQUIRE BACK-END ############################
require_once './global.php';

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################
$renderer = new Templater();
$listener = new DirectoryLister( $site -> config['multimedia_root'] );

// Navbar
$renderer -> loadTemplate('navbar.htm');
    $renderer -> setVariable('header_url_home'         , $site -> config['baseurl'] . '/index.php');
    $renderer -> setVariable('header_url_icestation'   , $site -> config['baseurl'] . '/icestation.php');
    $renderer -> setVariable('header_url_playlist'     , 'javascript:void(0);');
    $renderer -> setVariable('header_url_main_log'     , $site -> config['baseurl'] . '/mainlog.php');
    $renderer -> setVariable('header_url_ices0_log'    , $site -> config['baseurl'] . '/ices0log.php');
    $renderer -> setVariable('header_home_status'      , '');
    $renderer -> setVariable('header_icestation_status', '');
    $renderer -> setVariable('header_playlist_status'  , '-current');
    $renderer -> setVariable('header_mainlog_status'   , '');
    $renderer -> setVariable('header_ices0log_status'  , '');
$navbar = $renderer -> renderTemplate();

// left Col (Playlist-Generator-Directory)
$renderer -> loadTemplate('playlist-directory.htm');
    $renderer -> setVariable('playlist_path'     , '.' . DIRECTORY_SEPARATOR);
    $renderer -> setVariable('default_dirlisting', $listener -> getCurrentDirectory());
$left_col = $renderer -> renderTemplate();

// right Col (Playlist-Generator-Content)
$renderer -> loadTemplate('playlist-content.htm');
$right_col = $renderer -> renderTemplate();

// Rendering 2-Col-Layout
$renderer -> loadTemplate('two-col.htm');
    $renderer -> setVariable('col_left' , $left_col);
    $renderer -> setVariable('col_right', $right_col);
$content = $renderer -> renderTemplate();

// Rendering Main-Page
$renderer -> loadTemplate('page.htm');
    $renderer -> setVariable('page_content', $content);
    $renderer -> setVariable('navbar'      , $navbar);
    $renderer -> renderDebugOutput($listener);
    $renderer -> renderDebugOutput($site);
print_output($renderer -> renderTemplate());
?>