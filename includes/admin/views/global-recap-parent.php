<?php
/**
 * Page ajoutant le tableau global-recap-parent.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div class="wrap">
	<div> <table border="1" cellspacing="0" cellpadding="5" style="text-align: center; table-layout: fixed; margin: 0 auto;"> <tr style="background-color: #BBBBBB;"> <th> <?php echo esc_html( 'Récapitulatif complet de tous les administrateurs du ' . $month . '/' . $year, 'call-manager' ); ?> </th> </tr> </table> </div>
	<div class="wrap">
		<table border="2" cellspacing="0" cellpadding="1" style="text-align: center; table-layout: fixed; margin: 0 auto;" >
			<tr>
				<th><?php esc_html_e( 'User name', 'call-manager' ); ?></th>
			<?php for ( $i = 1; $i <= 31; $i++ ) : ?>
				<th colspan="2" ><?php echo esc_html( $i ); ?></th>
			<?php endfor; ?>
			</tr>
			<tr>
				<th></th>
			<?php for ( $i = 1; $i <= 31; $i++ ) : ?>
				<th><i class="dashicons dashicons-phone"></i></th>
				<th><i class="dashicons dashicons-businessman"></i></th>
			<?php endfor; ?>
			</tr>
			<?php
			foreach ( $data_users as $data ) {
				$user_id = $data->ID;
				$user_name = $data->display_name;
				?>
				<tr>
					<td>
						<?php echo esc_html( $user_name ); ?>
					</td>
				<?php
				$user_meta = get_user_meta( $user_id, 'imputation_' . $year . $month, true );
				if ( '' === $user_meta ) {
					$id_select = get_users( 'orderby=nicename&role=administrator&exclude=' . $user_id . '' );
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
					update_user_meta( $user_id, 'imputation_' . $year . $month, $imputation );
					$user_meta = get_user_meta( $user_id, 'imputation_' . $year . $month, true );
					$total_call = $user_meta[ $day ]['call'];
				}
				include( plugin_dir_path( __FILE__ ) . 'global-recap-child.php' );
				?>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
</div>
<?php
