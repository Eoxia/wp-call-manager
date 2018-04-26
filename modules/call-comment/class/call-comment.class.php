<?php
/**
 * Handle call-comment
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
class Call_Comment_Class extends \eoxia\Comment_Class {

	/**
	 * Model name @see ../model/*.model.php.
	 *
	 * @var string
	 */
	protected $model_name = '\starter\Call_Comment_Model';

	/**
	 * Post type
	 *
	 * @var string
	 */
	protected $type = 'call_comment';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = 'call_comment';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'call_comment';
}

Call_Comment_Class::g();
