<?php
/**
 * [FR]  Page répertoriant les ajouts et les actions des boutons Call & Blame.
 * [ENG] This Php file contain adds and actions for buttons Call & Blame.
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
					__( Pour qui ? ) <br />
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
					__( Choisissez votre option ) : <br />
					<input type="radio" name="button_call" value="treated" checked="checked"> __( Traité ) <br />
					<input type="radio" name="button_call" value="transfered"> __( Transféré ) <br />
					<input type="radio" name="button_call" value="recall"> __( A rappeler ) <br />
					__( Informations contact ) : <br />
					<input type="text" name="name_contact_call" placeholder="Nom du contact"> <br />
					<input type="text" name="society_contact_call" placeholder="Société du contact"> <br />
					<input type="text" name="number_contact_call" placeholder="Numéro du contact"> <br />
					<input type="email" name="email_contact_call" placeholder="E-mail du contact"> <br />
					<input type="textarea" name="comment_call" placeholder="Commentaire"> <br />
				</form>
			</p>
		</div>
	<?php
}
