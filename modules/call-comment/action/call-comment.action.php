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
		add_action( 'wp_ajax_send_form', array( $this, 'insert_comment' ) );
	}
	/**
	 * Fonction insert commentaire.
	 */
	public function insert_comment() {
		check_ajax_referer( 'send_form' );
		$pcomment = substr( $_POST['commentaire'], 0, 155 );
		$pstatus  = (int) $_POST['le_status'];
		if ( '' === $_POST['commentaire'] ) {
			exit;
		} else {
			$args_com = array(
				'post_id' => $pstatus,
				'content' => $pcomment,
			);
					Call_Comment_Class::g()->create( $args_com );
					wp_send_json_success();
		}
	}
}

new Call_Comment_Action();
