<?php
/**
 * Form view of "Call Manager" module.
 * vue pour la page Call_List dans le menu lateral.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018
 * @package call_manager
 */

namespace handle_call;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="wrap wpeo-wrap">
<!-- Filtre tableau start -->
<div class="form-element">

	<form class="form-element group-date" method="post">

		<span class="form-label"><strong><?php echo esc_html_e( 'Date', 'call-manager' ); ?></strong></span>

		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fal fa-calendar-alt"></i></span>
			<input type="date" name="date_start" class="form-field" />
		</label>

		<label class="form-field-container">
			<span class="form-field-icon-prev"></span>
			<input type="date" name="date_end" class="form-field" />
		</label>

		<span class="form-label"><strong><?php echo esc_html_e( 'Status', 'call-manager' ); ?></strong></span>
		<label class="form-field-container">
			<select id="monselect" name ="status" class="form-field">
					<option value=""><?php echo esc_html_e( 'All Category', 'call-manager' ); ?></option>
<?php
foreach ( $four_categorys as $four_category => $key ) :
	?>
				<option value="<?php echo esc_attr( $four_category ); ?>"><?php echo esc_html( $key ); ?></option>
				<?php
					endforeach;
?>
			</select>
		</label>
	<input type="submit" value="<?php echo esc_html_e( 'Search', 'call-manager' ); ?>" class="wpeo-button button-progress button-main"></div>
</form>
</div>
<!-- Filtre tableau End -->
<!-- Tableau start -->
	<div class="wpeo-table table-flex table-6" style="background: linear-gradient(to top, rgba(173, 143, 221, .2) 0%,rgba(152, 255, 210, .2) 100%);">
		<h2 align="center"><?php echo esc_html_e( 'Call List', 'call-manager' ); ?></h2>
		<div class="table-row table-header">
			<div class="table-cell"><?php echo esc_html_e( 'Date and Hour', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'Adminstrator', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'Status', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'Action', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'Call Comment', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'WP-Shop Custumer', 'call-manager' ); ?></div>
		</div>
		<?php
		if ( isset( $comments ) ) {
			foreach ( $comments as $comment ) :
				$id_post = get_post( $comment->data['post_id'] );
				?>
				<div class="table-row">
					<?php
					if ( '1' === $comment->data['status'] ) {
						?>
					<div class="table-cell">
						<strong><?php echo esc_html( $comment->data['date']['rendered']['date_human_readable'] ); ?></strong>
					</div>
					<div class="table-cell">
						<?php echo esc_html( $comment->data['author_nicename'] ); ?>
					</div>
					<div class="table-cell">
						<stong class="button-disabled"><?php echo esc_html( strtoupper( $comment->data['call_status'] ) ); ?></strong>
					</div>
						<?php
						if ( 'traite' === $comment->data['call_status'] ) {
							?>
						<div class="table-cell">
							<div onclick="document.location.replace('admin.php?page=call-manager&paged=1');" id="trash_btn" class="wpeo-button button-progress button-red action-attribute wpeo-animate animate-hover swing" data-action="update_status" data-id_trash="<?php echo esc_attr( $comment->data['id'] ); ?>">
							<?php echo esc_html_e( 'Drop', 'call-manager' ); ?>
							</div>
						</div>
							<?php
						}
						if ( 'traite' !== $comment->data['call_status'] ) {
							?>
							<div class="table-cell">
								<div onclick="document.location.replace('admin.php?page=call-manager&paged=1');" id="switch_btn" class="wpeo-button button-progress button-yellow action-attribute wpeo-animate animate-hover swing" data-action="update_status" data-id_call="<?php echo esc_attr( $comment->data['id'] ); ?>">
							<?php echo esc_html_e( 'Switch to treaty', 'call-manager' ); ?>
								</div>
							</div>
							<?php
						}
						?>
					<div class="table-cell button-disabled"><?php echo esc_html( $comment->data['content'] ); ?></div>
					<div class="table-cell"><?php echo esc_html( $id_post->post_title ); ?></div>
						<?php
					}
					?>
				</div>
				<?php
			endforeach;
		}
		?>
	</div>
<!-- Tableau End -->
<div>
	<?php
	$big = 999999999; // need an unlikely integer .
	echo wp_kses( paginate_links( array(
		'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format'  => '?paged=%#%',
		'current' => max( 1, $paged ),
		'total'   => $nb_page,
		) ),
		'a'
	);
	?>
</div>
