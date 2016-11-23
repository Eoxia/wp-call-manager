<?php
/**
 * [FR]  Page ajoutant les filtres des boutons Call & Blame.
 * [ENG] This Php file contain filters for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

/**
 * Blabla.
 */
class Cm_Filter_Admin {
	/**
	 * Fonction utilisé quand la class est appelé qui appelle les autres fonctions de la classe.
	 *
	 * @method __construct
	 */
	public function __construct() {
		add_filter( 'tm_filter_timeline_summary_month_end', array( $this, 'display' ), 106 );
		add_filter( 'tm_filter_timeline_day', array( $this, 'display' ), 106 );
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
		if ( ! empty( $selection ) ) {
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
		include( plugin_dir_path( __FILE__ ) . 'views/task-manager/summary-recap.php' );
	}
}

new Cm_Filter_Admin();
