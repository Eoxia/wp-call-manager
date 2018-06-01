<?php
/**
 * Form view of "Call Manager" module.
 * vue principale qui affiche le formulaire .
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018
 * @package call_manager
 */

namespace handle_call;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
		<form id="body_modal" class="wpcm-add-call wpeo-form wpeo-wrap">

			<div class="wpcm-section-user">
				<h2><i class="fas fa-user-secret fa-fw"></i><?php echo esc_html_e( 'User concerned', 'call-manager' ); ?></h2>

				<ul class="wpcm-list-user">
					<?php
					wp_nonce_field( 'send_form' );
					if ( isset( $users ) ) {
						foreach ( $users as $user ) :
							echo "<li class='wpeo-button button-secondary id_administrator active' data-id='" . esc_html( $user->data['id'] ) . "'><img src='URL_GRAVATAR'>" . esc_html( $user->data['displayname'] ) . '   </li>';
						endforeach;
					}
					?>
					<input id="hook_jquery1" type="hidden" name="id_admin" value="">
				</ul>

			</div><!-- .wpcm-section-user -->
			<div class="wpcm-section-call wpeo-grid grid-2">
				<div class="wpcm-section-statut">
					<h2><i class="fas fa-phone fa-fw"></i><?php echo esc_html_e( 'Call Status', 'call-manager' ); ?></h2>

					<ul class="wpcm-list-statut wpeo-grid grid-2">
						<?php
						if ( isset( $users ) ) {
							foreach ( $four_categorys as $keys => $four_category ) :
								?>
								<li class="wpcm-statut">
									<div id ="btn-status" class="wpeo-button button-secondary" value ='<?php echo esc_attr( $keys ); ?>' >
										<span class="wpcm-icon"><i class="fas fa-check"></i></span>
										<span class ="wpcm-label"><?php echo esc_html( $four_category ); ?></span></div></li>
										<?php
							endforeach;
						}
						?>
						<input id="hook_jquery2" type = "hidden" name = "modal_status" value = "">
					</ul>

				</div><!-- .wpcm-section-call -->
			<!-- l'auto complete clients -->
				<div class="wpcm-section-search">
					<h2><i class="fas fa-user fa-fw"></i><?php echo esc_html_e( 'customers', 'call-manager' ); ?></h2>
					<div class="wpeo-autocomplete"  data-action="search_admins">
						<input id='id_cust' type='hidden' name="id_cust" value="">
						<label class="autocomplete-label" for="mon-autocomplete">
							<i class="autocomplete-icon-before far fa-search"></i>
							<input autocomplete="off" id="mon-autocomplete" placeholder="Recherche..." class="autocomplete-search-input" type="text">
							<span class="autocomplete-icon-after"><i class="far fa-times"></i></span>
						</label>
				<ul class="autocomplete-search-list">

				</ul>
					</div><!-- .wpeo-autocomplete -->
				</div>
			</div>
<!-- formulaire nouveau client -->
	<div id="erf" class="wpeo-grid grid-4" style="display:none;">
		<h4 class="form-label"><?php echo esc_html_e( 'Add New customer', 'call-manager' ); ?></h4>
			<div class="form-element">
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-building"></i></span>
						<input type="text"
							name="society" class="form-field" placeholder="<?php echo esc_html_e( 'Society', 'call-manager' ); ?>" />
				</label>
			</div>
		<div class="form-element">
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<input type="text" class="form-field"
				name="username" placeholder="<?php echo esc_html_e( 'First Name', 'call-manager' ); ?>" value="">
			</label>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
					<input
					name="lastname" type="text" class="form-field" placeholder="<?php echo esc_html_e( 'Last Name', 'call-manager' ); ?>" />
			</label>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-envelope"></i></span>
					<input
					name="email" type="email" class="form-field" placeholder="<?php echo esc_html_e( 'email', 'call-manager' ); ?>" />
			</label>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-phone"></i></span>
					<input
					name="phone" type="tel" class="form-field" placeholder="<?php echo esc_html_e( 'Phone', 'call-manager' ); ?>" />
			</label>
		</div>
	</div>
<!-- contact fin -->
<!-- comment start -->
		<div class="form-element">
			<span class="form-label"><?php echo esc_html_e( 'Comment', 'call-manager' ); ?></span>
				<label class="form-field-container">
				<textarea class="form-field" rows="2" cols="2" name="modal_comment" placeholder="<?php esc_html_e( 'Write a Comment !', 'call-manager' ); ?>"></textarea>
				</label>
				<i class="dashicons dashicons-clock"></i>
				<input type="text" class="point-time" name="time_info" value="15">
				<input type="hidden" name="tm_point_is_quick_point" value="true">
	</form>
