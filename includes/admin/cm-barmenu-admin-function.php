<?php
/**
 * [FR]  Page ajoutant les boutons Call & Blame & Recall ainsi que les divs contenant les formulaires et le css des boutons et des dialogs.
 * [ENG] This Php file adds buttons Call & Blame & Recall and contains divs for forms, dialogs' and buttons' css.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

add_action( 'admin_bar_menu', 'imputation_tel', 100 );
add_action( 'admin_bar_menu', 'imputation', 101 );
add_action( 'admin_bar_menu', 'imputation_recall', 102 );

/**
 * [FR]  La fonction suivante créer le bouton Call.
 * [ENG] This function create the button Call.
 *
 * @method imputation_tel
 * @param  mixed $wp_admin_bar WordPress function for addding node.
 */
function imputation_tel( $wp_admin_bar ) {
	$user_data = get_userdata( get_current_user_id() );
	if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
		$time_db = current_time( 'Ym' );
		$day = intval( current_time( 'd' ) );
		$select = get_user_meta( get_current_user_id(),'imputation_' . $time_db, true );
		if ( '' === $select ) {
			$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
			foreach ( $id_select as $user ) {
				$ids[ $user->ID ] = 0;
			}
			$ids['0'] = 0;
			$ids['999999'] = 0;
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
			'title'    => '<span style="cursor:pointer;" class="ab-action"><span class="ab-icon"></span><span class="ab-label">' . $total_call . '</span></span>',
		);
		$wp_admin_bar->add_node( $bouton_tel );
		$bouton_tel_moins = array(
			'id'       => 'imputation_tel_moins',
			'title'    => '<span style="cursor:pointer;" class="ab-action-moins"><span class="ab-icon"></span>' . esc_html__( 'Retirer un appel' ) . '</span>',
			'parent'   => 'imputation_tel',
		);
		$wp_admin_bar->add_node( $bouton_tel_moins );
	}
}

/**
 * [FR]  La fonction suivante créer le bouton Blame qui affiche un sub-menu de tous les administrateurs à blame.
 * [ENG] This function create the Blame button which display a sub-menu of all administrators.
 *
 * @method imputation
 * @param  mixed $wp_admin_bar WordPress function for addding node.
 */
function imputation( $wp_admin_bar ) {
	$user_data = get_userdata( get_current_user_id() );
	if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
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
			if ( ! isset( $select[ $day ]['blame']['0'] ) ) {
				$select[ $day ]['blame']['0'] = 0;
				$select[ $day ]['blame']['999999'] = 0;
			}
			$total_blame = $total_blame + $select[ $day ]['blame']['0'];
			$total_blame = $total_blame + $select[ $day ]['blame']['999999'];
		}
		$bouton_blame = array(
			'id' 		=> 'imputation',
			'title'	=> '<span class="ab-icon"></span><span class="ab-label">' . $total_blame . '</span>',
		);
		$wp_admin_bar->add_node( $bouton_blame );
		$admin_user = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
		$blame_number_inconnu = 0;
		if ( ! empty( $select[ $day ]['blame']['0'] ) ) {
			$blame_number_inconnu = $select[ $day ]['blame']['0'];
		}
		$inconnu = array(
			'id' => 'to_blame_0',
			'title' => '<span class="ab-child">Inconnu ' . esc_html__( 'vous a interrompu :', 'call-manager' ) . ' <span class="ab-retour_0">' . $blame_number_inconnu . '</span> fois.</span>',
			'parent' => 'imputation',
			'href' => admin_url( 'admin-ajax.php?action=count&user_id=0' ),
			'meta' => array(
				'class' => 'child_blame',
				'title' => esc_html__( 'Cliquez pour ajouter une interruption' ),
			),
		);
		$wp_admin_bar->add_node( $inconnu );
		$blame_number_stagiaire = 0;
		if ( ! empty( $select[ $day ]['blame']['999999'] ) ) {
			$blame_number_stagiaire = $select[ $day ]['blame']['999999'];
		}
		$stagiaire = array(
			'id' => 'to_blame_999999',
			'title' => '<span class="ab-child">Stagiaire ' . esc_html__( 'vous a interrompu :', 'call-manager' ) . ' <span class="ab-retour_999999">' . $blame_number_stagiaire . '</span> fois.</span>',
			'parent' => 'imputation',
			'href' => admin_url( 'admin-ajax.php?action=count&user_id=999999' ),
			'meta' => array(
				'class' => 'child_blame',
				'title' => esc_html__( 'Cliquez pour ajouter une interruption' ),
			),
		);
		$wp_admin_bar->add_node( $stagiaire );
		foreach ( $admin_user as $user ) {
			$id = $user->ID;
			$name = ucfirst( $user->display_name );
			$blame_number = 0;
			if ( ! empty( $select[ $day ]['blame'][ $id ] ) ) {
				$blame_number = $select[ $day ]['blame'][ $id ];
			}
			$to_blame = array(
				'id' => 'to_blame_' . $id,
				'title' => '<span class="ab-child">' . $name . ' ' . esc_html__( 'vous a interrompu :', 'call-manager' ) . ' <span class="ab-retour_' . $id . '">' . $blame_number . '</span> fois.</span>',
				'parent' => 'imputation',
				'href' => admin_url( 'admin-ajax.php?action=count&user_id=' . $id ),
				'meta' => array(
					'class' => 'child_blame',
					'title' => esc_html__( 'Cliquez pour ajouter une interruption' ),
				),
			);
			$wp_admin_bar->add_node( $to_blame );
		}
		$group = array(
			'id' => 'blame_group',
			'parent' => 'imputation',
		);
		$wp_admin_bar->add_group( $group );
	}
}

