<?php
/**
 * Action of "Hello_World" module.
 *
 * @author You <you@mail>
 * @since 0.1.0
 * @version 0.1.0
 * @copyright 2018+
 * @package call_manager
 */

namespace call_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Action of "Hello_World" module.
 */
class Handle_Call_Action {

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'button_toolbar' ) );
		add_action( 'wp_ajax_ajax_launch', array( $this, 'ajax_load' ) );
		add_action( 'wp_ajax_send_form', array( $this, 'submit_form' ) );

	}
	/**
	* Add Button "call".
	* @since 2.0.0
	* @version 2.0.0
	*/
	public function button_toolbar( $wp_admin_bar ) {
		ob_start();
		\eoxia\View_Util::exec( 'starter', 'handle_call', 'button' );
		$args = array(
			'id'    => 'wpbeginner',
			'title' => ob_get_clean(),
		);
		$wp_admin_bar->add_node( $args );
	}
	/**
	 * Add function ajax.
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */
	public function ajax_load() {
		ob_start();
		\eoxia\View_Util::exec( 'starter', 'handle_call', 'modal' );
		$modal_view = ob_get_clean();
		ob_start();
		\eoxia\View_Util::exec( 'starter', 'handle_call', 'modal-button' );
		$modal_button_view = ob_get_clean();

		wp_send_json_success( array(
			'view'         => $modal_view,
			'buttons_view' => $modal_button_view,
		) );
	}
	/**
	 * Add function submit for form.
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */
	public function submit_form() {
		echo "<pre>"; print_r( $_POST ); echo "</pre>";
	}
}


new Handle_call_Action();
