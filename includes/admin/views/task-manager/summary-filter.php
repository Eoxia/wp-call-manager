<?php
/**
 * [ENG] This Php file contains li to add on Chronology's task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

if ( null !== $day ) {
	?>
	<li class='temp'> <span style="cursor:pointer;" class="ab-action-recap-daily"> <span class="dashicons dashicons-phone"></span> <strong> <?php echo esc_html( $number_call ); ?> </strong> </span></li>
	<li class='temp'> <span class="dashicons dashicons-businessman"></span> <strong> <?php echo esc_html( $number_blame ); ?> </strong></li>
	<?php
} else {
	?>
	<li class='temp'> <span style="cursor:pointer;" class="ab-action-recap-monthly"> <span class="dashicons dashicons-phone"></span> <strong> <?php echo esc_html( $number_call ); ?> </strong> </span></li>
	<li class='temp'> <span class="dashicons dashicons-businessman"></span> <strong> <?php echo esc_html( $number_blame ); ?> </strong></li>
	<?php
}
