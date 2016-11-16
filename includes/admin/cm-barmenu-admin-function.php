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
