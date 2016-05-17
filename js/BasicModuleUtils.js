/**
 * Basic Module ported functionality and utils
 */

'use strict'; /// Prevents bad code practices

;(function(){

	jQuery(document).on('DSLC_basic_module_extend', function(){

		var $ = jQuery;
		/**
		 * Process settings tabs
		 *
		 * @param object
		 * @return null
		 */
		DSLC.BasicModule.prototype.processSettingsTabs = function( propValues )
		{
			var self = this;

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

					if(item.type == 'jsobj') return false;

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
		}

		/**
		 * Clears inset HTML from admin-typed content
		 * @return {string}
		 */
		DSLC.BasicModule.prototype.prepareStaticHTML = function( HTML )
		{
			var self = this;
			var HTML = jQuery(HTML);
			HTML.find(".lc-editor-element").remove();
			HTML.find(".dslca-editable-content").each(function()
			{
				jQuery(this)
				.removeClass('dslca-editable-content')
				.removeAttr('data-id')
				.removeAttr('data-type')
			});

			HTML.find("[contenteditable]").each(function()
			{
				jQuery(this).removeAttr('contenteditable');
			});

			HTML.find("[formattedtext]").each(function()
			{
				this.innerHTML = "{dslc_format}" + this.innerHTML + "{/dslc_format}";
			});

			var repeatsPull = {};

			HTML.find("[data-array], [data-wpquery]").each(function()
			{
				if($(this).data('array') != null){

					repeatsPull['[data-array="' + $(this).data('array') + '"]'] = 'true';
				}else{
					repeatsPull['[data-wpquery="' + $(this).data('wpquery') + '"]'] = 'true';
				}
			});

			Object.keys(repeatsPull).forEach(function(elem)
			{
				HTML.find(elem).not(":first").remove();
				// Enclose with shortcode brackets repeatable content
				HTML.find(elem).each(function()
				{
					var array = $(this).data('array') ? ' array="' + $(this).data('array') + '"' : '';
					var wpquery = $(this).data('wpquery') ? ' wpquery="' + $(this).data('wpquery') + '"' : '';

					$(this).before("[dslc-repeatable module_id='" + self.settings.id +
						 "'" + array + " " + wpquery + "]")
						.after("[/dslc-repeatable]")
						.removeAttr('data-wpquery')
						.removeAttr('data-array');
				});
			});

			//
			HTML.find("[data-array-field]").each(function()
			{
				var arField = $(this).data('array-field') ? ' array-field="' + $(this).data('array-field') + '"' : '';
				var modMethod = $(this).data('module-method') ? ' module-method="' + $(this).data('module-method') + '"' : '';
				var wpField = $(this).data('wppost-field') ? ' wppost-field="' + $(this).data('wppost-field') + '"' : '';

				$(this).html("[dslc-repeatable-prop " + arField + " " + modMethod + " " + wpField + "]")
					.removeAttr('data-array-field')
					.removeAttr('data-module-method')
					.removeAttr('data-wppost-field');
			});

			return HTML[0].outerHTML;
		}
		/**
		 * Recalculate icons and another centered stuff
		 */
		DSLC.BasicModule.prototype.recalcCentered = function()
		{
			var dslcElement, dslcContainer, dslcElementHeight, dslcContainerHeight, dslcElementWidth, dslcContainerWidth, dslcTopOffset, dslcLeftOffset;

			this.moduleBody.find('.dslc-init-center').each(function(){

				// Get elements
				dslcElement = jQuery(this);
				dslcContainer = dslcElement.parent();

				// Get height and width
				dslcElementWidth = dslcElement.outerWidth();
				dslcElementHeight = dslcElement.outerHeight();
				dslcContainerWidth = dslcContainer.width();
				dslcContainerHeight = dslcContainer.height();

				// Get center offset
				dslcTopOffset = dslcContainerHeight / 2 - dslcElementHeight / 2;
				dslcLeftOffset = dslcContainerWidth / 2 - dslcElementWidth / 2;

				// Apply offset
				if ( dslcTopOffset > 0 ) {
					dslcElement.css({ top : dslcTopOffset, left : dslcLeftOffset });
					dslcElement.css({ visibility : 'visible' });
				}

			});
		}

		/**
		 * Generates props object with all avail props and values
		 * @return {ojbect}
		 */
		DSLC.BasicModule.prototype.getAllProperties = function()
		{
			var allProperties = _.extend({}, this.moduleOptions);
			allProperties = _.extend(allProperties, this.settings);
			allProperties.base64settings = this.getEncodedSettings();

			/** Some preparings, some magic... */
			if(!allProperties.css_anim || allProperties.css_anim.value == ''){
				if(allProperties.css_anim){
					allProperties.css_anim.value = 'none';
				}
			}

			if(!allProperties.css_anim_delay || allProperties.css_anim_delay.value == ''){
				if(allProperties.css_anim_delay){
					allProperties.css_anim_delay.value = 0;
				}
			}

			if(!allProperties.css_anim_duration || allProperties.css_anim_duration.value == ''){
				if(allProperties.css_anim_duration){
					allProperties.css_anim_duration.value = 650;
				}
			}

			if(!allProperties.css_anim_easing || allProperties.css_anim_easing.value == ''){
				if(allProperties.css_anim_easing){
					allProperties.css_anim_easing.value = 'default';
				}
			}

			/// Sizes
			var class_size_output = '';

			allProperties.dslc_m_size = allProperties.dslc_m_size.value || 12;
			class_size_output += ' dslc-col dslc-' + allProperties.dslc_m_size + '-col';

			if(allProperties.dslc_m_size_last && allProperties.dslc_m_size_last.value == 'yes'){
				class_size_output += ' dslc-last-col';
			}

			/// Show on
			var class_show_on = '';
			var show_on_val = this.moduleOptions.css_show_on.value || this.moduleOptions.css_show_on.std;
			var show_on = show_on_val.trim().split(" ");

			if(show_on.indexOf('desktop') == -1){

				class_show_on += ' dslc-hide-on-desktop ';
			}

			if(show_on.indexOf('tablet') == -1){

				class_show_on += ' dslc-hide-on-tablet ';
			}

			if(show_on.indexOf('phone') == -1){

				class_show_on += ' dslc-hide-on-phone ';
			}

			/// Handle like
			if(allProperties.handle_like && allProperties.handle_like.value != undefined){

				var class_handle_like = 'dslc-module-handle-like-' + allProperties.handle_like.value;
			}else{

				var class_handle_like = 'dslc-module-handle-like-regular';
			}

			/// Module class array
			var module_class_arr = [];
			module_class_arr.push('dslc-module-front');
			module_class_arr.push('dslc-module-' + allProperties.id);
			//module_class_arr.push('dslc-in-viewport-check');
			//module_class_arr.push('dslc-in-viewport-anim-'+ (allProperties.css_anim && allProperties.css_anim.value ? allProperties.css_anim.value : 'none'));
			module_class_arr.push(class_size_output);
			module_class_arr.push(class_show_on);
			module_class_arr.push(class_handle_like);
			allProperties.module_class_arr = module_class_arr.join(' ') + (allProperties.filterDslcModuleClass || '');

			/**
			 * Suppose got
			 *
			 * allProperties.dslcModuleBefore ={HTML}
			 * allProperties.dslcModuleAfter ={HTML}
			 * allProperties.custom_css ={HTML}
			 */

			return allProperties;
		}

		/**
		 * Returns encoded module setings
		 *
		 * @return {string} base64 string
		 */
		DSLC.BasicModule.prototype.getEncodedSettings = function()
		{
			var self = this;
			if(self.settings.module_instance_id < 1) return "";

			/// Profit - manual controlling of saved options
			var propValues = _.extend({}, self.values);
			var edits = {};
			edits.propValues = propValues;
			edits.version = self.settings.version;
			edits.module_instance_id = self.settings.module_instance_id;
			edits.module_id = self.settings.id;
			edits.post_id = self.settings.postId;
			edits.dynamicHTML = _.extend({}, self.dynamicHTML);
			edits.staticHTML = self.staticHTML;
			edits.cacheLastReset = self.settings.cacheLastReset;
			edits.files = self.files;

			return Util.utf8_to_b64(JSON.stringify(edits));
		}

		/**
		 * Functions should be always fored after module rendered
		 */
		DSLC.BasicModule.prototype.afterModuleRendered = function()
		{
			var self = this;

			this.elem.data('module-instance', this);
			this.recalcCentered(); /// Some magic done :)

			this.elem.find("[contenteditable]").each(function()
			{
				var editor = new MediumEditor(this);
			});

			/// Cache preview system
			this.elem.click( function()
			{
				if( self.cacheLoaded )
				{
					self.reloadModuleBody();
					self.cacheLoaded = false;
				}
			});

			this.afterRenderHook();
		}

		/**
		 * Sets editable content
		 *
		 * @param {jQuery obj} editableField if need to, you can calculate value in reloaded method
		 */
		DSLC.BasicModule.prototype.setWYSIWIGValue = function( editableField )
		{
			var optionId = editableField.data('id');
			var content = editableField.html();

			module
				.setOption(optId, content)
				.reloadModuleBody()
				.saveEdits();
			return this;
		}

		/**
		 * Sets editable content
		 *
		 * @param {DOM obj} editableField if need to, you can calculate value in reloaded method
		 */
		DSLC.BasicModule.prototype.setContentEditableValue = function( editableField )
		{
			[].forEach.call(editableField.querySelectorAll("p"), function( p )
			{
				if ( p.innerHTML == '<br>' )
				{
					p.innerHTML = '&nbsp;';
				}
			});

			var optionId = jQuery(editableField).data('id');
			var content = editableField.innerHTML;

			this.setOption(optionId, content)
				.getModuleBody();

			this.saveEdits();

			return this;
		}

		/**
		 * Dummy afterRenderHook function. Users can describe it in custom way. Fires every time, when module renders.
		 */
		DSLC.BasicModule.prototype.afterRenderHook = function(){}

		/**
		 * Change options before render
		 *
		 * @param  {object} options
		 * @return {object}
		 */
		DSLC.BasicModule.prototype.changeOptionsBeforeRender = function(options)
		{
			return options;
		}

		/**
		 * Approve or filter option set values
		 *
		 * @param  {object} options
		 * @return {object}
		 */
		DSLC.BasicModule.prototype.filterBeforeOptionSet = function(optionId, optionValue)
		{
			return {optionValue: optionValue};
		}

		/**
		 * Generate css styles for current module
		 * @return {string}
		 */
		DSLC.BasicModule.prototype.generateCSS = function()
		{
			var settings = _.extend({},this.values);
			var css_output = '';
			var dslc_googlefonts_array = DSLC.commonOptions.dslc_googlefonts_array;
			var googlefonts_output = '';
			var regular_fonts = ["Georgia", "Times", "Arial", "Lucida Sans Unicode", "Tahoma", "Trebuchet MS", "Verdana", "Helvetica"];
			var organized_array = [];


			var important_append = '';
			var force_important /// !

			if(force_important == 'enabled'){

				important_append = ' !important';
			}


			// Go through array of options
			for(var zr in this.moduleOptions){

				var option_arr = this.moduleOptions[zr];

				// Fix for "alter_defaults" and responsive tablet state
				if(option_arr.id == 'css_res_t' && option_arr.std == 'enabled' && !settings.css_res_t){

					settings.css_res_t = 'enabled';
				}

				// Fix for "alter_defaults" and responsive phone state
				if(option_arr.id == 'css_res_p' && option_arr.std == 'enabled' && !settings.css_res_p){

					settings.css_res_p = 'enabled';
				}

				// ifoption type is done with CSS and option is set
				if(option_arr.affect_on_change_el && option_arr.affect_on_change_rule){

					// Default
					if(settings[option_arr.id] == undefined){

						settings[option_arr.id] = option_arr.std;
					}

					// Extension (px, %, em...)
					var ext = ' ';
					if(option_arr.ext){

						ext = option_arr.ext;
					}

					// Prepend
					var prepend = '';
					if(option_arr.prepend){

						prepend = option_arr.prepend;
					}

					// Append
					var append = '';
					if(option_arr.append){

						append = option_arr.append;
					}

					if(option_arr.type == 'image'){

						if(option_arr.value){

							settings[option_arr.id] = option_arr.value.url;
						}

						prepend = 'url("';
						append = '")';
					}

					// Get element and CSS rule
					var affect_rule_raw = option_arr.affect_on_change_rule;
					var affect_rules_arr = affect_rule_raw.split(',');

					// Affect Element
					var affect_el = '';
					var affect_els_arr = option_arr.affect_on_change_el.split(',');
					var count = 0;
					for( var zt in affect_els_arr){

						var affect_el_arr = affect_els_arr[zt];

						count++;
						if(count > 1){
							affect_el += ',';
						}

						if(option_arr.section && option_arr.section == 'responsive'){

							switch (option_arr.tab){
								case 'tablet':
									if(settings.css_res_t && settings.css_res_t == 'enabled'){

										affect_el += 'body.dslc-res-tablet #dslc-content #dslc-module-' + this.settings.module_instance_id + ' ' + affect_el_arr;
									}
									break;
								case 'phone':
									if(settings.css_res_p && settings.css_res_p == 'enabled'){

										affect_el += 'body.dslc-res-phone #dslc-content #dslc-module-' + this.settings.module_instance_id + ' ' + affect_el_arr;
									}
									break;
							}

						} else{
							affect_el += '#dslc-content #dslc-module-' + this.settings.module_instance_id + ' ' + affect_el_arr;
						}

					}

					// Checkbox (CSS)
					if(option_arr.type == 'checkbox' && option_arr.refresh_on_change == false){

						var checkbox_val = '';

						if(!Array.isArray(settings[option_arr.id])){

							if(settings[option_arr.id] && settings[option_arr.id] != ''){

								var checkbox_arr = settings[option_arr.id].trim().split(' ');
							}else{
								var checkbox_arr = option_arr.std.trim().split(' ');
							}
						}else{
							var checkbox_arr = settings[option_arr.id];
						}

						if(checkbox_arr.indexOf('top') > -1){

							checkbox_val += 'solid ';
						}else{

							checkbox_val += 'none ';
						}

						if(checkbox_arr.indexOf('right') > -1){

							checkbox_val += 'solid ';
						}else{

							checkbox_val += 'none ';
						}

						if(checkbox_arr.indexOf('bottom') > -1){

							checkbox_val += 'solid ';
						}else{

							checkbox_val += 'none ';
						}

						if(checkbox_arr.indexOf('left') > -1){

							checkbox_val += 'solid ';
						}else{

							checkbox_val += 'none ';
						}

						settings[option_arr.id] = checkbox_val;
					}

					// Colors (transparent ifempy)
					if(settings[option_arr.id] == '' && (option_arr.affect_on_change_rule == 'background' || option_arr.affect_on_change_rule == 'background-color')){

						settings[option_arr.id] = 'transparent';
					}

					for(var it in affect_rules_arr){

						var affect_rule = affect_rules_arr[it];

						if(typeof organized_array[affect_el] != 'object'){

							organized_array[affect_el] = {};
						}

						organized_array[affect_el][affect_rule] = prepend + settings[option_arr.id] + ext + append;
					}
				}
			}

			if(Object.keys(organized_array).length > 0){

				for(var el in organized_array){

					var rules = organized_array[el];
					css_output += el + '{ ';

					for(var rule in rules){

						var value = rules[rule];

						if( rule != '' && value.trim() != '' && value.trim() != 'url(" ")'){

							css_output += rule + ' : ' + value + important_append + '; ';
						}
					}

					css_output += ' } ';
				}
			}

			return css_output;
		}

		/**
		 * Renders module settings in foot part of site
		 *
		 * @return {Object}	 object with module options HTML
		 */
		DSLC.BasicModule.prototype.renderSettings = function()
		{
			var out = {};
			out.tabs = "";
			out.fields = "";
			var self = this;
			var tabs = {};
			var tempFieldsSorted = {};


			/// Go through all options
			Object.keys(this.moduleOptions).map(function(key){

				var item = _.extend({}, self.moduleOptions[key]);
				var section = '';
				var tabId = '';

				/// Sections and tabs
				if(item.section && item.section != ''){
					section = item.section;
				}else{
					section = 'functionality';
				}

				if(!item.tab || item.tab == ''){

					if(section == 'functionality'){
						tabs['general_functionality'] = {
							title: 'General',
							id: 'general_functionality',
							section: section
						};
					}else{
						tabs['general_styling'] = {
							title: 'General',
							id: 'general_styling',
							section: section
						};
					}

					item.section = section;
					tabId = 'general_' + section;
					item.tab = tabId;

				}else{

					tabId = item.tab.toLowerCase().replace(" ", "_");

					if(!tabs[tabId]){
						tabs[tabId] = {
							'title': item.tab,
							'id': tabId,
							'section': section
						};
					}
				}

				if(typeof tempFieldsSorted[item.section] != 'object'){

					tempFieldsSorted[item.section] = {};
				}

				if(!Array.isArray(tempFieldsSorted[item.section][tabId])){

					tempFieldsSorted[item.section][tabId] = [];
				}
			});

			var sections = {};

			for(var zi in tabs){
				var temp = tabs[zi];

				if(typeof sections[temp.section] != 'object'){

					sections[temp.section] = {};
				}

				sections[temp.section][temp.id] = temp;
			}

			for(var io in sections){

				var tabs = sections[io];
				out.tabs += "<div class='tab-filter-container tab-filter-container-" + io + "' data-section='" + io + "'>";

				for(var zt in tabs){

					var curTab = tabs[zt];

					out.tabs += '<span class="dslca-module-edit-options-tab-hook" data-section="' +
					 curTab.section + '" data-id="' + curTab.id + '">' + curTab.title + '</span>';
				}

				out.tabs += "</div>";
			}

			for(var sectionId in tempFieldsSorted){

				var tab = tempFieldsSorted[sectionId];
				out.fields += "<div class='filter-options-container filter-options-container-" + sectionId + "'>";

				for(var tabId in tab){

					out.fields += "<div class='tab-filter-options-container tab-filter-options-container-" + sectionId + "__" + tabId + "'>";
					out.fields += "</div>";
				}

				out.fields += "</div>";
			}

			return out;
		}

		/**
		 * Renders current tab options
		 *
		 * @param  {string} tabId
		 * @return {string}
		 */
		DSLC.BasicModule.prototype.renderSettingsTab = function(tabId)
		{
			var self = this;
			var out = ''; // Outer HTML variable
			var tabElements = self.settingsTabs[tabId].elements;

			/// Render setting body
			tabElements.forEach(function(item){

				var item = _.extend({}, self.moduleOptions[item]);

				var optionHTML = self.optionsTemplates[item.type];
				var tpl = _.template(optionHTML);

				/// Filter option object
				if(typeof self.settingsRendererFilter[item.type + 'Before'] == 'function'){

					item = self.settingsRendererFilter[item.type + 'Before'](item);
				}

				item.section = item.section || "functionality";
				item.tab = item.tab || "general_functionality";

				optionHTML = tpl(item);

				/// Render setting wrap
				var optionHTMLStart = self.optionsTemplates['module-setting-start'];
				var tpl = _.template(optionHTMLStart);
				optionHTMLStart = tpl(_.extend({}, item));

				optionHTML = optionHTMLStart + optionHTML + "</div>";

				out += optionHTML;
			});

			return out;
		}

		/**
		 * Gets option value, that will render on front
		 *
		 * @param {string} optionId
		 */
		DSLC.BasicModule.prototype.getOption = function(optionId)
		{
			if(!this.moduleOptions[optionId]) return false;

			var val = undefined;

			if(this.values[optionId] != undefined){

				val = this.values[optionId];
			}else{

				val = this.moduleOptions[optionId].std;
			}

			if( Array.isArray( val ) ){

				return _.deepExtend( [], val );

			}else if( typeof val == 'object' ){

				return _.deepExtend( {}, val );
			}else{

				return val || false;
				}
		}

		/**
		 * Sets option value
		 *
		 * @param {string} optionId
		 * @param {string} optionValue
		 */
		DSLC.BasicModule.prototype.setOption = function(optionId, optionValue)
		{
			/// Incapsulation for optionValue
			if( Array.isArray( optionValue ) ){

				optionValue = _.deepExtend( [], optionValue );

			}else if( typeof optionValue == 'object' ){

				optionValue = _.deepExtend( {}, optionValue );
			}

			var self = this;
			function fireEvent()
			{
				/// Hook system in work. Fire an event when set some option value
				DSLC.Mediator.publish('DSLC_setOptionValue',
				{
					module: self,
					value: optionValue,
					optionId: optionId
				});
			}
			var optApprove = this.filterBeforeOptionSet(optionId, optionValue);

			if(typeof optApprove != 'object') return this;

			optionValue = optApprove.optionValue;

			/// All dances around fire & crutches about migration from 1.0 to 1.5 & higher
			if(this.moduleOptions[optionId] && this.moduleOptions[optionId].type == 'checkbox' && optionValue.trim().split(" ").length == 1){

				var choices = this.moduleOptions[optionId].choices;

				if(this.moduleOptions[optionId] && choices && choices[optionValue]){
					choices[optionValue].checked = !choices[optionValue].checked;
				}

				var values = [];

				for(var zt in choices){

					var temp = choices[zt];
					if(temp.checked){
						values.push(zt);
					}
				}

				this.values[optionId] = values.join(' ');
				this.moduleOptions[optionId].value = values.join(' ');
				fireEvent();

				return this;
			}

			if(typeof optionValue == 'object' && this.moduleOptions[optionId] && this.moduleOptions[optionId].type == 'image'){

				if(!this.files) this.files = {};
				this.files[optionId] = optionValue.url;
			}

			/// Simple option saving
			this.moduleOptions[optionId].value = this.values[optionId] = optionValue;
			fireEvent();

			return this;
		}

		/**
		 * Settings renderer filter
		 * Contains additional rules and conditions for settings render
		 */
		DSLC.BasicModule.prototype.settingsRendererFilter = {
			sliderBefore: function(item)
			{
				item.slider_min = item.min ? item.min : 0;
				item.slider_max = item.max ? item.max : 100;
				item.slider_increment = item.increment ? item.increment : 1;

				var num_opt_type = DSLC.commonOptions.lc_numeric_opt_type__dslc_plugin_options_other;
				item.numeric_option_type = num_opt_type && num_opt_type != '' ? num_opt_type : 'slider';

				return item;
			},
			text_alignBefore: function(item)
			{
				item.value = item.value && item.value != '' ? item.value : item.std;

				return item;
			},
			box_shadowBefore: function(item)
			{
				var value = item.value || item.std;

				if(!Array.isArray(value)){

					item.value = value.split(' ');
				}

				return item;
			},
			text_shadowBefore: function(item)
			{
				var value = item.value || item.std;

				if(!Array.isArray(value)){

					item.value = value.split(' ');
				}

				return item;
			},
			selectBefore: function(item)
			{
				item.value = item.value || item.std;

				return item;
			},
			imageBefore: function(item)
			{
				item.value = item.value || item.std;

				if(typeof item.value == 'object' ){

					item.value.filename = Util.basename(item.value.url);
				}

				return item;
			},
			checkboxBefore: function(item)
			{
				// Current Value Array
				var value = typeof item.value == 'undefined' ? item.std : item.value;

				for(var zt in item.choices){

					var choice = item.choices[zt];

					if(value.indexOf(choice.value) > -1){

						choice.checked = true;
					}else{
						choice.checked = false;
					}
				}

				// Determined brakepoints
				item.chck_amount = Object.keys(item.choices).length;
				item.chck_breakpoint = Math.ceil(item.chck_amount/1);
				item.chck_count = 0;

				return item;
			}
		}
	});
}());