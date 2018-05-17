<?php
/**
 * Module Handele-Call.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018
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
		add_action( 'wp_ajax_cree_cust', array( $this, 'insert_comment' ) );
		add_action( 'wp_ajax_search_admins', array( $this, 'ajax_search_cust' ) );
		add_action( 'admin_bar_menu', array( $this, 'button_toolbar' ) );
		add_action( 'wp_ajax_affich_users', array( $this, 'select_users' ) );
		add_action( 'wp_ajax_ajax_launch', array( $this, 'ajax_load' ) );
		add_action( 'wp_ajax_ajax_launch2', array( $this, 'list_view' ) );
	}
	/**
	 * Fonction qui ajoute un boutton dans la toolbar de wp !
	 *
	 * @method button_toolbar   .
	 *
	 * @param string $wp_admin_bar .
	 *
	 * @return void.
	 */
	public function button_toolbar( $wp_admin_bar ) {
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'button' );
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'buttonlist' );
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
	 * Add function qui charge les vues de la modal List .
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */
	public function list_view() {
		$users          = \eoxia\User_Class::g()->get( array(
			'role' => 'administrator',
		) );
		$four_categorys = Handle_Call_Class::g()->get();
		$info_comm      = Call_Comment_Class::g()->get();
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-list', array(
			'users'          => $users,
			'four_categorys' => $four_categorys,
			'info_comm'      => $info_comm,
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
	/**
	 * Add function qui charge les vues du formulaire .
	 * Si l'arret est vide je recup tous .
	 *
	 * @since 1.0.0
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
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-error' );
		$modal_button_view = ob_get_clean();

		wp_send_json_success( array(
			'view'         => $modal_view,
			'buttons_view' => $modal_button_view,
		) );
	}
	/**
	 * Fonction insert commentaire.
	 * elle permet d'envoyer les données saisie et selectioner dans la modal .
	 */
	public function insert_comment() {
		check_ajax_referer( 'send_form' );
		$id_cust      = (int) $_POST['id_cust'];
		$id_admi      = (int) $_POST['id_admin'];
		$post_status  = (string) $_POST['le_status'];
		$post_content = (string) $_POST['commentaire'];
		$username     = sanitize_text_field( $_POST['username'] );
		$lastname     = sanitize_text_field( $_POST['lastname'] );
		$societe      = sanitize_text_field( $_POST['societe'] );
		$tel          = sanitize_text_field( $_POST['phone'] );
		if ( empty( $id_admi ) ) {
			wp_send_json_error();
		}
		if ( empty( $id_cust ) ) {
			$arg     = Handle_Call_Class::g()->create_customer( $username, $lastname, $societe, $tel );
			$id_cust = (int) $arg;
		}
				$args_com = array(
					'post_id'   => $id_cust,
					'author_id' => $id_admi,
					'status'    => $post_status,
					'content'   => $post_content,
				);
					Call_Comment_Class::g()->create( $args_com );
					wp_send_json_success( $args_com );

	}
	/**
	 * Fonction auto complete de la barre de recherche rapide.
	 */
	public function ajax_search_cust() {
		$ss = sanitize_text_field( $_POST['s'] );
		$s  = ! empty( $ss ) ? $ss : '';
		if ( empty( $s ) ) {
			wp_send_json_error();
		}
		$call_consumer = new \wps_customer_mdl();
		$u             = $call_consumer->get_customer_list( 10, 0, array(
			's' => $s,
		) );
		$users         = $u->posts;
		ob_start();
		foreach ( $users as $user ) :
			?>
			<li data-id="<?php echo esc_attr( $user->ID ); ?>" data-result="<?php echo esc_html( $user->post_title ); ?>" class="autocomplete-result">
				<?php echo get_avatar( $user->ID, 32, '', '', array( 'class' => 'autocomplete-result-image autocomplete-image-rounded' ) ); ?>
				<div class="autocomplete-result-container">
					<span class="autocomplete-result-title"><?php echo esc_html( $user->post_title ); ?></span>
				</div>
			</li>
			<?php
		endforeach;
		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}
}
new Handle_call_Action();
