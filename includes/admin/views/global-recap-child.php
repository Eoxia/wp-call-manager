<?php
/**
 * Page ajoutant le tableau global-recap-child.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

$d = 0;
foreach ( $user_meta as $data_meta ) {
	$d++;
	$day = $d;
	$total_blame = 0;
	$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . $user_id . '' );
	if ( ! empty( $id_select ) ) {
		foreach ( $id_select as $user ) {
			$x = $user->ID;
			if ( ! empty( $user_meta[ $day ]['blame'][ $x ] ) ) {
				$total_blame = $total_blame + $user_meta[ $day ]['blame'][ $x ];
			}
		}
		if ( ! isset( $user_meta[ $day ]['blame']['0'] ) ) {
			$user_meta[ $day ]['blame']['0'] = 0;
		}
		if ( ! isset( $user_meta[ $day ]['blame']['999999'] ) ) {
			$user_meta[ $day ]['blame']['999999'] = 0;
		}
		$total_blame = $total_blame + $user_meta[ $day ]['blame']['0'];
		$total_blame = $total_blame + $user_meta[ $day ]['blame']['999999'];
	}
	?>
	<td>
		<table border="1" cellspacing="0" cellpadding="5" style="text-align: center;">
			<tr style="background-color: #e0e0e0;">
				<td colspan="2">
					Jour <?php echo esc_html( $d ); ?>
				</td>
			</tr>
			<tr style="background-color: #eeeeee;">
				<td style="color: <?php if ( $color < $user_meta[ $day ]['call'] ) { echo 'red'; } ?>;" >
					<span class="dashicons dashicons-phone"></span> <?php echo esc_html( $user_meta[ $day ]['call'] ); ?>
				</td>
				<td style="color: <?php if ( $color < $total_blame ) { echo 'red'; } ?>;">
					<span class="dashicons dashicons-businessman"></span> <?php echo esc_html( $total_blame ); ?>
				</td>
			</tr>
		</table>
	</td>
	<?php
}
