<?php
/**
 * Action of "Hello_World" module.
 *
 * @author You <you@mail>
 * @since 2.0.0
 * @version 2.0.0
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
	 * @since 2.0.0
	 * @version 0.0.0
	 */
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'button_toolbar' ) );
		add_action( 'wp_ajax_ajax_launch', array( $this, 'ajax_load' ) );

		add_action( 'wp_ajax_send_form', array( $this, 'submit_form', 'insert_form' ) );

		add_action( 'wp_ajax_affich_users', array( $this, 'select_users' ) );

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
		$users = \eoxia\User_Class::g()->get( array(
			'role' => 'administrator',
		) );

		ob_start();
		\eoxia\View_Util::exec( 'starter', 'handle_call', 'modal', array(
			'users' => $users,
		) );
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
		echo '<pre>';
		//print_r( $_POST['type'] ) AND $_POST['Commentaire'] );
		echo '</pre>';
	}
	/**
	 * Add insert request for the form.
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */
	public function insert_form() {
		if ( isset( $_POST['Commentaire'] ) || isset( $_POST['type'] ) && ( '' !== $_POST['Commentaire'] ) ) {
			global $wpdb;
			$commentaire = $_POST['Commentaire'];
			$type        = $_POST['type'];
			$wpdb->insert( "{$wpdb->prefix}comments", array( 'comment_content' => $commentaire, 'comment_approved' => $type  ) );

		}
	}
		/**
		 * Add function SELECT users.
		 *
		 * @since 2.0.0
		 * @version 2.0.0
		 */
	public function select_users() {
			// $uilisateur_co = $wpdb->get_row( "SELECT user_login FROM {$wpdb->prefix}users" );

			ob_start();
			\eoxia\View_Util::exec( 'starter', 'handle_call', 'modal-users' );
			// echo esc_html( $uilisateur_co );
			$modal_view = ob_get_clean();


			wp_send_json_success( array(
				'view'         => $modal_view,

			) );


	}

}




new Handle_call_Action();
