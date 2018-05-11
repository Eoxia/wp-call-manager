<?php
/**
 * Class of handle_call.
 *
 * @author You <you@mail>
 * @since 2.0.0
 * @version 2.0.0
 * @copyright 2018+
 * @package call_manger
 */

namespace call_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class of my_product controlleur.
 */
class Handle_Call_Class extends \eoxia\Singleton_Util {
	/**
	 * Tableau du status .
	 *
	 * @var string $four_category.
	 */
	// protected $array = array(
	// 		'traité',
	// 		'rappelera',
	// 		'a-rappeler',
	// 		'transferer',
	// 	);
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\call_manager\Handle_Call_Class'; // \your_namespace\My_Product_Model if you got a namespace.

	/**
	 * Le type du post ou du commentaire ou du term.
	 *
	 * @var string
	 */
	protected $type = 'handle-call';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = 'handle_call';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'handle-call';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';
	/**
	 * Construct .
	 */
	protected function construct() {
	}
	/**
	 * Get .
	 */
	public function get() {
		// Définition du Tableau.
		$four_categorys = array(
			'slug1' => __( 'traité', 'call_manger' ),
			'slug2' => __( 'rappelera' ),
			'slug3' => __( 'a-rappeler' ),
			'slug4' => __( 'transferer' ),
		);
		return $four_categorys;
	}

}

Handle_Call_Class::g();
