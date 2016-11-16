<?php
/**
 * [FR]  Page répertoriant les ajouts et les actions des boutons Call & Blame.
 * [ENG] This Php file contain adds and actions for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

add_action( 'admin_bar_menu', 'imputation_tel', 100 );
/**
 * [FR]  La fonction suivante créer le bouton Call.
 * [ENG] This function create the button Call.
 *
 * @method imputation_tel
 * @param  mixed $wp_admin_bar WordPress function for addding node.
 */
function imputation_tel( $wp_admin_bar ) {
	$time_db = current_time( 'Ym' );
	$day = intval( current_time( 'd' ) );
	$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
	if ( '' === $select ) {
		$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
		foreach ( $id_select as $user ) {
			$ids[ $user->ID ] = 0;
		}
		for ( $i = 1; $i <= 31; $i++ ) {
			$imputation[ $i ] = array(
					'call' => 0,
					'blame' => $ids,
			);
		}
		update_user_meta( get_current_user_id(), 'imputation_' . $time_db, $imputation );
		$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
		$total_call = $select[ $day ]['call'];
	}
	if ( '' !== $select ) {
		$total_call = $select[ $day ]['call'];
	}
	$bouton_tel = array(
		'id'       => 'imputation_tel',
		'title'    => '<span class="ab-action"><span class="ab-icon"></span><span class="ab-label">' . $total_call . '</span></span>',
	);
	$wp_admin_bar->add_node( $bouton_tel );
}

add_action( 'wp_ajax_count_tel', 'count_tel_callback' );
/**
 * [FR] 	Action du bouton Call.
 * [ENG]  Button Call's action.
 *
 * @method count_tel_callback Action du bouton.
 */
function count_tel_callback() {
	$time_db = current_time( 'Ym' );
	$day = intval( current_time( 'd' ) );
	$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
	$select[ $day ]['call']++;
	update_user_meta( get_current_user_id(), 'imputation_' . $time_db, $select );
	wp_die( esc_html( $select[ $day ]['call'] ) );
}

add_action( 'admin_bar_menu', 'imputation', 101 );
/**
 * [FR]  La fonction suivante créer le bouton Blame qui affiche un sub-menu de tous les administrateurs à blame.
 * [ENG] This function create the Blame button which display a sub-menu of all administrators.
 *
 * @method imputation
 * @param  mixed $wp_admin_bar WordPress function for addding node.
 */
function imputation( $wp_admin_bar ) {
	$time_db = current_time( 'Ym' );
	$day = intval( current_time( 'd' ) );
	$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
	$total_blame = 0;
	$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
	if ( ! empty( $id_select ) ) {
		foreach ( $id_select as $user ) {
			$x = $user->ID;
			if ( ! empty( $select[ $day ]['blame'][ $x ] ) ) {
				$total_blame = $total_blame + $select[ $day ]['blame'][ $x ];
			}
		}
	}
	$bouton_blame = array(
		'id' 		=> 'imputation',
		'title'	=> '<span class="ab-icon"></span><span class="ab-label">' . $total_blame . '</span>',
	);
	$wp_admin_bar->add_node( $bouton_blame );
	$admin_user = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
	foreach ( $admin_user as $user ) {
		$id = $user->ID;
		$name = ucfirst( $user->display_name );
		$blame_number = 0;
		if ( ! empty( $select[ $day ]['blame'][ $id ] ) ) {
			$blame_number = $select[ $day ]['blame'][ $id ];
		}
		$to_blame = array(
			'id' => 'to_blame_' . $id,
			'title' => '<span class="ab-child">' . $name . ' vous a interrompu : <span class="ab-retour_' . $id . '">' . $blame_number . '</span> fois.</span>',
			'parent' => 'imputation',
			'href' => admin_url( 'admin-ajax.php?action=count&user_id=' . $id ),
			'meta' => array(
				'class' => 'child_blame',
				'title' => 'Cliquez pour ajouter une interruption',
			),
		);
		$wp_admin_bar->add_node( $to_blame );
	}

	// [FR]  Groupe du blame.
	// [ENG] Blame's group.
	$group = array(
		'id' => 'blame_group',
		'parent' => 'imputation',
	);
	$wp_admin_bar->add_group( $group );
}

