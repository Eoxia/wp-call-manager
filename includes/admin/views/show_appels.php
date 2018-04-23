<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Recall.
 * [ENG] This Php file contain a div for button Recall's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>

<div class="wrap">

	<br>
		<div class="wrap"><br>
		<table class="recap-tb" border="2" cellspacing="0" cellpadding="1" style="text-align: center; table-layout: fixed; margin: 0 auto;" >
		<div class ="container" align="center">
			<form class="bt1" method="post">
					<?php	wp_nonce_field( 'bt-nombre_check', '_wpnonce_bt-nombre' );?>
					<input type="submit" name="bt-nombre" value="Trier par nombre">
			</form>

			<form class="bt2" method="post">
					<?php wp_nonce_field( 'bt-date_check', '_wpnonce_bt-date' );?>
					<input type="submit" name="bt-date" value="Trier par date">
			</form>
			<form class="bt3" name="ckf" method="post">
					<?php wp_nonce_field( 'ck-groupe_check', '_wpnonce_ck-groupe' );?>
					<input class="ck" type="checkbox" name="ck-groupe" checked onchange="this.form.submit()"><?php echo esc_html( 'Regrouper', 'call-manager' ); ?>
			</form>
		</div>
<?php
	if ( 'will_recall' === $comment['status'] )
	{
?> <tr style="background-color: #BBBBBB;"><th> <?php echo esc_html( 'Des personnes veulent vous rappeler', 'call-manager' ); ?></th><th></th><th></th><th></th><th></th><th></th><th></th> </tr>
<?php
	} elseif ( 'recall' === $comment['status'] )
	{?> <tr style="background-color: #BBBBBB;"><th> <?php echo esc_html( 'Vous avez des personnes a rappeler', 'call-manager' ); ?></th><th></th><th></th><th></th><th></th><th></th><th></th> </tr>
<?php
}
 elseif (['will_recall', 'recall', 'transfered', 'treated'] === $comment['status'])
{?> <tr style="background-color: #BBBBBB;"><th> <?php echo esc_html( 'Toutes les appels', 'call-manager' ); ?></th><th></th><th></th><th></th><th></th><th></th><th></th> </tr>
<?php
}?>

<tr style="background-color: #BBBBBB;">

	<th style="white-space: nowrap;"> <?php esc_html_e( "Date de réception de l'appel", 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Nom du Contact', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Nom de la Société', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Numéro de Téléphone', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'E-mail', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"> <?php esc_html_e( 'Commentaire', 'call-manager' ) ?> </th>
	<th style="white-space: nowrap;"><?php esc_html_e( 'Etat', 'call-manager' ); ?></th>
</tr>
<?php
foreach ( $data_comment as $data ) {
	?>
	<tr>
		<td> <?php echo esc_html( get_comment_date( '', $data->comment_ID ) ); ?> </td>
		<td> <?php echo esc_html( get_comment_meta( $data->comment_ID, '_eocm_caller_name', true ) ); ?> </td>
		<td> <?php echo esc_html( get_comment_meta( $data->comment_ID, '_eocm_caller_society', true ) ); ?> </td>
		<td> <?php echo esc_html( get_comment_meta( $data->comment_ID, '_eocm_caller_phone', true ) ); ?> </td>
		<td> <?php echo esc_html( get_comment_meta( $data->comment_ID, '_eocm_caller_email', true ) ); ?> </td>
		<td> <div style="width: 200px; word-wrap: break-word;"> <?php echo esc_html( $data->comment_content ); ?> </div> </td>
		<td>
			<?php
			if ( in_array( $data->comment_approved, array( 'recall', 'will_recall' ), true ) ) :
			?>
			<a class="eopcm-comment-status" href="<?php echo esc_attr( admin_url( 'admin-ajax.php?action=treated&comment_id=' . $data->comment_ID ) ); ?>"><?php echo esc_html_e( 'Traité', 'call-manager' ); ?> </a>

			<?php
			elseif( in_array( $data->comment_approved, array( 'treated' ), true ) ):
			?>
			<a><span class="dashicons dashicons-yes"></span> </a>
		<?php else:
			?>
			<a><span class="dashicons dashicons-redo"></span> </a>
			<?php
			endif;
			?>
		</td>
	</tr>
	<?php
}
?>

</table>
</form>
	</div>
</div>
<?php
