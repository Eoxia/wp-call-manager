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
		add_action( 'wp_ajax_update_status', array( $this, 'up_status' ) );
	}
	/**
	 * Fonction update status
	 */
	public function up_status() {
		// traitement status vers traite .
		if ( isset( $_POST['id_call'] ) ) { // WPCS: CSRF ok.
			$id_comment = $_POST['id_call']; // WPCS: CSRF ok.
			update_comment_meta( $id_comment, 'call_status', 'traite' );
		}
		// traitement des status traite vers trash .
		if ( isset( $_POST['id_trash'] ) ) {
			$id_comment                  = $_POST['id_trash']; // WPCS: CSRF ok.
			$comment                     = array();
			$comment['comment_ID']       = $id_comment;
			$comment['comment_approved'] = 0;
			wp_update_comment( $comment );
		}
		wp_send_json_success();
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
		$users_admin    = \eoxia\User_Class::g()->get( array(
			'role' => 'administrator',
		) );
		$four_categorys = Handle_Call_Class::g()->get();
				// traitement pour les 4 status !
		if ( isset( $_POST['status'] ) ) { // WPCS: CSRF ok.
			$ps     = $_POST['status']; // WPCS: CSRF ok.
			$status = $ps;
		} else {
			$status = '';
		}
		// traitement date !
		if ( isset( $_POST['date_start'] ) && isset( $_POST['date_end'] ) ) { // WPCS: CSRF ok.
				$date_start = $_POST['date_start']; // WPCS: CSRF ok.
				$date_end   = $_POST['date_end']; // WPCS: CSRF ok.
		} else {
				$date_start = '';
				$date_end   = '';
		}
		// variable pour la pagination .
		global $wpdb;
		$number   = 10;
		$paged    = isset( $_GET['paged'] ) ? $_GET['paged'] : 1; // WPCS: CSRF ok.
		$offset   = ( $paged - 1 ) * $number;
		$max_mess = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_comments WHERE comment_type = "call-comment"' );
		$nb_page  = ceil( $max_mess / $number );

		if ( '' !== $date_start || '' !== $date_end ) {
			echo '$date a une valeur !';
			$comments = Call_Comment_Class::g()->get(array(
				'order'      => 'DESC',
				'meta_key'   => 'call_status',
				'meta_value' => $status,
				'number'     => $number,
				'offset'     => $offset,
				'date_query' => array(
					array(
						'after'     => $date_start,
						'before'    => $date_end,
						'inclusive' => true,
					),
				),
			));
		} else {
			$comments = Call_Comment_Class::g()->get(array(
				'order'      => 'DESC',
				'meta_key'   => 'call_status',
				'number'     => $number,
				'offset'     => $offset,
				'meta_value' => $status,
			));
		}
		ob_start();
		\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'menu-list', array(
			'list_view_success' => ob_get_clean(),
			'users'             => $users_admin,
			'four_categorys'    => $four_categorys,
			'comments'          => $comments,
			'number'            => $number,
			'offset'            => $offset,
			'nb_page'           => $nb_page,
			'paged'             => $paged,
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
		$response        = array(
			'view'         => $clean_modal,
			'buttons_view' => $clean_modal_btn,
		);
		if ( isset( $_POST['reload'] ) && 'ok' === $_POST['reload'] ) { // WPCS: CSRF ok.
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
		$clean_modal_success  = ob_get_clean();
				$args_success = array(
					'view_s'           => $clean_modal_success,
					'post_id'          => $id_cust,
					'author_id'        => $id_admi,
					'call_status'      => $modal_status,
					'content'          => $modal_comment,
					'namespace'        => 'callManager',
					'module'           => 'handleCall',
					'callback_success' => 'displaySucessMess',
				);
				Call_Comment_Class::g()->create( $args_success );
					// Crée nouvelle tache START.
				$call_term = get_term_by( 'slug', 'call-manager', \task_manager\Tag_Class::g()->get_type() );

				global $wpdb;
				$post_id = $wpdb->get_var($wpdb->prepare('SELECT ID
				FROM wp_posts AS T
				INNER JOIN wp_term_relationships
				AS TR
				ON (T.ID = TR.object_id)
				WHERE T.post_type = %s
				AND T.post_parent = %d
				AND TR.term_taxonomy_id = %d
				LIMIT 1',
				'wpeo-task', $id_cust, $call_term->term_taxonomy_id ) );

		if ( empty( $post_id ) ) {
						$modal_task = \task_manager\Task_Class::g()->create( array(
							'parent_id' => $id_cust,
							'title'     => 'appel telephonique',
							'taxonomy'  => array(
								\task_manager\Tag_Class::g()->get_type() => array(
									$call_term->term_taxonomy_id,
								),
							),
						));
					$post_id        = $modal_task->data['id'];
		}
		$complete = false;
		if ( 'traite' === $modal_status ) {
			$complete = true;
		}
		$call_pts = \task_manager\Point_Class::g()->edit_point( 0, (int) $post_id, $modal_comment, $complete );
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
		if ( isset( $users ) ) {
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
		}
		// Si aucun client n'est trouvé affichage du bouton qui permet d'afficher le formulaire .
		if ( empty( $users ) ) {
			?>
		<li class="autocomplete-result" style="z-index:999;">
			<img class="autocomplete-result-image" src="https://pbs.twimg.com/profile_images/378800000483044729/a9887ba5faac56724e7988ce95c5bab0_normal.png">
			<div class="autocomplete-result-container">
				<span class="autocomplete-result-title"><?php echo esc_html_e( 'Display Name', 'call-manager' ); ?></span>
				<span class="autocomplete-result-subtitle"><?php echo esc_html_e( 'Adress Mail', 'call-manager' ); ?></span>
				<span class="wpeo-button button-main ajou_client"><?php echo esc_html_e( 'New customer', 'call-manager' ); ?></span>
			</div>
		</li>
			<?php
		}
		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}
}
new Handle_call_Action();