add_action( 'wp_ajax_count', 'count_callback' );
/**
 * [FR]  Action du bouton Blame.
 * [ENG] Button Blame's action.
 *
 * @method count_callback.
 */
function count_callback() {
	$time_db = current_time( 'Ym' );
	$day = intval( current_time( 'd' ) );
	$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
	$select[ $day ]['blame'][ $_GET['user_id'] ]++;
	update_user_meta( get_current_user_id(), 'imputation_' . $time_db, $select );
	$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
	$total_blame = 0;
	foreach ( $id_select as $user ) {
		$x = $user->ID;
		$total_blame = $total_blame + $select[ $day ]['blame'][ $x ];
	}
	$data = array(
		'count_current_user' => $select[ $day ]['blame'][ $_GET['user_id'] ],
		'total' => $total_blame,
		'id_user' => $_GET['user_id'],
	);
	wp_send_json_success( $data );
}

	add_action( 'admin_enqueue_scripts', 'custom_wp_toolbar_css_admin' );
	add_action( 'wp_enqueue_scripts', 'custom_wp_toolbar_css_admin' );
/**
 * [FR]  Ajout du CSS des boutons Call & BLame.
 * [ENG] Function to add CSS for buttons Call & Blame.
 *
 * @method custom_wp_toolbar_css_admin.
 */
