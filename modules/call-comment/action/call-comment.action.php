<?php
/**
 * Action of call-comment module.
 *
 * @author You <you@mail>
 * @since 0.1.0
 * @version 0.1.0
 * @copyright 2017+
 * @package starter
 */

namespace call_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Action of call-comment module.
 */
class Call_Comment_Action {

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_cree_cust', array( $this, 'insert_comment' ) );
		add_action( 'wp_ajax_search_admins', array( $this, 'ajax_search_admis' ) );
	}
	/**
	 * Fonction insert commentaire.
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
	public function ajax_search_admis() {
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
new Call_Comment_Action();
