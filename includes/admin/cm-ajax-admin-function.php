<?php
/**
 * [FR]  Page ajoutant l'AJAX' des boutons Call & Blame.
 * [ENG] This Php file contain AJAX for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

add_action( 'wp_ajax_count_tel', 'count_tel_callback' );
add_action( 'wp_ajax_count_tel_moins', 'count_tel_moins_callback' );
add_action( 'wp_ajax_count', 'count_callback' );


/**
 * [FR] 	Action du bouton Call.
 * [ENG]  Button Call's action.
 *
 * @method count_tel_callback Action du bouton.
 */
function count_tel_callback() {
	$time_db = current_time( 'Ym' );
	$day = intval( current_time( 'd' ) );
	$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
	$select[ $day ]['call']++;
	update_user_meta( get_current_user_id(), 'imputation_' . $time_db, $select );
	wp_die( esc_html( $select[ $day ]['call'] ) );
}

/**
 * [FR] 	Action inverse du bouton Call.
 * [ENG]  Button wich decrement the Call's total.
 *
 * @method count_tel_callback.
 */
function count_tel_moins_callback() {
	$time_db = current_time( 'Ym' );
	$day = intval( current_time( 'd' ) );
	$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
	$select[ $day ]['call']--;
	update_user_meta( get_current_user_id(), 'imputation_' . $time_db, $select );
	wp_die( esc_html( $select[ $day ]['call'] ) );
}

/**
 * [FR]  Action du bouton Blame.
 * [ENG] Button Blame's action.
 *
 * @method count_callback.
 */
function count_callback() {
	$time_db = current_time( 'Ym' );
	$day = intval( current_time( 'd' ) );
	$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
	$select[ $day ]['blame'][ $_GET['user_id'] ]++;
	update_user_meta( get_current_user_id(), 'imputation_' . $time_db, $select );
	$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
	$total_blame = 0;
	foreach ( $id_select as $user ) {
		$x = $user->ID;
		$total_blame = $total_blame + $select[ $day ]['blame'][ $x ];
	}
	if ( ( ! isset( $select[ $day ]['blame']['0'] ) ) or ( ! isset( $select[ $day ]['blame']['999999'] ) ) ) {
		$select[ $day ]['blame']['0'] = 0;
		$select[ $day ]['blame']['999999'] = 0;
	}
	$total_blame = $total_blame + $select[ $day ]['blame']['0'];
	$total_blame = $total_blame + $select[ $day ]['blame']['999999'];
	$data = array(
		'count_current_user' => $select[ $day ]['blame'][ $_GET['user_id'] ],
		'total' => $total_blame,
		'id_user' => $_GET['user_id'],
	);
	wp_send_json_success( $data );
}


add_action( 'wp_ajax_form_call', 'form_call_callback' );
add_action( 'wp_ajax_treated', 'treated_callback' );

/**
 * [FR]  Traitement du formulaire du bouton Call en POST et de la recherche en GET.
 * [ENG] This function save the data from the dialog form of Call's button via POST and search from GET.
 *
 * @method form_call_callback.
 */
