<?php
/**
 * Class of my_handle module.
 *
 * @author You <you@mail>
 * @since 0.1.0
 * @version 0.1.0
 * @copyright 2017+
 * @package test_eo_model
 */

namespace call_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class of my_product controlleur.
 */
class My_Category_Class extends \eoxia\Term_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\call_manager\My_Category_Model'; // \your_namespace\My_Product_Model if you got a namespace.

	/**
	 * Le type du post ou du commentaire ou du term.
	 *
	 * @var string
	 */
	protected $type = 'my-category';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = 'my-category';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'my-category';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

}

My_Category_Class::g();
