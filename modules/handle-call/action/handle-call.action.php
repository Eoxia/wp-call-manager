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
		add_action( 'wp_ajax_ajax_launch', array( $this, 'ajax_load' ) );
		add_action( 'wp_ajax_affich_users', array( $this, 'select_users' ) );
		add_action( 'wp_ajax_ajax_hook1', array( $this, 'cree_category' ) );
			add_action( 'wp_ajax_ajax_hook2', array( $this, 'cree_posts' ) );
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
		 * Add function SELECT users.
		 *
		 * @since 2.0.0
		 * @version 2.0.0
		 */
	public function select_users() {
			ob_start();
			\eoxia\View_Util::exec( 'starter', 'handle_call', 'modal-users' );
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
	public function cree_category() {
		$traite     = array(
			'name' => 'traite',
			'slug' => 'traite',
		);
		$transferer = array(
			'name' => 'transferer',
			'slug' => 'transferer',
		);
		$a_rappeler = array(
			'name' => 'a_rappeler',
			'slug' => 'a_rappeler',
		);
		$rappelera  = array(
			'name' => 'Rappelera',
			'slug' => 'Rappelera',
		);
		My_Category_Class::g()->create( $traite );
		My_Category_Class::g()->create( $transferer );
		My_Category_Class::g()->create( $a_rappeler );
		My_Category_Class::g()->create( $rappelera );
		wp_send_json_success();
	}
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
}
new Handle_call_Action();