function custom_wp_toolbar_css_admin() {
	wp_register_style( 'add_custom_wp_toolbar_css', plugin_dir_url( __FILE__ ) . '../asset/style.css','','', 'screen' );
	wp_enqueue_style( 'add_custom_wp_toolbar_css' );
	wp_register_style( 'add_jQuery_css', plugin_dir_url( __FILE__ ) . '../asset/jquery-ui.min.css','','', 'screen' );
	wp_enqueue_style( 'add_jQuery_css' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_script( 'jquery-form' );
}


add_action( 'admin_footer', 'my_action_javascript' );
/**
 * [FR]  AJAX de la page. Celui-ci actualise les compteurs en direct des boutons.
 * [ENG] Plugin's AJAX. This one refresh buttons directly.
 *
 * @method my_action_javascript.
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
					Pour qui ? <br />
					<select name = "to_call">
						<?php
						foreach ( $admin_user as $user ) {
							$id = $user->ID;
							$name = ucfirst( $user->display_name );
							?> <option value="<?php echo esc_html( $id ); ?>"><?php echo esc_html( $name ); ?></option> <?php
						}
						?>
					</select> <br />
					<input type="hidden" name="action" value="form_call">
					Choisissez votre option : <br />
					<input type="radio" name="button_call" value="treated" checked="checked"> Traité <br />
					<input type="radio" name="button_call" value="transfered"> Transféré <br />
					<input type="radio" name="button_call" value="recall"> A rappeler <br />
					Informations contact : <br />
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

add_action( 'wp_ajax_form_call', 'form_call_callback' );
/**
 * [FR]  Traitement du formulaire.
 * [ENG] This function save the data from the dialog form.
 *
 * @method form_call_callback.
 */
function form_call_callback() {
	if ( ! empty( $_POST['_wpnonce_dialog'] ) && check_admin_referer( 'form_dialog_check', '_wpnonce_dialog' ) ) {
		if ( '' !== $_POST['button_call'] ) {
			$button_call = $_POST['button_call'];
		} else {
			$button_call = 'empty';
		}
		if ( '' !== $_POST['number_contact_call'] ) {
			$number_contact_call = $_POST['number_contact_call'];
		} else {
			$number_contact_call = 'empty';
		}
		if ( '' !== $_POST['email_contact_call'] ) {
			$email_contact_call = $_POST['email_contact_call'];
		} else {
			$email_contact_call = 'empty';
		}
		if ( '' !== $_POST['comment_call'] ) {
			$comment_call = $_POST['comment_call'];
		} else {
			$comment_call = "Réception d'un appel (Default Comment)";
		}
		if ( '' !== $_POST['name_contact_call'] ) {
			$name_contact_call = $_POST['name_contact_call'];
		} else {
			$name_contact_call = 'empty';
		}
		if ( '' !== $_POST['society_contact_call'] ) {
			$society_contact_call = $_POST['society_contact_call'];
		} else {
			$society_contact_call = 'empty';
		}
		if ( '' !== $_POST['to_call'] ) {
			$to_call = $_POST['to_call'];
		} else {
			$to_call = 'empty';
		}
		$comment = array(
			'comment_approved' => $button_call,
			'comment_content' => $comment_call,
			'user_id' => get_current_user_id(),
		);
		$id_comment = wp_insert_comment( $comment );
		add_comment_meta( $id_comment, '_eocm_caller_phone', $number_contact_call );
		add_comment_meta( $id_comment, '_eocm_caller_email', $email_contact_call );
		add_comment_meta( $id_comment, '_eocm_caller_society', $society_contact_call );
		add_comment_meta( $id_comment, '_eocm_caller_name', $name_contact_call );
		add_comment_meta( $id_comment, '_eocm_receiver_id', $to_call );
	}
	wp_die();
}

add_filter( 'tm_filter_timeline_summary_month_end', 'display_monthly', 102, 4 );
/**
 * [FR]  Ajout du total de Call & Blame du mois dans la chronologie.
 * [ENG] From here it's the compatiblity with Task-manager's Chronology Here Monthly.
 *
 * @method display_monthly.
 * @param  mixed $content Le contenu.
 * @param  int   $user_id L'id de la personne en cours d'affichage.
 * @param  int   $year    L'année de la chronologie affichée.
 * @param  int   $month   Le mois en cours de la chronologie.
 * @return mixed $content Ajout sous forme de text dans la chronologie du mois.
 */
function display_monthly( $content, $user_id, $year, $month ) {
	$number_call = 0;
	$number_blame = 0;
	$selection = get_user_meta( $user_id, 'imputation_' . $year . '' . $month, true );
	if ( ! empty( $selection ) ) {
		foreach ( $selection as $day => $call ) {
			$number_call = $number_call + $selection[ $day ]['call'];
			foreach ( $selection[ $day ]['blame'] as $id => $valueblame ) {
				$number_blame = $number_blame + $selection[ $day ]['blame'][ $id ];
			}
		}
	}

	$content .= "<li class='temp'>Nombre d'appel : <strong> $number_call </strong></li>";
	$content .= "<li class='temp'>Nombre de blame : <strong> $number_blame </strong></li>";
	return $content;
}

add_filter( 'tm_filter_timeline_day', 'display_daily', 103, 5 );
/**
 * [FR]  Affiche le nombre de Call & Blame du jour choisi dans la chronologie.
 * [ENG] Here it's dailies' display.
 *
 * @method display_daily.
 * @param  mixed $content Le contenu.
 * @param  int   $user_id L'id de la personne en cours d'affichage.
 * @param  int   $year    L'année de la chronologie affichée.
 * @param  int   $month   Le mois en cours de la chronologie.
 * @param  int   $day     Le jour choisi.
 * @return mixed $content Ajout sous forme de text dans la chronologie du jour.
 */
function display_daily( $content, $user_id, $year, $month, $day ) {
	$number_call = 0;
	$number_blame = 0;
	$selection = get_user_meta( $user_id, 'imputation_' . $year . '' . $month, true );
	if ( ! empty( $selection ) ) {
		$number_call = $selection[ $day ]['call'];
		foreach ( $selection[ $day ]['blame'] as $id => $valueblame ) {
			$number_blame = $number_blame + $selection[ $day ]['blame'][ $id ];
		}
	}
	$content .= "<li class='temp'>Nombre d'appel : <strong> $number_call </strong></li>";
	$content .= "<li class='temp'>Nombre de blame : <strong> $number_blame </strong></li>";
	return $content;
}
