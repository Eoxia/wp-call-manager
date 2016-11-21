<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Recall.
 * [ENG] This Php file contain a div for button Recall's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="dialog-recall" title="Voici les personnes que vous devez rappeler">
	<p>
		<table style="text-align: center;">
			<tr>
				<th> <strong><?php esc_html_e( "Date de réception de l'appel", 'call-manager' ) ?>  </strong> | </th>
				<th> <strong><?php esc_html_e( 'Nom du Contact', 'call-manager' ) ?> </strong> | </th>
				<th> <strong><?php esc_html_e( 'Nom de la Société', 'call-manager' ) ?> </strong> | </th>
				<th> <strong><?php esc_html_e( 'Numéro de Téléphone', 'call-manager' ) ?> </strong> | </th>
				<th> <strong><?php esc_html_e( 'E-mail', 'call-manager' ) ?> </strong> | </th>
				<th> <strong><?php esc_html_e( 'Commentaire', 'call-manager' ) ?> </strong> </th>
				<th> | <strong><?php esc_html_e( 'Traité ?', 'call-manager' ) ?> </strong> </th>
			</tr>
			<?php
			$comment = array(
				'meta_key' => '_eocm_receiver_id',
				'meta_value' => get_current_user_id(),
				'status' => 'recall',
				'order' => 'ASC',
			);
			$data_comment = get_comments( $comment );
			foreach ( $data_comment as $data ) {
				$id = $data->comment_ID;
				$date_comment = get_comment_date( '', $id );
				$name_caller = get_comment_meta( $id, '_eocm_caller_name', true );
				$society_caller = get_comment_meta( $id, '_eocm_caller_society', true );
				$phone_caller = get_comment_meta( $id, '_eocm_caller_phone', true );
				$mail_caller = get_comment_meta( $id, '_eocm_caller_email', true );
				$comment_content_receive = get_comment( $id, ARRAY_A );
				$url = admin_url( 'admin-ajax.php?action=treated&comment_id=' . $id )
				?>
				<tr>
					<td> <?php echo esc_html( $date_comment ); ?> </td>
					<td> <?php echo esc_html( $name_caller ); ?> </td>
					<td> <?php echo esc_html( $society_caller ); ?> </td>
					<td> <?php echo esc_html( $phone_caller ); ?> </td>
					<td> <?php echo esc_html( $mail_caller ); ?> </td>
					<td> <?php echo esc_html( $comment_content_receive['comment_content'] ); ?> </td>
					<td> <a href="<?php echo esc_attr( $url ); ?>"><?php esc_html_e( 'Traité', 'call-manager' ) ?> </a>	</td>
				</tr>
				<?php
			}
			?>
		</table>
	</p>
</div>
