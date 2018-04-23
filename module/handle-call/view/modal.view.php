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
<p><strong>Liste des personnes Connectée(s)</strong></p>

<div>img.Avatar</div>
<hr>


<div class="wpeo">
	<form class="wpeo-form">
<input type="hidden" name="action" value="send_form">
<span class="form-label"><strong>Status des Appels</strong></span>
	<div class="wpeo-grid grid-4">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="radio" id="radio1" class="form-field" name="type" checked value="traite">
				<label for="radio1">Appel Traité</label>
			</div>
			<div class="form-field-inline">
				<input type="radio" id="radio2" class="form-field" name="type" value="transfere">
				<label for="radio2">Transféré</label>
			</div>
		</label>
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="radio" id="radio3" class="form-field" name="type" checked value="rappeler">
				<label for="radio1">A rappeller</label>
			</div>
			<div class="form-field-inline">
				<input type="radio" id="radio4" class="form-field" name="type" value="rappelera">
				<label for="radio2">Rappelera</label>
			</div>
		</label>

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
	<textarea class="form-field" rows="5" cols="5" name="content" placeholder="loremipsum...."></textarea>
</label>
</div>
	</form>





</div>
