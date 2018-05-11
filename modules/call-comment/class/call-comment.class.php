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

namespace call_manager;

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
	protected $model_name = '\call_manager\Call_Comment_Model';

	/**
	 * Post type
	 *
	 * @var string
	 */
	protected $type = 'call-comment';
	/**
	 * Post data
	 *
	 * @var string
	 */
	protected $data = 'call-comment';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = 'call-comment';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'call-comment';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $version = '0.1.0';

}
Call_Comment_Class::g();
