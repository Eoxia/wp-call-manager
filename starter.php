<?php
/*
Plugin Name: EO Framework Starter
Plugin URI:
Description:
Version: 0.1.0
Author:
Author URI:
License:
License URI:
*/

namespace call_manager;

DEFINE( 'PLUGIN_CALL_MANAGER_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
DEFINE( 'PLUGIN_CALL_MANAGER_URL', plugins_url( basename( __DIR__ ) ) . '/' );
DEFINE( 'PLUGIN_CALL_MANAGER_DIR', basename( __DIR__ ) );

// Include EO_Framework.
require_once 'core/external/eo-framework/eo-framework.php';

// Boot your plugin.
\eoxia\Init_Util::g()->exec( PLUGIN_CALL_MANAGER_PATH, basename( __FILE__, '.php' ) );
