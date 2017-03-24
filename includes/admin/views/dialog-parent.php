<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du bouton Recall.
 * [ENG] This Php file contain a div for button Recall's pop-up.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="dialog-recall" title="<?php esc_html_e( 'Personne voulant vous contacter', 'phonecall' ); ?>" class="hidden" >
	<table border="1" cellspacing="0" cellpadding="5" style="text-align: center; table-layout: fixed;">
	<?php include( plugin_dir_path( __FILE__ ) . 'dialog-child.php' ); ?>
	</table>
</div>
