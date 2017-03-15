<?php
/**
 * BLA.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/**
 * BLA.
 */
class Cm_Mail_Sender {

	/**
	 * BLA.
	 *
	 * @method __construct
	 */
	public function __construct() {}

	/**
	 * Envoi un email au destinataire avec les informations du contact.
	 *
	 * @param  string $email_receiver L'adresse email du receveur.
	 * @param  array  $contact        Les données du contact.
	 * @param  array  $comment        Les données du commentaires.
	 *
	 * @return void
	 *
	 * @since 1.12.0.1
	 * @version 1.12.0.1
	 */
	public function send_mail( $user_receiver_id, $contact, $comment ) {
		$comment_user_data = get_userdata( $comment['user_id'] );
		$user_receiver_data = get_userdata( $user_receiver_id );
		$contents = '<p>Vous devez <b>rappeler</b> le client suivant:</p><ul>';
		$contents .= '<li>Nom du contact: <b>' . $contact['name'] . '</b></li>';
		$contents .= '<li>Société du contact: <b>' . $contact['society'] . '</b></li>';
		$contents .= '<li>Numéro du contact: <b>' . $contact['phone'] . '</b></li>';
		$contents .= '<li>E-mail du contact: <b>' . $contact['email'] . '</b></li>';
		$contents .= '</ul>';

		$contents .= '<p>Commentaire de la notification par ' . $comment_user_data->display_name . '</p>';
		$contents .= '<p>' . $comment['comment_content'] . '</p>';
		$sujet = '[Call Manager] Vous avez un client a rappeler:';
		$header = array( 'Content-Type: text/html; charset=UTF-8' );
		wp_mail( $user_receiver_data->user_email, $sujet, $contents, $header );
	}
}

new Cm_Mail_Sender();
