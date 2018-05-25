<?php
/**
 * Definition du schema de call-comment .
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018
 * @package call_manager
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
			'type'      => 'string',
			'default'   => 'treated',
			'meta_type' => 'single',
			'field'     => 'call_status',
		);
		parent::__construct( $data, $req_method );
	}
}
