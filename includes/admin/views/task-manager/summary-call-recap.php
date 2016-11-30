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
	<table border="1" cellspacing="0" cellpadding="5" style="text-align: center; table-layout: fixed; margin: 0 auto;">
		<tr bgcolor="bbbbbb"> <th colspan="6"> Liste des appels reçus que vous devez rappeler </td> </th>
		<?php
		include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-title-row.php' );
		foreach ( $array_recall_comment as $key => $value ) {
			?>
			<tr>
				<td> <?php echo esc_html( $value['date_comment'] ); ?> </td>
				<td> <?php echo esc_html( $value['name_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['society_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['phone_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['mail_caller'] ); ?> </td>
				<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $value['comment_content_receive'] ); ?> </div> </td>
			</tr>
			<?php
		}
		?>
		<tr bgcolor="bbbbbb"> <th colspan="6"> Liste des appels reçus qui rappelleront </td> </th>
		<?php
		include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-title-row.php' );
		foreach ( $array_will_recall_comment as $key => $value ) {
			?>
			<tr>
				<td> <?php echo esc_html( $value['date_comment'] ); ?> </td>
				<td> <?php echo esc_html( $value['name_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['society_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['phone_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['mail_caller'] ); ?> </td>
				<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $value['comment_content_receive'] ); ?> </div> </td>
			</tr>
			<?php
		}
		?>
		<tr bgcolor="bbbbbb"> <th colspan="6"> Liste des appels traités </td> </th>
		<?php
		include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-title-row.php' );
		foreach ( $array_treated_comment as $key => $value ) {
			?>
			<tr>
				<td> <?php echo esc_html( $value['date_comment'] ); ?> </td>
				<td> <?php echo esc_html( $value['name_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['society_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['phone_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['mail_caller'] ); ?> </td>
				<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $value['comment_content_receive'] ); ?> </div> </td>
			</tr>
			<?php
		}
		?>
		<tr bgcolor="bbbbbb"> <th colspan="6"> Liste des appels transférés </td> </th>
		<?php
		include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-title-row.php' );
		foreach ( $array_transfered_comment as $key => $value ) {
			?>
			<tr>
				<td> <?php echo esc_html( $value['date_comment'] ); ?> </td>
				<td> <?php echo esc_html( $value['name_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['society_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['phone_caller'] ); ?> </td>
				<td> <?php echo esc_html( $value['mail_caller'] ); ?> </td>
				<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $value['comment_content_receive'] ); ?> </div> </td>
			</tr>
			<?php
		}
		?>
		<pre>
			<?php echo esc_html( 'Vous avez reçu ' . $number_call . ' appels et renseigné ' . $data_self_comment_count . ', traité ' . $data_treated_comment_count . ', ' . $data_transfered_comment_count . ' vous ont été transférés, vous devez en rappeler ' . $data_recall_comment_count . ' et ' . $data_will_recall_comment_count . ' doivent vous rappeler.' ); ?>
		</pre>
	</table>
</div>
