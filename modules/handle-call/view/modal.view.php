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
		echo "<a href='#'>" . esc_html( $user->data['displayname'] ) . '</a>';
	endforeach;
?>
</br>
<div class="wpeo-grid">
<span class="form-label"><strong>Status des Appels</strong></span>
<hr>
<?php
foreach ( $posts as $post ) :
	echo '<div class="form-field">';
		echo '<input type="radio" class="form-field" name="le_status" checked="true" value="' . esc_html( $post->data['id'] ) . '">';
		echo "<label for='radio1'>" . esc_html( $post->data['title'] ) . '</label></div>';
	endforeach;
?>



		<div class="wpeo-autocomplete">
			<label class="autocomplete-label" for="mon-autocomplete">
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



	</div>
		<div class="form-element">
<span class="form-label">Commentaire</span>
<label class="form-field-container">
	<textarea class="form-field" rows="5" cols="5" name="commentaire" placeholder="loremipsum...."></textarea>
</label>
</div>
	</form>

</div>
