/**
 * Basic Module Class file
 */

'use strict';

;(function(){

	/**
	 * Basic Module objct constuctor
	 * @param {obj} values
	 */
	function BasicModule(values)
	{
		values = values || {};

		var propValues = values.propValues || {};
		var self = this;

		/// Init module props
		this.settings = _.extend({}, this.moduleInfo);
		self.settings.module_instance_id = values.module_instance_id || 0;
		this.settings.postId = DSLC && DSLC.currPostId > 0 ? DSLC.currPostId : 0;
		this.values = {};
		this.elem = {}; /// Future container of module
		this.settingsTabs = {};
		this.files = values.files || {};
		this.cacheLoaded = false;

		this.processSettingsTabs( propValues );
	};

	/**
	 * Renders Module Body
	 *
	 * @return {string} module body in HTML
	 */
	BasicModule.prototype.getModuleBody = function(params)
	{
		params = typeof params == 'object' ? params : {};
		var self = this;
		var opts = _.extend({}, this.moduleOptions); /// opts has NOT to be an anchor to moduleOptions

		opts.dslc_admin = true;
		opts.dslc_active = true;

		var renderOpts = this.changeOptionsBeforeRender(opts); /// Prepare options - custom function if got
		var moduleBody = this.moduleTemplate; /// Module underscore template

		/// render static HTML

		if(moduleBody == undefined || !moduleBody){
			console.info(this.settings.id + " template wasn't loaded");
		}

		var tpl = _.template( moduleBody || "" );
		var bodyHTML = tpl( renderOpts );
		var styles = "<style>" + self.generateCSS() + "</style>";

		self.staticHTML = Util.utf8_to_b64( self.prepareStaticHTML( bodyHTML ) + styles );

		return bodyHTML + styles;
	}

	/**
	 * Reloads module body (when some option changed)
	 */
	BasicModule.prototype.reloadModuleBody = function(params)
	{
		params = typeof params == 'object' ? params : {}; // Default params
		var bodyHTML = this.getModuleBody(params);

		var tempWrap = jQuery(this.getModuleStart() + this.getModuleEnd());
		tempWrap.children().remove();

		this.elem.before(tempWrap);
		tempWrap.append(this.elem.children());

		if(this.elem.hasClass('dslca-module-being-edited')){

			tempWrap.addClass('dslca-module-being-edited');
		}

		this.moduleBody.children().remove();
		this.moduleBody.html('');

		this.moduleBody.append( bodyHTML );
		this.elem.remove();
		this.elem = tempWrap;
		this.afterModuleRendered();

		if(dslcDebug){

			console.log("Body reloaded");
		}

		return this;
	}

	/**
	 * Renders module on front (in EM) (first render)
	 *
	 * @return {jQuery} module presenter in jQuery object
	 */
	BasicModule.prototype.renderModule = function()
	{
		var moduleStart = this.getModuleStart(); /// Start HTML
		var moduleEnd = this.getModuleEnd(); /// End HTMl

		this.moduleBody = jQuery("<div>").append(this.getModuleBody()); /// Load module body

		this.elem = jQuery(moduleStart + moduleEnd).append(this.moduleBody);
		this.saveEdits();

		return this.elem; /// Return jQuery object
	}

	/**
	 * Returns rendered module HTML end
	 *
	 * @return {string} end HTML
	 */
	BasicModule.prototype.getModuleEnd = function()
	{
		var allProperties = this.getAllProperties(); /// Get processed properties with default values

		var moduleEnd = this.optionsTemplates['module-end'];

		/// Render end
		var tpl = _.template(moduleEnd);
		return tpl(allProperties);
	}

	/**
	 * Returns rendered module HTML start
	 *
	 * @return {string} start HTML
	 */
	BasicModule.prototype.getModuleStart = function()
	{
		var allProperties = this.getAllProperties(); /// Get processed properties with default valueы

		var moduleStart = this.optionsTemplates['module-start'];

		/// Render start
		var tpl = _.template(moduleStart);
		return tpl(allProperties);
	}

	/**
	 * Save changes
	 *
	 * @return {promise}
	 */
	BasicModule.prototype.saveEdits = function()
	{
		this.elem.find(".dslca-module-code").html(this.getEncodedSettings()); /// Insert into initial code field b64-coded module settings
		return this;
	}

	/// Fires on DSLC_preload. Loads into prototype links to all templates
	jQuery(document).on('DSLC_preload', function(){

		var types = {};

		/// Process every option type
		jQuery(".dslc-options-templates ").children().each(function(){
			var typeId = this.id.replace("option-type-", "");

			types[typeId] = this.innerHTML;
		}).remove();

		BasicModule.prototype.optionsTemplates = types;

		window.DSLC.BasicModule = BasicModule;
	});
}());
