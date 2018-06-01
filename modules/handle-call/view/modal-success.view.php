<?php
/**
 * Form view of "Call Manager" module.
 * une vue modal qui est retourné à l'utilisateur en cas de success avec deux bouton :retour au formulaire & fermer la modal.
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

	<h1 id="body_modal_success"><?php echo esc_html_e( 'Comment insert is Success', 'call-manager' ); ?></h1>
	<div  class="wpeo-button button-red modal-close">
		<span><?php echo esc_html_e( 'Close modal', 'Call-Manager' ); ?></span>
	</div>

	<div id="back_modal" class="wpeo-button button-green action-attribute" data-action="ajax_launch" data-reload ="ok">
		<span><?php echo esc_html_e( 'Back to the Modal', 'Call-Manager' ); ?></span>
	</div>
