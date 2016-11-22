
jQuery( document ).ready( function( $ ) {
	function validateEmail( $email ) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,20})?$/;
		return emailReg.test( $email );
	}
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
		var name = "";
		jQuery( "#form-dialog #name_contact_call" ).attr( "value" , name );
		var society = "";
		jQuery( "#form-dialog #society_contact_call" ).attr( "value" , society );
		var email = "";
		jQuery( "#form-dialog #email_contact_call" ).attr( "value" , email );
		var number = "";
		jQuery( "#form-dialog #number_contact_call" ).attr( "value" , number );
		var comment = "";
		jQuery( "#form-dialog #comment_content_call" ).attr( "value" , comment );
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
			Rechercher: function() {
				var emailCheck = jQuery( "#form-dialog #email_contact_call" ).val();
				if ( validateEmail( emailCheck ) ) {
					jQuery( "#form-dialog" ).click().attr( "method", "GET" ).ajaxSubmit( function( response ) {
						var name = response.data.name;
						jQuery( "#form-dialog #name_contact_call" ).attr( "value" , name );
						var society = response.data.society;
						jQuery( "#form-dialog #society_contact_call" ).attr( "value" , society );
						var email = response.data.mail;
						jQuery( "#form-dialog #email_contact_call" ).attr( "value" , email );
						var number = response.data.number;
						jQuery( "#form-dialog #number_contact_call" ).attr( "value" , number );
						var comment = response.data.commentcontent;
						if ( null === comment ) { var comment = "Inconnu / Not found" }
						jQuery( "#form-dialog #comment_content_call" ).attr( "value" , comment );
					});
				}	else {
					var comment = "E-mail non valide !";
					jQuery( "#form-dialog #comment_content_call" ).attr( "value" , comment );
				}
			},
			OK: function() {
				var emailCheck = jQuery( "#form-dialog #email_contact_call" ).val();
				if ( validateEmail( emailCheck ) ) {
					jQuery( "#form-dialog" ).click().attr( "method", "POST" ).ajaxSubmit();
					jQuery( "#dialog" ).dialog( "close" );
				}	else {
					var comment = "E-mail non valide !";
					jQuery( "#form-dialog #comment_content_call" ).attr( "value" , comment );
				}
			},
			Annuler: function() {
				var data = {
					'action': 'count_tel_moins',
				};
				jQuery.post( ajaxurl, data, function( response ) {
					jQuery( "#wp-admin-bar-imputation_tel .ab-label" ).text( response )
				});
				jQuery( "#dialog" ).dialog( "close" );
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
	jQuery( ".ab-action-recap-monthly" ).click( function () {
		jQuery( this ).closest( "ul" ).find( ".pop-up" ).dialog( {
			autoOpen: true,
			resizable: true,
			height: "600",
			width: "850",
			modal: true,
			buttons: {
				Fermer: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	jQuery( ".ab-action-recap-daily" ).click( function () {
		jQuery( this ).closest( "ul" ).find( ".pop-up" ).dialog( {
			autoOpen: true,
			resizable: true,
			height: "600",
			width: "850",
			modal: true,
			buttons: {
				Fermer: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
});
