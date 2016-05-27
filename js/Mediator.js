/**
 * Mediator for Mediator-Module architechture and in the same time - start point for 1.5 Modules init.
 */

'use strict';

var DSLC = {
	Mediator: {}, /// Mediator class
	BasicModule: {}, /// Basic Module class
	ModulesManager: {
		ModulesInfo: {},
		AvailModules: {},
		ActiveModules: {}
	},
	optionFieldUtils: {},
	commonOptions: {},
	commonVars: {}, /// Save here global variables
};

//Object.defineProperty(DSLC, 'i18n',)

var commonVars = DSLC.commonVars; /// Just alias

;(function(){

	/**
	 * Mediator singleton
	 *
	 * @type {Object}
	 */
	var Mediator = {
		/**
		 * Provide custom events publish
		 *
		 * @param  {string} eventName
		 * @param  {object||string||null||numeric} eventData [description]
		 */
		publish: function( eventName, eventData ) {

			eventData = eventData ? eventData : {};

			Util.checkParams( [
				[eventName, 'string'],
				[eventData, 'object']
			] );

			jQuery.event.trigger( {
				type: eventName,
				message: {details: eventData}
			} );
		}
	};

	/**
	 * Creates module
	 *
	 * @param {int} moduleId
	 * @param {jQuery} renderTo jQuery module holder
	 */
	DSLC.ModulesManager.CreateModule = function( moduleId, renderTo )
	{
		var modulesArea = renderTo; /// It used in original code - let's save old names
		var newModule = new DSLC.ModulesManager.AvailModules[moduleId](); /// Create new instance

		/// Generate new module id
		var newId = new Date().getTime();
		newModule.settings.module_instance_id = newId;

		DSLC.ModulesManager.ActiveModules[newId] = newModule; /// Add module to Active Modules stack

		// Remove extra padding from area
		modulesArea.css( {paddingBottom : 0} );

		// Hide loader
		jQuery( '.dslca-module-loading', modulesArea ).hide();

		// Add output
		var moduleElem = newModule.renderModule();
		var dslcJustAdded = modulesArea.append( moduleElem );

		// moduleElem.css({
		// 	'-webkit-animation-name' : 'dslcBounceIn',
		// 	'-moz-animation-name' : 'dslcBounceIn',
		// 	'animation-name' : 'dslcBounceIn',
		// 	'animation-duration' : '0.6s',
		// 	'-webkit-animation-duration' : '0.6s'
		//});

		/// This operations taking a lot of time, so let it be async from main process
		setTimeout( function()
		{
			dslc_init_square();
			dslc_center();
			dslc_masonry( dslcJustAdded );
			jQuery( 'body' ).removeClass( 'dslca-anim-in-progress dslca-module-drop-in-progress' );
		}, 700 );

		// "Show" no content text
		jQuery( '.dslca-no-content-primary', modulesArea ).css( {opacity : 1} );

		// "Show" modules area management
		jQuery( '.dslca-modules-area-manage', modulesArea ).css ( {visibility : 'visible'} );

		// Show publish
		jQuery( '.dslca-save-composer-hook' ).css( {'visibility' : 'visible'} );
		jQuery( '.dslca-save-draft-composer-hook' ).css( {'visibility' : 'visible'} );

		// Generate
		dslc_carousel();
		//dslc_tabs();
		dslc_init_square();
		dslc_center();
		dslc_generate_code();
		dslc_show_publish_button();

		newModule.afterModuleRendered();

		return newModule;
	}

	/**
	 * Remoes module
	 * @param  {object} module - module class object
	 */
	DSLC.ModulesManager.removeModule = function( module )
	{
		module.elem.fadeOut( 300, function()
		{
			module.elem.remove();
			delete DSLC.ModulesManager.ActiveModules[module.settings.module_instance_id];
		});
	}

	/**
	 * Load saved modules in Editor Mode
	 */
	DSLC.ModulesManager.loadEMModules = function()
	{
		jQuery( ".module-init-block" ).each( function()
		{
			var moduleSettings = JSON.parse( Util.b64_to_utf8( this.innerHTML.trim() ) );

			var newModule = new DSLC.ModulesManager.AvailModules[moduleSettings.module_id]( moduleSettings );
			var moduleElem = newModule.renderModule();

			DSLC.ModulesManager.ActiveModules[moduleSettings.module_instance_id] = newModule;
			jQuery( this ).after( moduleElem );
			jQuery( this ).remove();
			newModule.afterModuleRendered();

			if( newModule.elem[0].innerText.match(/\[.*?\]/) && jQuery(".dslc-cached-version").find( "#dslc-module-" + newModule.settings.module_instance_id ).length > 0 )
			{
				newModule.moduleBody.html( jQuery(".dslc-cached-version").find( "#dslc-module-" + newModule.settings.module_instance_id ).children() );
				newModule.cacheLoaded = true;
			}

			jQuery(".dslc-cached-version").children().remove();
			jQuery(".dslc-cached-version").empty();
		});
	}

	/**
	 * Copies module from current module
	 */
	DSLC.ModulesManager.copyModule = function( moduleInstance )
	{
		var moduleSettings = JSON.parse(
		    Util.b64_to_utf8(
				moduleInstance.getEncodedSettings()
			) );

		var newModule = new DSLC.ModulesManager.AvailModules[moduleSettings.module_id]( moduleSettings );

		/// Generate new module id
		var newId = new Date().getTime();
		newModule.settings.module_instance_id = newId;

		var moduleElem = newModule.renderModule();

		DSLC.ModulesManager.ActiveModules[newId] = newModule;
		jQuery( moduleInstance.elem ).after( moduleElem );

		dslc_generate_code();
		dslc_show_publish_button();
	}

	window.DSLC.Mediator = Mediator;
}());

/// Programm start point
jQuery( function( $ ) {

	DSLC.Mediator.publish( 'DSLC_preload' ); /// loads Basic Module and other staff scripts
	DSLC.Mediator.publish( 'DSLC_basic_module_extend' ); /// Extend basic module
	DSLC.Mediator.publish( 'DSLC_init_modules_classes' ); /// inits modules classes
	DSLC.Mediator.publish( 'DSLC_extend_modules' ); /// extend modules with custom scripts

	DSLC.ModulesManager.loadEMModules();
});

