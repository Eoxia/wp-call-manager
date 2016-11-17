<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Call.
 * [ENG] This Php file contain a div for button Call's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="dialog" title="Renseignement">
	<p>
		<form id="form-dialog" method="post" action="<?php echo esc_html( admin_url( 'admin-ajax.php' ) ); ?>">
			<?php
			wp_nonce_field( 'form_dialog_check', '_wpnonce_dialog' );
			$admin_user = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
			?>
			<?php esc_html_e( 'Pour qui ?', 'call-manager.php' ) ?> <br />
			<select name = "to_call">
				<?php
				foreach ( $admin_user as $user ) {
					$id = $user->ID;
					$name = ucfirst( $user->display_name );
					?> <option value="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $name ); ?></option> <?php
				}
				?>
			</select> <br />
			<input type="hidden" name="action" value="form_call">
			<?php esc_html_e( 'Choisissez votre option :', 'call-manager.php' ) ?> <br />
			<input type="radio" name="button_call" value="treated" checked="checked"> <?php esc_html_e( 'Traité', 'call-manager.php' ); ?> <br />
			<input type="radio" name="button_call" value="transfered"> <?php esc_html_e( 'Transféré', 'call-manager.php' ); ?> <br />
			<input type="radio" name="button_call" value="recall"> <?php esc_html_e( 'A rappeler', 'call-manager.php' ); ?> <br />
			<?php esc_html_e( 'Informations contact :', 'call-manager.php' ) ?> <br />
			<input type="text" name="name_contact_call" placeholder="<?php esc_attr_e( 'Nom du contact', 'call-manager.php' ) ?>"> <br />
			<input type="text" name="society_contact_call" placeholder="<?php esc_attr_e( 'Société du contact', 'call-manager.php' ) ?>"> <br />
			<input type="text" name="number_contact_call" placeholder="<?php esc_attr_e( 'Numéro du contact', 'call-manager.php' ) ?>"> <br />
			<input type="email" name="email_contact_call" placeholder="<?php esc_attr_e( 'E-mail du contact', 'call-manager.php' ) ?>"> <br />
			<textarea rows="3" cols="15" form="form_dialog" name="comment_call" placeholder="<?php esc_attr_e( 'Commentaire', 'call-manager.php' ) ?>"></textarea> <br />
		</form>
	</p>
</div>
