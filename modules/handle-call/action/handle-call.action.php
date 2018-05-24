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
 * Class Handle Call Action
 */
class Handle_Call_Action {
	/**
	 * Constructeur
	 *
	 * @since 2.0.0
	 * @version 0.0.0
	 */
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'button_toolbar' ) );
		add_action( 'admin_menu', array( $this, 'add_list_page' ), 20 );
		add_action( 'init', array( $this, 'load_traduc' ) );
		add_action( 'wp_ajax_ajax_launch', array( $this, 'ajax_load' ) );
		add_action( 'wp_ajax_search_admins', array( $this, 'ajax_search_cust' ) );
		add_action( 'wp_ajax_cree_cust', array( $this, 'insert_comment' ) );
	}
	/**
	 * Fonction pour ajouter une page menu list.
	 */
	public function add_list_page() {
		add_menu_page( __( 'Call List', 'call-manager' ), 'Call_List', 'manage_options', 'call-manager', array( $this, 'send_list_view' ) );
	}
	/**
	 * Fonction pour charger la vu de list menu.
	 */
	public function send_list_view() {
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'menu-list',array(
			'list_view_success' => ob_get_clean(),
		) );
	}
	/**
	 * Fonction pour charger la traduction fr.
	 */
	public function load_traduc() {
		load_plugin_textdomain( 'call-manager', false, PLUGIN_CALL_MANAGER_DIR . '/core/asset/languages/' );
	}
	/**
	 * Fonction qui ajoute un boutton dans la toolbar de WordPress !
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
		$args = array(
			'id'    => 'wpbeginner',
			'title' => ob_get_clean(),
		);
		$wp_admin_bar->add_node( $args );
	}
	/**
	 * Fonction qui charge les vues du formulaire  .
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
		$clean_modal = ob_get_clean();
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-button' );
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-error' );
		$clean_modal_btn = ob_get_clean();

		$response = array(
			'view'         => $clean_modal,
			'buttons_view' => $clean_modal_btn,
		);
		if ( isset($_POST['reload'] ) && $_POST['reload'] === 'ok') {
			$response = array(
				'namespace'        => 'callManager',
				'module'           => 'handleCall',
				'callback_success' => 'backModal',
				'view'             => $clean_modal,
				'buttons_view'     => $clean_modal_btn,
			);
		}
		wp_send_json_success( $response );
	}
	/**
	 * Fonction insert commentaire.
	 * elle permet d'envoyer les données saisie et selectioner dans la modal .
	 */
	public function insert_comment() {
		check_ajax_referer( 'send_form' );
		$id_cust       = (int) $_POST['id_cust'];
		$id_admi       = (int) $_POST['id_admin'];
		$modal_status  = (string) $_POST['modal_status'];
		$modal_comment = (string) $_POST['modal_comment'];
		$username      = sanitize_text_field( $_POST['username'] );
		$lastname      = sanitize_text_field( $_POST['lastname'] );
		$society       = sanitize_text_field( $_POST['society'] );
		$tel           = sanitize_text_field( $_POST['phone'] );
		if ( empty( $id_admi ) ) {
			wp_send_json_error();
		}
		if ( empty( $id_cust ) ) {
			$arg     = Handle_Call_Class::g()->create_customer( $username, $lastname, $society, $tel );
			$id_cust = (int) $arg;
		}

		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-success' );
		$clean_modal_success = ob_get_clean();
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-button-success' );
		$clean_modal_btn_success = ob_get_clean();

				$args_success = array(
					'post_id'          => $id_cust,
					'author_id'        => $id_admi,
					'status'           => $modal_status,
					'content'          => $modal_comment,
					'namespace'        => 'callManager',
					'module'           => 'handleCall',
					'callback_success' => 'displaySucessMess',
					'view_s'           => $clean_modal_success,
					'button_view_s'    => $clean_modal_btn_success,
				);
					Call_Comment_Class::g()->create( $args_success );
					wp_send_json_success( $args_success );
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
