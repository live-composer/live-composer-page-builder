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
    },
    /**
     * Adds br's to simpleText
     *
     * @param  {string} simpleText
     * @return {string}
     */
   	wpautopCutted: function(simpleText)
   	{
   		return simpleText.replace(/\n/i,'<br>');
   	},
   	wpautop: function(pee, br)
   	{
		if(typeof(br) === 'undefined') {
			br = true;
		}

		var pre_tags = [];

		if(pee.trim() === ''){
			return '';
		}

		function _autop_newline_preservation_helper(matches)
		{
		    return matches.replace( "\n", "<WPPreserveNewline />");
		}

		pee = pee + "\n"; // just to make things a little easier, pad the end

		if(pee.indexOf('<pre') > -1){

			var pee_parts = pee.split('</pre>');
			var last_pee = pee_parts.pop();
			pee = '';

			pee_parts.forEach(function(pee_part, index)
			{
				var start = pee_part.indexOf('<pre');

				// Malformed html?
				if ( start === -1 ) {
					pee += pee_part;
					return;
				}

				var name = "<pre wp-pre-tag-" + index + "></pre>";
				pre_tags[name] = pee_part.slice(start) + '</pre>';
				pee += pee_part.substr(0, start) + name;

			});

			pee += last_pee;
		}

		pee = pee.replace(/<br \/>\s*<br \/>/, "\n\n");

		// Space things out a little
		var allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		pee = pee.replace( new RegExp('(<' + allblocks + '[^>]*>)', 'gmi'), "\n$1");
		pee = pee.replace( new RegExp('(</' + allblocks + '>)', 'gmi'), "$1\n\n");
		pee = pee.replace(/\r\n|\r/i, "\n"); // cross-platform newlines

		if(pee.indexOf('<option') > -1){

			// no P/BR around option
			pee = pee.replace(/\s*<option'/gmi, '<option');
			pee = pee.replace(/<\/option>\s*/gmi, '</option>');
		}

		if(pee.indexOf('</object>') > -1){

			// no P/BR around param and embed
			pee = pee.replace( /(<object[^>]*>)\s*/gmi, '$1');
			pee = pee.replace( /\s*<\/object>/gmi, '</object>' );
			pee = pee.replace( /\s*(<\/?(?:param|embed)[^>]*>)\s*/gmi, '$1');
		}

		if(pee.indexOf('<source') > -1 || pee.indexOf('<track') > -1){

			// no P/BR around source and track
			pee = pee.replace(/([<\[](?:audio|video)[^>\]]*[>\]])\s*/gmi, '$1');
			pee = pee.replace(/\s*([<\[]\/(?:audio|video)[>\]])/gmi, '$1');
			pee = pee.replace(/\s*(<(?:source|track)[^>]*>)\s*/gmi, '$1');
		}

		pee = pee.replace(/\n\n+/gmi, "\n\n"); // take care of duplicates

		// make paragraphs, including one at the end
		var pees = pee.split(/\n\s*\n/);
		pee = '';

		pees.forEach(function(tinkle) {
			pee += '<p>' + tinkle.trim() + "</p>\n";
		});

		pee = pee.replace(/<p>\s*<\/p>/gmi, ''); // under certain strange conditions it could create a P of entirely whitespace
		pee = pee.replace(/<p>([^<]+)<\/(div|address|form)>/gmi, "<p>$1</p></$2>");
		pee = pee.replace(new RegExp('<p>\s*(</?' + allblocks + '[^>]*>)\s*</p>', 'gmi'), "$1", pee); // don't pee all over a tag
		pee = pee.replace(/<p>(<li.+?)<\/p>/gmi, "$1"); // problem with nested lists
		pee = pee.replace(/<p><blockquote([^>]*)>/gmi, "<blockquote$1><p>");
		pee = pee.replace(/<\/blockquote><\/p>/gmi, '</p></blockquote>');
		pee = pee.replace(new RegExp('<p>\s*(</?' + allblocks + '[^>]*>)', 'gmi'), "$1");
		pee = pee.replace(new RegExp('(</?' + allblocks + '[^>]*>)\s*</p>', 'gmi'), "$1");

		if(br){

			pee = pee.replace(/<(script|style)(?:.|\n)*?<\/\\1>/gmi, _autop_newline_preservation_helper); // /s modifier from php PCRE regexp replaced with (?:.|\n)
			pee = pee.replace(/(<br \/>)?\s*\n/gmi, "<br />\n"); // optionally make line breaks
			pee = pee.replace('<WPPreserveNewline />', "\n");
		}

		pee = pee.replace(new RegExp('(</?' + allblocks + '[^>]*>)\s*<br />', 'gmi'), "$1");
		pee = pee.replace(/<br \/>(\s*<\/?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)/gmi, '$1');
		pee = pee.replace(/\n<\/p>$/gmi, '</p>');

		if(pre_tags.length > 0){

			for(var i in pre_tags){

				var value = pre_tags[i];

				pee = pee.replace(i, value);
			}
		}

		return pee;
	}
};