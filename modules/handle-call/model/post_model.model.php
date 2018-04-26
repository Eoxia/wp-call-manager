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
* Handle call-model
*/
class Post_Model extends \eoxia\Post_Model  {
	/**
	 * Model Post_Model .
	 */
	public function __construct( $object, $req_method = null ) {
		$this->schema['taxonomy'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(
				'my-category' => array(
					'meta_type'  => 'multiple',
					'array_type' => 'integer',
					'type'       => 'array',
				),
			),
		);
		parent::__construct( $object, $req_method );
	}
}
