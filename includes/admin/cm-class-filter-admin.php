<?php
/**
 * [FR]  Page ajoutant les filtres des boutons Call & Blame.
 * [ENG] This Php file contain filters for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/**
 * Class qui gère les ajouts sur Task Manager..
 */
class Cm_Filter_Admin {
	/**
	 * Fonction utilisé quand la class est appelé qui appelle les autres fonctions de la classe.
	 *
	 * @method __construct
	 */
	public function __construct() {
		add_filter( 'tm_filter_timeline_summary_month_end', array( $this, 'display' ), 106, 4 );
		add_filter( 'tm_filter_timeline_day', array( $this, 'display' ), 106, 5 );
	}

	/**
	 * [FR]  Ajout du total de Call & Blame du mois et du jour dans la chronologie.
	 * [ENG] From here it's the compatiblity with Task-manager's Chronology.
	 *
	 * @method display.
	 * @param  mixed $content Le contenu.
	 * @param  int   $user_id L'id de la personne en cours d'affichage.
	 * @param  int   $year    L'année de la chronologie affichée.
	 * @param  int   $month   Le mois en cours de la chronologie.
	 * @param  int   $day     Le jour en cours de la chronologie.
	 * @return mixed $content Ajout sous forme de text dans la chronologie du mois.
	 */
	public function display( $content, $user_id, $year, $month, $day = null ) {
		$number_call = 0;
		$number_blame = 0;
		$selection = get_user_meta( $user_id, 'imputation_' . $year . '' . $month, true );
		if ( ! empty( $selection ) ) { // TOTAL DES BLAME & CALL.
			if ( null === $day ) {
				foreach ( $selection as $key => $call ) {
					$number_call = $number_call + $selection[ $key ]['call'];
					foreach ( $selection[ $key ]['blame'] as $id => $valueblame ) {
						$number_blame = $number_blame + $selection[ $key ]['blame'][ $id ];
					}
				}
			} else {
				$number_call = $selection[ $day ]['call'];
				foreach ( $selection[ $day ]['blame'] as $id => $valueblame ) {
					$number_blame = $number_blame + $selection[ $day ]['blame'][ $id ];
				}
			}
		}

		include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-filter.php' );

		$select = get_user_meta( get_current_user_id(),'imputation_' . $year . $month, true );
		$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
		$i = 0;
		if ( ! empty( $id_select ) ) { // DIV DES RECAP.
			if ( null === $day ) { // MOIS EN COURS.
				for ( $m = 0; $m <= 31; $m++ ) {
					$cm_month[] = $m;
				}
				$nbr_total_blame_inconnu = 0;
				$nbr_total_blame_stagiaire = 0;
				$cm_recap_month_array = array();
				foreach ( $cm_month as $non_day ) {
					if ( isset( $select[ $non_day ]['blame']['0'] ) and ( 0 !== $select[ $non_day ]['blame']['0'] ) ) {
						$nbr_total_blame_inconnu = $nbr_total_blame_inconnu + $select[ $non_day ]['blame']['0'];
					}
					if ( isset( $select[ $non_day ]['blame']['999999'] ) and ( 0 !== $select[ $non_day ]['blame']['999999'] ) ) {
						$nbr_total_blame_stagiaire = $nbr_total_blame_stagiaire + $select[ $non_day ]['blame']['999999'];
					}
					foreach ( $id_select as $user ) {
						if ( ! empty( $select[ $non_day ]['blame'][ $user->ID ] ) ) {
							$name = ucfirst( $user->display_name );
							$nbr_blame = $select[ $non_day ]['blame'][ $user->ID ];
							if ( ! isset( $cm_recap_month_array[ $name ] ) ) {
								$cm_recap_month_array[ $name ] = 0;
							}
							$cm_recap_month_array[ $name ] = $cm_recap_month_array[ $name ] + $nbr_blame;
						}
					}
				}
				$cm_recap_month_array['Inconnus'] = $nbr_total_blame_inconnu;
				$cm_recap_month_array['Stagiaires'] = $nbr_total_blame_stagiaire;
			}
			if ( null !== $day ) { // JOUR COURRANT.
				$cm_recap_day_array = array();
				if ( isset( $select[ $day ]['blame']['0'] ) and ( 0 !== $select[ $day ]['blame']['0'] ) ) {
					$cm_recap_day_array['Inconnus'] = $select[ $day ]['blame']['0'];
				}
				if ( isset( $select[ $day ]['blame']['999999'] ) and ( 0 !== $select[ $day ]['blame']['999999'] ) ) {
					$cm_recap_day_array['Stagiaires'] = $select[ $day ]['blame']['999999'];
				}
				foreach ( $id_select as $user ) {
					if ( ! empty( $select[ $day ]['blame'][ $user->ID ] ) ) {
						$name = ucfirst( $user->display_name );
						$nbr_blame = $select[ $day ]['blame'][ $user->ID ];
						$cm_recap_day_array[ $name ] = $nbr_blame;
					}
				}
			}
		}

		include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-call-recap.php' );
		include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-blame-recap.php' );
	}
}

new Cm_Filter_Admin();
