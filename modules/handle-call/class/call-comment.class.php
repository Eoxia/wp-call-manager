<?php
/**
 * Class call-comment
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
 * Class call-comment
 */
class Call_Comment_Class extends \eoxia\Comment_Class {

	/**
	 * Nom du model
	 *
	 * @var string
	 */
	protected $model_name = '\call_manager\Call_Comment_Model';

	/**
	 * Le type du post ou du commentaire ou du term.
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
