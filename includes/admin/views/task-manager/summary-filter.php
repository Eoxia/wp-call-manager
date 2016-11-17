<?php
/**
 * [FR]  Page répertoriant les ajouts et les actions des boutons Call & Blame.
 * [ENG] This Php file contain adds and actions for buttons Call & Blame.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<li class='temp'> <?php esc_html_e( "Nombre d'appel", 'call-manager.php' ); ?> : <strong> <?php echo esc_html( $number_call ); ?> </strong></li>
<li class='temp'> <?php esc_html_e( 'Nombre de blame', 'call-manager.php' ); ?> : <strong> <?php echo esc_html( $number_blame ); ?> </strong></li>
<?php
