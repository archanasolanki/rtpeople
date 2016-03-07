<?php

/*
 * Plugin Name: rtPeople
 * Author: Archana Solanki
 * Description: Developers directory plugin
 * 
 */

namespace rtCamp\WP\rtPeople;

//defines PATH, URL constants
define( 'rtCamp\WP\rtPeople\RTPEOPLE_PATH', plugin_dir_path( __FILE__ ) );
define( 'rtCamp\WP\rtPeople\RTPEOPLE_URL', plugin_dir_url( __FILE__ ) );

//includes class files
require_once \rtCamp\WP\rtPeople\RTPEOPLE_PATH . 'includes/class-load.php';
require_once \rtCamp\WP\rtPeople\RTPEOPLE_PATH . 'includes/class-admin.php';
require_once \rtCamp\WP\rtPeople\RTPEOPLE_PATH . 'includes/class-theme.php';

//loads the class-load.php
$init = new \rtCamp\WP\rtPeople\Load();
$init->init();
