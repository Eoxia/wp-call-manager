<?php
/**
 * Initialisation du plugin.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/*
 * Plugin Name: Call-manager.
 * Description: Un plugin pour les devs d'Eoxia.
 * Version: 1.5.0.0.
 * Author: Damien.
*/

include( 'includes/admin/views/task-manager/summary-filter.php' );
include( 'includes/admin/views/form-call.php' );
include( 'includes/admin/cm-ajax-admin-function.php' );
include( 'includes/admin/cm-barmenu-admin-function.php' );
include( 'includes/admin/cm-filter-adlin-function.php' );
include( '/assets/js/admin/cm-admin.js' );
