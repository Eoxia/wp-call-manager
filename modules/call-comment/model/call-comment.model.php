<?php
/**
 * Define schema of call-comment
 *
 * @author You <you@mail>
 * @since 0.1.0
 * @version 0.1.0
 * @copyright 2017+
 * @package starter
 */

namespace call_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Comment_Model
 */
class Call_Comment_Model extends \eoxia\Comment_Model {
	/**
	 * Call_Comment_Model
	 *
	 * @param array $data       -.
	 * @param mixed $req_method -.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['call_status'] = array(
			'type'    => 'string',
			'default' => 'treated',
		);
	}
}
