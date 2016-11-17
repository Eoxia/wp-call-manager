<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Call.
 * [ENG] This Php file contain a div for button Call's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

add_action( 'admin_footer', 'dialog_call' );
/**
 * [FR]  Création de la Div pour la pop-up du plugin Call.
 * [ENG] Here we create a div for the pop-up dialog when you clic on the Call button.
 *
 * @method dialog_call.
 */
function dialog_call() {
	?>
		<div id="dialog" title="Renseignement Appel">
			<p>
				<form id="form-dialog" method="post" action="<?php echo esc_html( admin_url( 'admin-ajax.php' ) ); ?>">
					<?php
					wp_nonce_field( 'form_dialog_check', '_wpnonce_dialog' );
					$admin_user = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
					?>
					<?php esc_html_e( 'Pour qui ?' ) ?> <br />
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
					<?php esc_html_e( 'Choisissez votre option :' ) ?> <br />
					<input type="radio" name="button_call" value="treated" checked="checked"> <?php esc_html_e( 'Traité' ); ?> <br />
					<input type="radio" name="button_call" value="transfered"> <?php esc_html_e( 'Transféré' ); ?> <br />
					<input type="radio" name="button_call" value="recall"> <?php esc_html_e( 'A rappeler' ); ?> <br />
					<?php esc_html_e( 'Informations contact :' ) ?> <br />
					<input type="text" name="name_contact_call" placeholder="<?php esc_attr_e( 'Nom du contact' ) ?>"> <br />
					<input type="text" name="society_contact_call" placeholder="<?php esc_attr_e( 'Société du contact' ) ?>"> <br />
					<input type="text" name="number_contact_call" placeholder="<?php esc_attr_e( 'Numéro du contact' ) ?>"> <br />
					<input type="email" name="email_contact_call" placeholder="<?php esc_attr_e( 'E-mail du contact' ) ?>"> <br />
					<input type="textarea" name="comment_call" placeholder="<?php esc_attr_e( 'Commentaire' ) ?>"> <br />
				</form>
			</p>
		</div>
	<?php
}
