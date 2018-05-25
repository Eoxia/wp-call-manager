<?php
/**
 * Form view of "Call Manager" module.
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

	<form class="form-element group-date" method="get">

		<span class="form-label"><?php echo esc_html_e( 'Date', 'call-manager' ); ?></span>
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fal fa-calendar-alt"></i></span>
			<input type="date" name="date_start" class="form-field date" />
		</label>

		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fal fa-calendar-alt"></i></span>
			<input type="date"  name="date_end" class="form-field date" />
		</label>
			<input type="submit" value="<?php echo esc_html_e( 'Search', 'call-manager' ); ?>" class="wpeo-button button-progress button-main"></div>
	</form>

	<form method="post">
		<span class="form-label"><?php echo esc_html_e( 'Status', 'call-manager' ); ?></span>
		<label class="form-field-container">
			<select id="monselect" name ="status" class="form-field">
<?php
foreach ( $four_categorys as $four_category => $key ) :
		?>
				<option value="<?php echo $four_category ; ?>"><?php echo $key ; ?></option>
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
	<div class="wpeo-table table-flex table-5">
		<div class="table-row table-header">
			<div class="table-cell"><?php echo esc_html_e( 'Date and Hour', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'For Admin', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'Status', 'call-manager' ); ?></div>
			<div class="table-cell"><?php echo esc_html_e( 'Call Comment', 'call-manager' ); ?></div>
		</div>
		<?php
		if ( isset( $comments ) ) {
		foreach ( $comments as $comment ) :
				?>
				<div class="table-row">
					<div class="table-cell"><?php echo $comment->data['date']['rendered']['date_time']; ?></div>
					<div class="table-cell"><?php echo $comment->data['author_nicename']; ?></div>
					<div class="table-cell"><?php echo $comment->data['call_status']; ?></div>
					<div class="table-cell"><?php echo $comment->data['content']; ?></div>
				</div>
		<?php
			endforeach;
		}
		?>
</div>
<!-- Tableau End -->
</div>
