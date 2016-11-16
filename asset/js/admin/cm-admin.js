<?php
/**
 * [FR]  Page répertoriant les ajouts et les actions des boutons Call & Blame.
 * [ENG] This Php file contain adds and actions for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

function my_action_javascript() {
	?>
	<script type = "text/javascript" >
	jQuery( document ).ready( function( $ ) {
		jQuery( "#wp-admin-bar-imputation .child_blame" ).click( function(e) {
			e.preventDefault();
			var a = jQuery( this ).find( 'a' );
			var href = a.attr( 'href' );
			var data = null;
			jQuery.get( href, data, function( response ) {
				jQuery( "#wp-admin-bar-imputation .ab-label" ).text( response.data.total );
				jQuery( "#wp-admin-bar-imputation .ab-retour_" + response.data.id_user ).text( response.data.count_current_user );
			});
		});
		jQuery( "#wp-admin-bar-imputation_tel .ab-action" ).click( function(){
			jQuery( "#dialog" ).dialog("open");
			var data = {
				'action': 'count_tel',
			};
			jQuery.post( ajaxurl, data, function( response ) {
				jQuery( "#wp-admin-bar-imputation_tel .ab-label" ).text( response )
			});

		});
		jQuery( "#dialog" ).dialog( {
			autoOpen: false,
			resizable: false,
			height: "auto",
			width: "auto",
			modal: true,
			buttons: {
				"OK": function() {
					jQuery( "#form-dialog" ).ajaxSubmit();
					$( this ).dialog( "close" );
				},
				Annuler: function() {
					$( this ).dialog( "close" );
				}
			}
		});

	});
	</script>
	<?php
}
