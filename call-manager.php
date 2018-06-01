<?php
/*
Plugin Name: Call manger
Plugin URI:
Description: plugin pour traîté les appels entrant
ce plugin fonctionne avec WP_shop et Task_manger.
Version: 2.0.0
Author: You <you@mail> => @author Eoxia <dev@eoxia.com>
Text Domain: call-manager
Author URI:
License:
License URI:
*/

namespace call_manager;

DEFINE( 'PLUGIN_CALL_MANAGER_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
DEFINE( 'PLUGIN_CALL_MANAGER_URL', plugins_url( basename( __DIR__ ) ) . '/' );
DEFINE( 'PLUGIN_CALL_MANAGER_DIR', basename( __DIR__ ) );

// Boot your plugin.
require_once 'core/external/eo-framework/eo-framework.php';

\eoxia\Init_Util::g()->exec( PLUGIN_CALL_MANAGER_PATH, basename( __FILE__, '.php' ) );
