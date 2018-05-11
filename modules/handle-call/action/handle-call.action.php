<?php
/**
 * Module Handele-Call.
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
 * Action of "Handle_call" module.
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
		add_action( 'wp_ajax_affich_users', array( $this, 'select_users' ) );
			add_action( 'wp_ajax_ajax_hook2', array( $this, 'cree_posts' ) );
			add_action( 'wp_ajax_ajax_launch', array( $this, 'ajax_load' ) );
	}
	/**
	 * Fonction qui ajoute un boutton dans la toolbar de wp !
	 *
	 * @method button_toolbar   .
	 *
	 * @param string $wp_admin_bar ].
	 *
	 * @return void                       [description].
	 */
	public function button_toolbar( $wp_admin_bar ) {
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'button' );
		$args = array(
			'id'    => 'wpbeginner',
			'title' => ob_get_clean(),
		);
		$wp_admin_bar->add_node( $args );
	}
		/**
		 * Add function envoyer view users.
		 *
		 * @since 2.0.0
		 * @version 2.0.0
		 */
	public function select_users() {
			ob_start();
			\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-users' );
			$modal_view = ob_get_clean();
			wp_send_json_success( array(
				'view' => $modal_view,
			) );
	}
	/**
	 * Add function qui cree 4 category.
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */

	/**
	 * Add function qui cree 4 Posts et les lie au category.
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */
	public function cree_posts() {
		$cats = My_Category_Class::g()->get();
		foreach ( $cats as $cat ) {
			$args = array( 'title' => $cat->data['name'] );
			$post = Post_Model_Class::g()->create( $args );
			$post->data['taxonomy'][ My_Category_Class::g()->get_type() ][] = $cat->data['id'];
			Post_Model_Class::g()->update( $post->data );
		}
				wp_send_json_success();
	}
	/**
	 * Add function qui charge les vues .
	 * Si l'arret est vide je recup tous .
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */
	public function ajax_load() {
		$users          = \eoxia\User_Class::g()->get( array(
			'role' => 'administrator',
		) );
		$four_categorys = Handle_Call_Class::g()->get();
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal', array(
			'users'          => $users,
			'four_categorys' => $four_categorys,
		) );
		$modal_view = ob_get_clean();
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-button' );
		$modal_button_view = ob_get_clean();

		wp_send_json_success( array(
			'view'         => $modal_view,
			'buttons_view' => $modal_button_view,
		) );
	}
}
new Handle_call_Action();
