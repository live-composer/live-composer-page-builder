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
		this.settings.cacheLastReset = values.cacheLastReset;
		this.values = {};
		this.elem = {}; /// Future container of module
		this.settingsTabs = {};
		this.files = values.files || {};
		this.dynamicHTML = values.dynamicHTML || {};

		/// Move options to its own prop
		if(this.settings.options){

			this.moduleOptions = {};

			this.settings.options.forEach(function(item_clone){

				var item = _.extend({}, item_clone);
				var section = '';
				var tabId = '';

				/// Fix option structure
				if(item.type == 'checkbox'){

					var temp = {};

					for(var i = 0, max = item.choices.length; i < max; i++){

						var tempChoice = item.choices[i];

						temp[tempChoice.value] = tempChoice;
					}

					item.choices = temp;
				}

				self.moduleOptions[item.id] = _.extend({}, item);

				if(propValues[item.id] != undefined){
					self.values[item.id] = self.moduleOptions[item.id].value = propValues[item.id];
				}

				/// Sections and tabs.
				/// Need to calculate it now to increase settings tabs render speed
				if(item.section && item.section != ''){
					section = item.section;
				}else{
					section = 'functionality';
				}

				if(!item.tab || item.tab == ''){

					if(section == 'functionality'){

						if(!self.settingsTabs[section + '__general_functionality']){

							self.settingsTabs[section + '__general_functionality'] = {
								title: 'General'
							};
						}
					}else{

						if(!self.settingsTabs[section + '__general_styling']){

							self.settingsTabs[section + '__general_styling'] = {
								title: 'General'
							};
						}
					}

					item.section = section;
					tabId = 'general_' + section;
					item.tab = tabId;

				}else{

					tabId = item.tab.toLowerCase().replace(" ", "_");

					if(!self.settingsTabs[section + "__" + tabId]){

						self.settingsTabs[section + "__" + tabId] = {
							title: item.tab
						};
					}
				}

				if(!Array.isArray(self.settingsTabs[section + "__" + tabId].elements)){

					self.settingsTabs[section + "__" + tabId].elements = [];
				}

				self.settingsTabs[section + "__" + tabId].elements.push(item.id);
			});
		}
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

		var tpl = _.template(moduleBody || "");
		var bodyHTML = tpl(renderOpts);

		/// To prevent copypaste let's create local function
		var appendBodyHTML = function()
		{
			self.moduleBody.children().remove();
			self.moduleBody.html('');
			self.moduleBody.append(bodyHTML);
		};

		var styles = "<style>" + self.generateCSS() + "</style>";
		var fillDyn = function(fillObj)
		{
			Object.keys(fillObj).forEach(function(item){
				bodyHTML = bodyHTML.replace(item, Util.b64_to_utf8(fillObj[item]));
			});
		}

		self.staticHTML = Util.utf8_to_b64( self.clearProductionHTML(bodyHTML) + styles );

		var matches = bodyHTML.match(/{{*.+}}/g); /// Dynamic parts

		/// If dynamic parts loading requested
		if(params.getDynamicParts){

			self.moduleBody.children().remove();
			var reloadDynamicWait = jQuery('<div class="dslc-notification center-text dslc-yellow">')
			.append('Waiting for server...');

			self.moduleBody.append(jQuery("<div>").append(reloadDynamicWait));

			/// Using deferred jQuery object - Deferred.done().fail()
			jQuery.post(
			    DSLCAjax.ajaxurl,
				{
					action: 'dslc-callback-request',
					dslc: 'active',
					method: 'getDynamicParts',
					params: {
						moduleId: this.moduleInfo.id,
						additional: {
							postId: self.settings.postId
						},
						functions: matches
					}
				},
				'json')
			.done(function(response)
			{
				self.dynamicHTML = _.extend({}, response);

				fillDyn(response); /// Fill dynamic parts with loaded content
				appendBodyHTML();
				self.saveEdits() /// Save dynamic parts to module's dslc_code
					.moduleBody.append(styles); /// Add some styles
				dslc_generate_code();
				dslc_show_publish_button();

				if(dslcDebug){

					console.log("Edits saved");
				}

			}).fail(function(){ fillDyn(self.dynamicHTML || {}); appendBodyHTML(); });

			return false;

		}else{

			fillDyn(self.dynamicHTML || {});
			return bodyHTML;
		}
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

		if(bodyHTML != false){ // If requested dynamic parts

			this.moduleBody.children().remove();
			this.moduleBody.html('');
			this.moduleBody.append(bodyHTML);
		}

		this.elem.before(tempWrap);
		tempWrap.append(this.elem.children());

		if(this.elem.hasClass('dslca-module-being-edited')){

			tempWrap.addClass('dslca-module-being-edited');
		}

		this.elem.remove();
		this.elem = tempWrap;
		tempWrap.data('module-instance', this);


		this.moduleBody.append("<style>" + this.generateCSS() + "</style>"); /// Add some styles
		this.recalcCentered(); /// Some magic done :)

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

		if(this.settings.dynamic_module == true && Object.keys(this.dynamicHTML).length == 0){

			var reloadDynamic = jQuery('<div class="dslc-notification center-text dslc-yellow">')
			.append(this.settings.title + ' module needs to get the latest content from WordPress  <span class="dslca-load-dynamic-data-hook dslc-icon-refresh"></span>');

			this.moduleBody = jQuery("<div>").append(reloadDynamic);
		}

		this.elem = jQuery(moduleStart + moduleEnd).append(this.moduleBody);
		this.afterRender();
		this.moduleBody.append("<style>" + this.generateCSS() + "</style>");
		this.elem.data("module-instance", this);
		this.saveEdits();

		this.recalcCentered();

		return this.elem; /// Return jQUery object
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
		var allProperties = this.getAllProperties();

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
