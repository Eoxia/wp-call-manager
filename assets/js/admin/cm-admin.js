
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
		jQuery( "#dialog" ).dialog( "open" );
		var data = {
			'action': 'count_tel',
		};
		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( "#wp-admin-bar-imputation_tel .ab-label" ).text( response )
		});
	});
	jQuery( "#wp-admin-bar-imputation_tel_moins .ab-action-moins" ).click( function(){
		var data = {
			'action': 'count_tel_moins',
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
	jQuery( "#wp-admin-bar-imputation_recall .ab-action-recall" ).click( function(){
		jQuery( "#dialog-recall" ).dialog( "open" );
	});
	jQuery( "#dialog-recall a" ).click ( function (e) {
		e.preventDefault();
		var link = jQuery( this );
		var href = link.attr( 'href' );
		console.log(href);
		var data = null;
		jQuery.get( href, data, function() {
			link.closest( "tr" ).remove();
		});
	});
	jQuery( "#dialog-recall" ).dialog( {
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: "auto",
		modal: true,
		buttons: {
			Fermer: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	jQuery( ".ab-action-recap" ).click( function () {
		jQuery( "#cm-summary-recap" ).dialog( "open" );
	});
	jQuery( "#cm-summary-recap" ).dialog( {
		autoOpen: false,
		resizable: true,
		height: "40%",
		width: "20%",
		modal: true,
		buttons: {
			Fermer: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
