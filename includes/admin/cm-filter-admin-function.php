<?php
/**
 * [FR]  Page répertoriant les ajouts et les actions des boutons Call & Blame.
 * [ENG] This Php file contain adds and actions for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

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

	$content .= "<li class='temp'> __( Nombre d'appel ) : <strong> $number_call </strong></li>";
	$content .= "<li class='temp'> __( Nombre de blame ) : <strong> $number_blame </strong></li>";
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
	$content .= "<li class='temp'> __( Nombre d'appel ) : <strong> $number_call </strong></li>";
	$content .= "<li class='temp'> __( Nombre de blame ) : <strong> $number_blame </strong></li>";
	return $content;
}