function form_call_callback() {
	if ( ! empty( $_POST['_wpnonce_dialog'] ) && check_admin_referer( 'form_dialog_check', '_wpnonce_dialog' ) ) {
		if ( '' !== $_POST['button_call'] ) {
			$button_call = $_POST['button_call'];
		} else {
			$button_call = 'empty';
		}
		if ( '' !== $_POST['number_contact_call'] ) {
			$number_contact_call = $_POST['number_contact_call'];
		} else {
			$number_contact_call = 'empty';
		}
		if ( '' !== $_POST['email_contact_call'] ) {
			$email_contact_call = $_POST['email_contact_call'];
		} else {
			$email_contact_call = 'empty';
		}
		if ( '' !== $_POST['comment_content_call'] ) {
			$comment_content_call = $_POST['comment_content_call'];
		} else {
			$comment_content_call = "Réception d'un appel";
		}
		if ( '' !== $_POST['name_contact_call'] ) {
			$name_contact_call = $_POST['name_contact_call'];
		} else {
			$name_contact_call = 'empty';
		}
		if ( '' !== $_POST['society_contact_call'] ) {
			$society_contact_call = $_POST['society_contact_call'];
		} else {
			$society_contact_call = 'empty';
		}
		if ( '' !== $_POST['to_call'] ) {
			$to_call = $_POST['to_call'];
		} else {
			$to_call = 'empty';
		}
		$comment = array(
			'comment_approved' => $button_call,
			'comment_content' => $comment_content_call,
			'user_id' => get_current_user_id(),
		);
		$id_comment = wp_insert_comment( $comment );
		add_comment_meta( $id_comment, '_eocm_caller_phone', $number_contact_call );
		add_comment_meta( $id_comment, '_eocm_caller_email', $email_contact_call );
		add_comment_meta( $id_comment, '_eocm_caller_society', $society_contact_call );
		add_comment_meta( $id_comment, '_eocm_caller_name', $name_contact_call );
		add_comment_meta( $id_comment, '_eocm_receiver_id', $to_call );
	} elseif ( ! empty( $_GET['_wpnonce_dialog'] ) && check_admin_referer( 'form_dialog_check', '_wpnonce_dialog' ) ) {
		if ( ( '' !== $_GET['number_contact_call'] ) or ( '' !== $_GET['email_contact_call'] ) or ( '' !== $_GET['name_contact_call'] ) or ( '' !== $_GET['society_contact_call'] ) ) {
			$comment = array(
				'status' => array( 'treated', 'recall', 'transfered' ),
				'order' => 'ASC',
			);
			if ( '' !== $_GET['number_contact_call'] ) {
				$number_caller = $_GET['number_contact_call'];
				$comment['meta_key'] = '_eocm_caller_phone';
				$comment['meta_value'] = $number_caller;
			}
			if ( '' !== $_GET['email_contact_call'] ) {
				$mail_caller = $_GET['email_contact_call'];
				$comment['meta_key'] = '_eocm_caller_email';
				$comment['meta_value'] = $mail_caller;
			}
			if ( '' !== $_GET['name_contact_call'] ) {
				$name_caller = $_GET['name_contact_call'];
				$comment['meta_key'] = '_eocm_caller_name';
				$comment['meta_value'] = $name_caller;
			}
			if ( '' !== $_GET['society_contact_call'] ) {
				$society_caller = $_GET['society_contact_call'];
				$comment['meta_key'] = '_eocm_caller_society';
				$comment['meta_value'] = $society_caller;
			}
			$data_comment = get_comments( $comment );
			foreach ( $data_comment as $data ) {
				$id = $data->comment_ID;
				$name_caller = get_comment_meta( $id, '_eocm_caller_name', true );
				$society_caller = get_comment_meta( $id, '_eocm_caller_society', true );
				$number_caller = get_comment_meta( $id, '_eocm_caller_phone', true );
				$mail_caller = get_comment_meta( $id, '_eocm_caller_email', true );
				$comment_content_receive = get_comment( $id, ARRAY_A );
				$comment_content = $comment_content_receive['comment_content'];
			}
			$data = array(
				'name' => $name_caller,
				'society' => $society_caller,
				'mail' => $mail_caller,
				'number' => $number_caller,
				'commentcontent' => $comment_content,
			);
			wp_send_json_success( $data );
		} else {
			$data = array(
				'name' => '',
				'society' => '',
				'mail' => '',
				'number' => '',
				'commentcontent' => 'Remplissez un champ pour la recherche !',
			);
			wp_send_json_success( $data );
		}
		wp_die();
	}
	wp_die();
}

/**
 * Fonction pour modifier les "Recall" en Traité.
 *
 * @method treated_callback
 */
function treated_callback() {
	$id = $_GET['comment_id'];
	$treated['comment_approved'] = 'treated';
	$treated['comment_ID'] = $id;
	wp_update_comment( $treated );
	wp_die();
}
