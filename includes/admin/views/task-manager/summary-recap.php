<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du recap dans chronologie de task-maanger.
 * [ENG] This Php file contain a div for the recap's pop-up from Chronology in task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="cm-summary-recap" title="Voici la liste personnes qui vous ont contacté">
	<p>
		<table style="text-align: center;">
			<tr>
				<td> <strong><?php esc_html_e( "Date de réception de l'appel", 'call-manager' ) ?>  </strong> | </td>
				<td> <strong><?php esc_html_e( 'Nom du Contact', 'call-manager' ) ?> </strong> | </td>
				<td> <strong><?php esc_html_e( 'Nom de la Société', 'call-manager' ) ?> </strong> | </td>
				<td> <strong><?php esc_html_e( 'Numéro de Téléphone', 'call-manager' ) ?> </strong> | </td>
				<td> <strong><?php esc_html_e( 'E-mail', 'call-manager' ) ?> </strong> | </td>
			</tr>
			<?php
			$comment = array(
				'meta_key' => '_eocm_receiver_id',
				'meta_value' => get_current_user_id(),
				'status' => array( 'treated', 'recall', 'transfered' ),
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
				$url = admin_url( 'admin-ajax.php?action=treated&comment_id=' . $id )
				?>
				<tr>
					<td> <?php echo esc_html( $date_comment ); ?> </td>
					<td> <?php echo esc_html( $name_caller ); ?> </td>
					<td> <?php echo esc_html( $society_caller ); ?> </td>
					<td> <?php echo esc_html( $phone_caller ); ?> </td>
					<td> <?php echo esc_html( $mail_caller ); ?> </td>
				</tr>
				<?php
			}
			?>
		</table>
	</p>
</div>
