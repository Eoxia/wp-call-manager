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
<input type="hidden" name="action" value="send_form">

<?php
wp_nonce_field( 'send_form' );
foreach ( $users as $user ) :
		echo "<a href='#' data-id='" . esc_html( $user->data['id'] ) . "'>" . esc_html( $user->data['displayname'] ) . '   /    </a>';
	endforeach;
?>
<input id='id_cust' type='hidden' name="id_cust" value="">
<input id="yup" type="hidden" class="#" name="id_admin" value="" >
</br>
<div class="wpeo-grid">
<span class="form-label"><strong>Status des Appels</strong></span>
<hr>
<?php
foreach ( $four_categorys as $keys => $four_category ) :
	echo '<div class="form-field">';
		echo '<input type="radio" class="form-field" name="le_status" checked="true" value="' . esc_attr( $keys ) . '">';
		echo "<label for='radio1'>" . esc_html( $four_category ) . '</label></div>';
	endforeach;
?>
		<div class="wpeo-autocomplete" data-action="search_admins">
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
					</div>
				</li>
			</ul>
		</div>
<hr>

<button class="ajou_client">Ajouter clients</button>

<div id="erf" class="wpeo-grid grid-4" style="display:none;">

	<div class="form-element">
		<span class="form-label">Ajouter un contact</span>
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-building"></i></span>
			<input type="text" class="form-field" placeholder="Société" />
		</label>
		</div>
			<div class="form-element">
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
			<input type="text" class="form-field" placeholder="Nom" />
		</label>
	</div>
			<div class="form-element">
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
			<input type="text" class="form-field" placeholder="Prénom" />
		</label>
	</div>
	<div class="form-element">
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-envelope"></i></span>
			<input type="text" class="form-field" placeholder="email" />
		</label>
	</div>
</div>

	</div>
		<div class="form-element">
<span class="form-label">Commentaire</span>
<label class="form-field-container">
	<textarea class="form-field" rows="5" cols="5" name="commentaire" placeholder="loremipsum...."></textarea>
</label>
</div>
	</form>

</div>
