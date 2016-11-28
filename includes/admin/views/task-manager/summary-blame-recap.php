<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du blame-recap dans chronologie de task-maanger.
 * [ENG] This Php file contain a div for the blame-recap's pop-up from Chronology in task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="cm-summary-blame-recap-<?php echo esc_attr( $user_id . $year . $month . $day ); ?>" class="hidden pop-up"
<?php
if ( null !== $day ) {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes que vous avez blame ce jour-là' , 'call-manager' ) ?>" <?php
} else {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes que vous avez blame ce mois-ci' , 'call-manager' ) ?>" <?php
}
?>
>
	<?php
	$select = get_user_meta( get_current_user_id(),'imputation_' . $year . $month, true );
	$total_blame = 0;
	$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . get_current_user_id() . '' );
	if ( ! empty( $id_select ) ) {
		$i = 0;
		if ( null === $day ) {
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
		?>
		<table>
			<tr>
			<?php
			if ( null !== $day ) {
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
				foreach ( $cm_recap_day_array as $name => $nbr_blame_day ) {
					?>
					<td> <?php echo esc_html( $name . ' : ' . $nbr_blame_day . '.' ) ?> </td>
					<td> </td> <td> </td> <td> </td> <td> </td> <td> </td>
					<?php
					$i++;
					if ( 0 === $i % 8 ) {
						?> </tr> <tr> <?php
					}
				}
			} elseif ( null === $day ) {
				foreach ( $cm_recap_month_array as $name => $nbr_blame_month ) {
					?>
					<td> <?php echo esc_html( $name . ' : ' . $nbr_blame_month . '.' ) ?> </td>
					<td> </td> <td> </td> <td> </td> <td> </td> <td> </td>
					<?php
					$i++;
					if ( 0 === $i % 8 ) {
						?> </tr> <tr> <?php
					}
				}
			}
			?>
			</tr>
		</table>
		<?php
	}
	?>
</div>
