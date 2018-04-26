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

namespace starter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Handle call-comment
*/
class Call_Comment_Model extends \eoxia\Comment_Model {
	public function __construct( $object, $req_method = null ) {




		parent::__construct( $object, $req_method );
	}
}
