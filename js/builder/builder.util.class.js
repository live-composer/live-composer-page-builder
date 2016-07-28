/**
 * Custom utils
 */

'use strict';

var DSLC_Util = {
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
		code = DSLC_Util.utf8_to_b64( code );

		return code;
	},

	decode: function (code) {

		// Decode base64 to utf8
		code = DSLC_Util.b64_to_utf8( code );

		// Unserialize decoded code into the object
		code = dslc_unserialize( code );

		return code;
	},



};