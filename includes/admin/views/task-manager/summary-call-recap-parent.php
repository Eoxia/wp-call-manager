<?php
/**
 * [FR]  Page ajoutant la div contenant le dialog du call-recap dans chronologie de task-maanger.
 * [ENG] This Php file contain a div for the call-recap's pop-up from Chronology in task-maanger.
 *
 * @package WordPress.
 * @subpackage Call & Blame.
 */

?>
<div id="cm-summary-call-recap-<?php echo esc_attr( $user_id . $year . $month . $day ); ?>" class="hidden pop-up"
<?php
if ( null !== $day ) {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes qui vous ont contacté ce jour-là' , 'call-manager' ) ?>" <?php
} else {
	?> title="<?php esc_attr_e( 'Voici la liste des personnes qui vous ont contacté ce mois-ci' , 'call-manager' ) ?>" <?php
}
?>
>
	<table border="1" cellspacing="0" cellpadding="5" style="text-align: center; table-layout: fixed; margin: 0 auto;">
		<?php
		if ( $data_recall_comment_count > 0 ) {
			$cm_array = $array_recall_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		if ( $array_will_recall_comment > 0 ) {
			$cm_array = $array_will_recall_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		if ( $data_treated_comment_count > 0 ) {
			$cm_array = $array_treated_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		if ( $array_transfered_comment > 0 ) {
			$cm_array = $array_transfered_comment;
			include( plugin_dir_path( __FILE__ ) . 'summary-call-recap-child.php' );
		}
		?>
		<pre>
			<?php echo esc_html( 'Vous avez reçu ' . $number_call . ' appels et renseigné ' . $data_self_comment_count . ', traité ' . $data_treated_comment_count . ', ' . $data_transfered_comment_count . ' vous ont été transférés, vous devez en rappeler ' . $data_recall_comment_count . ' et ' . $data_will_recall_comment_count . ' doivent vous rappeler.' ); ?>
		</pre>
	</table>
</div>
<?php
