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
<div id="displayerror">
	<div id="displayerror">
	<?php
	if ( isset( $ar ) ) {

		echo esc_html( $ar );

	}
	?>
	</div>
</div>
