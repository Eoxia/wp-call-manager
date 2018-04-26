<?php
/**
 * Button view of "Call Manager" module.
 *
 * @author You <you@mail>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018+
 * @package call_manager
 */

namespace handle_call;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-button button-main wpeo-modal-event"
	data-action="ajax_launch"
	data-title="Call Manager"
	>
	<i class="#"></i> <span>Call Manager modal</span>
</div>

<div class="wpeo-button button-yellow action-input"
	data-action="ajax_hook1"
	>
	<i class="#"></i> <span>Cree Category</span>
</div>

<div class="wpeo-button button-red action-input"
	data-action="ajax_hook2"
	>
	<i class="#"></i> <span>Cree Posts</span>
</div>
