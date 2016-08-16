/**
 * Custom utils
 */

'use strict';

LiveComposer.Utils = {
	addslashes: function(str)
	{
		 str = str.replace(/\\/g, '\\\\');
		 str = str.replace(/\'/g, '\\\'');
		 str = str.replace(/\"/g, '\\"');
		 str = str.replace(/\0/g, '\\0');
		 return str;
	},

	basename: function(path)
	{
		return path.split(/[\\/]/).pop();
	},

	/**
	 * Check if browser is IE
	 */
	msieversion: function() {

	    var ua = window.navigator.userAgent;
	    var msie = ua.indexOf("MSIE ");

	    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
	    {
	        return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
	    }
	    else  // If another browser, return 0
	    {
	        return false;
	    }
	},

	/**
	 * Check if variables in array is desired types
	 * @param  {array} array
	 * @return {boolean}
	 */
	checkParams: function(array)
	{
		if(!Array.isArray(array))
		{
			throw ('Param is not array');
		}

		/// Instead of switch construction
		var types = {
			integer: function(param)
			{
				return isNaN(parseInt(param));
			},
			float: function(param)
			{
				return isNaN(parseFloat(param));
			},
			string: function(param)
			{
				return param != null && param != undefined && typeof param == 'string';
			},
			array: function(param)
			{
				return Array.isArray(param);
			},
			object: function(param)
			{
				return typeof param == 'object';
			}
		}

		/// Check it!
		array.map(function(item){
			if(!types[item[1]](item[0])){
				throw('Param ' + item[0] + ' is not ' + item[1]);
			}
		});
	},

	/**
	 * Converts UTF-8 to base64
	 *
	 * @param  {string} t utf-8
	 * @return {string}   b64
	 */
	utf8_to_b64: function(t) {

		return window.btoa(unescape(encodeURIComponent(t)));

	 },

	 /**
	  * Converts base64 to UTF-8
	  *
	  * @param  {string} str in b64
	  * @return {string}   in utf-8
	  */
	 b64_to_utf8: function(str) {

		return decodeURIComponent(escape(window.atob(str)));

	 },

	 /**
	  * Get Page Params
	  *
	  * @return {array}
	  */
	 get_page_params: function()
	 {
		return decodeURIComponent(window.location.search.slice(1)).split('&').reduce(function _reduce ( a, b) { b = b.split('='); a[b[0]] = b[1]; return a; }, {});
	 },

	get_unique_id: function() {
		return Math.random().toString(32).slice(2);
	},

	encode: function (code) {
		// Serialize
		code = dslc_serialize( code );

		// Encode
		code = LiveComposer.Utils.utf8_to_b64( code );

		return code;
	},

	decode: function (code) {

		// Decode base64 to utf8
		code = LiveComposer.Utils.b64_to_utf8( code );

		// Unserialize decoded code into the object
		code = dslc_unserialize( code );

		return code;
	},

	/**
	 * Update module option in raw base64 code (dslc_code) of the module
	 *
	 * @param  {DOM element} module    Module Element
	 * @param  {string} property_name  Name of the option we change
	 * @param  {string} property_value Value of the option we change
	 * @return {void}
	 */
	update_module_property_raw: function (module, property_name, property_value ) {

		// Hidden textarea element with raw base64 code of the module
		// <textarea class="dslca-module-code">YTo2On....iOjE7fQ==</textarea>
		var module_code_container = module.getElementsByClassName('dslca-module-code')[0];

		// Hidden textarea element with value of this particular setting
		// <textarea data-id="property_name">property_value</textarea>
		var property_container = module.querySelector( '.dslca-module-option-front[data-id="' + property_name + '"]' );

		// Get module raw code
		var module_code = module_code_container.value;

	 	// Decode
		module_code = LiveComposer.Utils.decode( module_code );

		// Change module property
		module_code[property_name] = property_value;

		// Encode
		module_code = LiveComposer.Utils.encode( module_code );

		// Update raw code
		module_code_container.value = module_code;
		module_code_container.innerHTML = module_code; // See comment block below

		// Change the property in hidden textarea as well
		property_container.value = property_value;
		property_container.innerHTML  = property_value; // See comment block below

		/**
		 * FireFox will not duplicate textarea value properly using .cloneNode(true)
		 * if we don't use .innerHTML statement (Chrome works fine with .value only).
		 *
		 * See bug report: https://bugzilla.mozilla.org/show_bug.cgi?id=237783
		 */
	},

	/**
	 * Provide custom events publish
	 *
	 * @param  {string} eventName
	 * @param  {object||string||null||numeric} eventData [description]
	 */
	publish: function( eventName, eventData ) {

		eventData = eventData ? eventData : {};

		this.checkParams( [
			[eventName, 'string'],
			[eventData, 'object']
		] );

		jQuery.event.trigger( {
			type: eventName,
			message: {details: eventData}
		} );
	}
};
