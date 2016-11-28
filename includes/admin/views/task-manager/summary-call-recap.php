<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du call-recap dans chronologie de task-maanger.
 * [ENG] This Php file contain a div for the call-recap's pop-up from Chronology in task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="cm-summary-call-recap-<?php echo esc_attr( $user_id . $year . $month . $day ); ?>" class="hidden pop-up"
<?php if ( null !== $day ) {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes qui vous ont contacté ce jour-là' , 'call-manager' ) ?>" <?php
} else {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes qui vous ont contacté ce mois-ci' , 'call-manager' ) ?>" <?php
}
?>
>
	<p>
		<table style="text-align: center; table-layout: fixed;">
			<tr>
				<th style="white-space: nowrap;"> <strong><?php esc_html_e( "Date de réception de l'appel", 'call-manager' ) ?>  </strong> | </th>
				<th style="white-space: nowrap;"> <strong><?php esc_html_e( 'Nom du Contact', 'call-manager' ) ?> </strong> | </th>
				<th style="white-space: nowrap;"> <strong><?php esc_html_e( 'Nom de la Société', 'call-manager' ) ?> </strong> | </th>
				<th style="white-space: nowrap;"> <strong><?php esc_html_e( 'Numéro de Téléphone', 'call-manager' ) ?> </strong> | </th>
				<th style="white-space: nowrap;"> <strong><?php esc_html_e( 'E-mail', 'call-manager' ) ?> </strong> </th>
				<th style="white-space: nowrap;"> | <strong><?php esc_html_e( 'Commentaire', 'call-manager' ) ?> </strong> </th>
			</tr>
			<?php
			$comment = array(
				'meta_key' => '_eocm_receiver_id',
				'meta_value' => get_current_user_id(),
				'status' => array( 'treated', 'recall', 'transfered', 'will-recall' ),
				'order' => 'ASC',
				'date_query' => array( 'year' => $year, 'month' => $month, 'day' => $day ),
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
				?>
				<tr>
					<td> <?php echo esc_html( $date_comment ); ?> </td>
					<td> <?php echo esc_html( $name_caller ); ?> </td>
					<td> <?php echo esc_html( $society_caller ); ?> </td>
					<td> <?php echo esc_html( $phone_caller ); ?> </td>
					<td> <?php echo esc_html( $mail_caller ); ?> </td>
					<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $comment_content_receive['comment_content'] ); ?> </div> </td>
				</tr>
				<?php
			}
			?>
		</table>
	</p>
</div>
