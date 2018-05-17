<?php
/**
 * Form view of "Call Manager" module.
 *
 * @author You <you@mail> => @author Eoxia <dev@eoxia.com>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018
 * @package call_manager
 */

namespace handle_call;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="wpeo">
	<?php
	foreach ( $four_categorys as $keys => $four_category ) :
		echo '<div class="inline">';
			echo '<input type="radio" class="wpeo-button button-main" name="#" value="' . esc_attr( $keys ) . '">';
			echo "<label for='radio1'>" . esc_html( $four_category ) . '</label></div>';
		endforeach;
	?>
	<div>
	</div>
</div>
