<?php
/**
 * Button view of "Call Manager"
 * module bouton qui sert à ouvrir la modal dans la barre d'administration.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018
 * @package call_manager
 */

namespace handle_call;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="wpeo-button button-main wpeo-modal-event"
	data-action="ajax_launch"
	data-title="Call Manager"
	>
	<i class="#"></i> <span><?php echo esc_html_e( 'Incomming Call', 'call-manager' ); ?></span>
</div>