/**
 * Bouton Recall qui ne s'affiche que quand vous avez une personne à rappeler.
 *
 * @method imputation_recall.
 * @param [type] $wp_admin_bar [description].
 */
function imputation_recall( $wp_admin_bar ) {
	$user_data = get_userdata( get_current_user_id() );
	if ( 'administrator' === implode( ', ', $user_data->roles ) ) {
		$select_comment = array(
			'meta_key' => '_eocm_receiver_id',
			'meta_value' => get_current_user_id(),
			'status' => 'recall',
			'count' => true,
		);
		$selected_comment = get_comments( $select_comment );
		if ( $selected_comment > 0 ) {
			$bouton_recall = array(
				'id' => 'imputation_recall',
				'title' => '<span class="ab-action-recall"><span class="ab-icon"></span>' . esc_html( 'Vous avez des personnes à rappeler !', 'call-manager' ) . '</span>',
				'meta' => array( 'title' => __( 'CLiquez ici pour plus de détails' ) ),
			);
			$wp_admin_bar->add_node( $bouton_recall );
		}
	}
}

add_action( 'admin_footer', 'dialog', 999 );

/**
 * [FR]  Création de la Div pour la pop-up du bouton Call & Recall.
 * [ENG] Here we create a div for the pop-up dialog when you clic on the Call & Recall buttons.
 *
 * @method dialog_call.
 */
function dialog() {
	include( plugin_dir_path( __FILE__ ) . 'views/form-call.php' );
	include( plugin_dir_path( __FILE__ ) . 'views/dialog-recall.php' );
}

add_action( 'admin_enqueue_scripts', 'cm_custom_wp_toolbar_css_admin' );
add_action( 'wp_enqueue_scripts', 'cm_custom_wp_toolbar_css_admin' );

/**
 * [FR]  Ajout du CSS des boutons Call & BLame.
 * [ENG] Function to add CSS for buttons Call & Blame.
 *
 * @method custom_wp_toolbar_css_admin.
 */
function cm_custom_wp_toolbar_css_admin() {
	wp_enqueue_style( 'cm_add_custom_wp_toolbar_css', plugin_dir_url( __FILE__ ) . '../../assets/css/style.css', array( 'wp-jquery-ui-dialog' ) );
	wp_enqueue_script( 'cm_custom_js', plugin_dir_url( __FILE__ ) . '../../assets/js/admin/cm-admin.js', array( 'jquery-ui-dialog', 'jquery-form' ) );
}
