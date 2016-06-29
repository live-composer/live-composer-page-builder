/**
 * Custom utils
 */

'use strict';

var Util = {
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
	utf8_to_b64: function(t){
        if(Modernizr && Modernizr.atobbtoa){
            return window.btoa(unescape(encodeURIComponent(t)));
        }else{
            if(Base64 && Base64.encode)
            return Base64.encode(unescape(encodeURIComponent(t)));
        }

		return false;
    },

    /**
     * Converts base64 to UTF-8
     *
     * @param  {string} t in b64
     * @return {string}   in utf-8
     */
    b64_to_utf8: function(t)
    {
        if(Modernizr && Modernizr.atobbtoa){
            return decodeURIComponent(escape(window.atob(t)));
        }else{
            if(Base64 && Base64.decode)
            return decodeURIComponent(escape(Base64.decode(t)));
        }

        return false;
    }
};