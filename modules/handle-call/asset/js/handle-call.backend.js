/**
 * Initialise l'objet helloWorld dans le namespace eoFrameworkStarter.
 * Permet d'éviter les conflits entre les différents plugins utilisant EO-Framework.
 *
 * Ce fichier JS est une base pour utiliser du JS avec EO-Framework.
 * En lançant la commande "npm start", GULP vas écouter les fichiers *.backend.js et
 * vas s'occuper de les assembler dans le fichier backend.min.js.
 *
 * EO-Framework appel automatiquement la méthode "init" à l'initilisation de certains *pages*
 * du backadmin de WordPress. Ces pages doivent être définis dans le tableau "insert_scripts_page" dans le fichier *.config.json
 * principales de votre plugin.
 * @see https://github.com/Eoxia/task-manager/blob/master/task-manager.config.json pour un exemple
 *
 * @since 0.1.0
 * @version 0.1.0
 */
window.eoxiaJS.callManager.handleCall = {};

/**
 * La méthode "init" est appelé automatiquement par la lib JS de Eo-Framework
 *
 * @since 0.1.0
 * @version 0.1.0
 *
 * @return {void}
 */
window.eoxiaJS.callManager.handleCall.init = function() {
	jQuery( document ).on( 'click', '.id_administrator', window.eoxiaJS.callManager.handleCall.selectUser );
	jQuery( document ).on( 'click', '#btn-status', window.eoxiaJS.callManager.handleCall.selectStatus );
	jQuery( document ).on( 'click', 'li.autocomplete-result', window.eoxiaJS.callManager.handleCall.selectCustomers );
	jQuery( document ).on( 'click', 'span.ajou_client', window.eoxiaJS.callManager.handleCall.newCustomers );
};

window.eoxiaJS.callManager.handleCall.selectUser = function() {
	var dataId = jQuery( this ).attr( 'data-id' );
	jQuery( 'li.active' ).removeClass( 'active button-main' );
	jQuery( this ).addClass( 'active button-main' );
	jQuery( '#hook_jquery1' ).attr( 'value', dataId );
};

window.eoxiaJS.callManager.handleCall.selectStatus = function() {
	var status = jQuery( this ).attr( 'value' );
	jQuery( '#btn-status.button-main' ).toggleClass( 'button-main button-secondary' );
	jQuery( this ).addClass( 'button-main' );
	jQuery( this ).removeClass( 'button-secondary' );
	jQuery( '#hook_jquery2' ).attr( 'value', status );
};

window.eoxiaJS.callManager.handleCall.selectCustomers = function() {
	var custumName = jQuery( this ).attr( 'data-result' );
	var dataId = jQuery( this ).attr( 'data-id' );
	jQuery( '#mon-autocomplete' ).attr( 'value', custumName );
	jQuery( this ).closest( 'div.wpeo-autocomplete' ).removeClass( 'autocomplete-active' );
	jQuery( '#id_cust' ).attr( 'value', dataId );
};

window.eoxiaJS.callManager.handleCall.newCustomers = function() {
	jQuery( '#erf' ).css( 'display', 'block' );
};
