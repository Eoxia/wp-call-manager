<?php
/**
 * Class  handle_call
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
 * Class Handle-Call
 */
class Handle_Call_Class extends \eoxia\Singleton_Util {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\call_manager\Handle_Call_Class'; // \your_namespace\My_Product_Model if you got a namespace.

	/**
	 * Le type du post ou du commentaire ou du term.
	 *
	 * @var string
	 */
	protected $type = 'handle-call';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = 'handle_call';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'handle-call';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';
	/**
	 * Construct .
	 * void.
	 */
	protected function construct() {
	}
	/**
	 * Get .
	 */
	public function get() {
		// Définition du Tableau des 4 types d'appels.
		$four_categorys = array(
			'traite'     => __( 'Treaty', 'call-manager' ),
			'rappelera'  => __( 'Call back', 'call-manager' ),
			'arappeler'  => __( 'to Remind', 'call-manager' ),
			'transferer' => __( 'To transfer', 'call-manager' ),
		);
		return $four_categorys;
	}
	/**
	 * Fonction pour crée un nouveau client .
	 * avec la gestion d'erreur.
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 * @param string $username _.
	 * @param string $lastname _.
	 * @param string $societe  _.
	 * @param string $tel      _.
	 * @param string $email    _.
	 */
	public function create_customer( $username, $lastname, $societe, $tel, $email ) {
		$user_id_post = 0;
		global $wpdb;
		$random_password = wp_generate_password();
		if ( ! empty( $username ) ) {
			$cree_user = wp_create_user( $username, $random_password, $email );
			if ( is_wp_error( $cree_user ) ) {
				ob_start();
				$ar = $cree_user->get_error_message();
				\eoxia\View_Util::exec( 'call-manager', 'handle-call', 'modal-error', array(
					'ar' => $ar,
				) );
				wp_send_json_success( array(
					'namespace'        => 'callManager',
					'module'           => 'handleCall',
					'callback_success' => 'displayErrorCreateCustomer',
					'view'             => ob_get_clean(),
				) );
			} else {
				$user_id      = $cree_user;
				$user_id_post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = %s AND post_author = %d ORDER BY ID DESC LIMIT 1 ", 'wpshop_customers', $user_id ) );
				update_user_meta( $user_id, 'first_name', $username );
				update_user_meta( $user_id, 'last_name', $lastname );
				update_user_meta( $user_id, 'wps_phone', $tel );
				$wpdb->update( 'wp_posts', array( 'post_title' => $societe ), array( 'ID' => $user_id_post ) );
			}
		}
		return $user_id_post;
	}
}
Handle_Call_Class::g();
