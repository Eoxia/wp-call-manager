<?php
/**
 * Form view of "Call Manager" module.
 *
 * @author You <you@mail>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018+
 * @package call_manager
 */

namespace handle_call;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="wpeo">
	<form  class="wpeo-form">
<h3 class="form-label"><strong><?php echo esc_html_e( 'Administrator', 'Call-Manager' ); ?></strong></h3>
<?php
wp_nonce_field( 'send_form' );
if ( isset( $users ) ) {
	foreach ( $users as $user ) :
		echo "<span class='wpeo-button button-main yop active' data-id='" . esc_html( $user->data['id'] ) . "'>" . esc_html( $user->data['displayname'] ) . '   </span>';
	endforeach;
}
?>
<input id='id_cust' type='hidden' name="id_cust" value="">
<input id="yup" type="hidden" class="#" name="id_admin" value="" >
</br>
<div class="wpeo-grid">
<h3 class="form-label"><strong><?php echo esc_html_e( 'Call Status', 'Call-Manager' ); ?></strong></h3>
<hr>
<?php
if ( isset( $users ) ) {
	foreach ( $four_categorys as $keys => $four_category ) :
		echo '<div class="form-field">';
		echo '<input type="radio" class="form-field" name="le_status" value=' . esc_attr( $keys ) . '>';
		echo "<label for='radio1'>" . $four_category . '</label></div>';
		//faire la traduction de $four_category. +XSS
	endforeach;
}
?>
		<div class="wpeo-autocomplete" data-action="search_admins">
			<h3 class="form-label"><strong><?php echo esc_html_e( 'customers', 'Call-Manager' ); ?></strong></h3>
			<label class="autocomplete-label" for="autocomplete-search-admins">
				<i class="autocomplete-icon-before far fa-search"></i>
				<input id="mon-autocomplete" placeholder="Recherche..." class="autocomplete-search-input" type="text" />
				<span class="autocomplete-icon-after"><i class="far fa-times"></i></span>
			</label>
			<ul class="autocomplete-search-list">
				<li class="autocomplete-result">
					<img class="autocomplete-result-image" src="https://pbs.twimg.com/profile_images/378800000483044729/a9887ba5faac56724e7988ce95c5bab0_normal.png" />
					<div class="autocomplete-result-container">
						<span class="autocomplete-result-title">Titre</span>
						<span class="autocomplete-result-subtitle">Sous-titre</span>
						<span class="wpeo-button button-main ajou_client">Nouveau clients WP_shop</a>
					</div>
				</li>
			</ul>
		</div>
<div id="erf" class="wpeo-grid grid-4" style="display:none;">
		<h4 class="form-label"><?php echo esc_html_e( 'Add New customer', 'Call-Manager' ); ?></h4>
		<div class="form-element">
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-building"></i></span>
				<input type="text"
				name="societe" class="form-field" placeholder="société" />
			</label>
		</div>
		<div class="form-element">
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
			<input type="text" class="form-field"
			name="username" placeholder="username" value="">
			<input type="hidden" id="samplepermalinknonce" name="samplepermalinknonce" value="411fb0931e">

		</label>

			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<input
				name="lastname" type="text" class="form-field" placeholder="lastname" />
			</label>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-envelope"></i></span>
				<input
				name="email" type="email" class="form-field" placeholder="email" />
			</label>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-phone"></i></span>
				<input
				name="phone" type="tel" class="form-field" placeholder="tel" />
			</label>
</div>
</div>

		<div class="form-element">
<span class="form-label"><?php echo esc_html_e( 'Comment', 'Call-Manager' ); ?></span>
<label class="form-field-container">
	<textarea class="form-field" rows="5" cols="5" name="commentaire" placeholder=<?php esc_html_e( 'read a Comment !', 'Call-Manager' ); ?>></textarea>
</label>
</div>
	</form>
</div>
