jQuery(document).ready(function(){

	// Add a link 'Clear cache' in the performance section.
	jQuery('#lc_caching_engine').after(' <a href="#" class="dslc-clear-cache" onclick="dslc_clear_cache(event)"><span class="dashicons dashicons-trash"></span> clear cache</a>');

	function dslc_plugin_opts_generate_list_code( dslcTarget ) {

		// Vars
		var dslcTitle,
		dslcCodeInput = jQuery( '.dslca-plugin-opts-list-code', dslcTarget ),
		dslcCode = '',
		duplicateFound = false;


		// Populate array with all the names in the list
		var names = [];
		jQuery( '.dslca-plugin-opts-list-item', dslcTarget ).each( function(){
			if ( jQuery.inArray( jQuery(this).find('.dslca-plugin-opts-list-title').text(), names ) !== -1 ) {
				duplicateFound = true;
			} else {
				names.push( jQuery(this).find('.dslca-plugin-opts-list-title').text() );
			}
		});

		// If there are duplicates show the error message, otherwise hide
		if ( duplicateFound ) {
			jQuery('.dslca-plugin-opts-list-error').show();
		} else {
			jQuery('.dslca-plugin-opts-list-error').hide();
		}

		// Go through each
		jQuery( '.dslca-plugin-opts-list-item', dslcTarget ).each( function(){

			dslcTitle = jQuery(this).find('.dslca-plugin-opts-list-title').text();
			dslcTitle = dslcTitle.replace(/([^a-z0-9 ]+)/gi, ''); // Clean string leaving only letters and numbers
			jQuery(this).find('.dslca-plugin-opts-list-title').text(dslcTitle);
			dslcCode += dslcTitle.trim() + ','

		});

		dslcCodeInput.val( dslcCode );

	}

	jQuery('.dslca-plugin-opts-list-add-hook').click( function(e){

		e.preventDefault();

		var dslcWrapper = jQuery(this).closest('.dslca-plugin-opts-list-wrap');
		var dslcTarget = dslcWrapper.find('.dslca-plugin-opts-list');

		jQuery('<div class="dslca-plugin-opts-list-item"><span class="dslca-plugin-opts-list-title" contenteditable="true">Click to edit</span><a href="#" class="dslca-plugin-opts-list-delete-hook">delete</a></div>').appendTo( dslcTarget );

		dslc_plugin_opts_generate_list_code( dslcWrapper );

	});

	jQuery(document).on( 'click', '.dslca-plugin-opts-list-delete-hook', function(e){

		e.preventDefault();

		var dslcWrapper = jQuery(this).closest('.dslca-plugin-opts-list-wrap');
		var dslcTarget = jQuery(this).closest('.dslca-plugin-opts-list-item');

		dslcTarget.remove();

		dslc_plugin_opts_generate_list_code( dslcWrapper );

	});

	jQuery(document).on( 'blur', '.dslca-plugin-opts-list-title', function() {

		var dslcWrapper = jQuery(this).closest('.dslca-plugin-opts-list-wrap');
		dslc_plugin_opts_generate_list_code( dslcWrapper );

	});

	jQuery(document).on( 'keypress', '.dslca-plugin-opts-list-title', function(e) {

		if(e.keyCode==13){
			jQuery(this).trigger('blur');
			e.preventDefault();
		}

	});

	/*
	 * Active Campaign
	 */

	jQuery('.activecampaign_form').submit(function(){
		var email = jQuery('#dslc_activecampaign_email').val();
		var name = jQuery('#dslc_activecampaign_name').val();

		jQuery.ajax({
			type: "POST",
			data: {
				email: email,
				name: name,
				security: dslcajax,
				action: 'dslc_activecampaign'
			},
			url: ajaxurl
		});
	});

	if ( jQuery(".activecampaign_form").length ) {

		window._show_thank_you = function(id, message) {
		  var form = document.getElementById('_form_' + id + '_'), thank_you = form.getElementsByClassName('_form-thank-you')[0];
		  form.getElementsByClassName('_form-content')[0].style.visibility = 'hidden';
		  thank_you.innerHTML = message;
		  //thank_you.style.display = 'block';
		  thank_you.classList.add("add_thank_you");
		};
		window._show_error = function(id, message, html) {
		  var form = document.getElementById('_form_' + id + '_'), err = document.createElement('div'), button = form.getElementsByTagName('button')[0];
		  err.innerHTML = message;
		  err.className = '_error-inner _form_error _no_arrow';
		  var wrapper = document.createElement('div');
		  wrapper.className = '_form-inner';
		  wrapper.appendChild(err);
		  button.parentNode.insertBefore(wrapper, button);
		  if (html) {
		    var div = document.createElement('div');
		    div.className = '_error-html';
		    div.innerHTML = html;
		    err.appendChild(div);
		  }
		};
		window._load_script = function(url, callback) {
		    var head = document.getElementsByTagName('head')[0], script = document.createElement('script'), r = false;
		    script.type = 'text/javascript';
		    script.src = url;
		    if (callback) {
		      script.onload = script.onreadystatechange = function() {
		      if (!r && (!this.readyState || this.readyState == 'complete')) {
		        r = true;
		        callback();
		        }
		      };
		    }
		    head.appendChild(script);
		};

		(function() {
		  var getCookie = function(name) {
		    var match = document.cookie.match(new RegExp('(^|; )' + name + '=([^;]+)'));
		    return match ? match[2] : null;
		  }
		  var setCookie = function(name, value) {
		    var now = new Date();
		    var time = now.getTime();
		    var expireTime = time + 1000 * 60 * 60 * 24 * 365;
		    now.setTime(expireTime);
		    document.cookie = name + '=' + value + '; expires=' + now + ';path=/';
		  }
		      var addEvent = function(element, event, func) {
		    if (element.addEventListener) {
		      element.addEventListener(event, func);
		    } else {
		      var oldFunc = element['on' + event];
		      element['on' + event] = function() {
		        oldFunc.apply(this, arguments);
		        func.apply(this, arguments);
		      };
		    }
		  }

		  var _removed = false;
		  var form_to_submit = document.getElementById('_form_11_');
		  var allInputs = form_to_submit.querySelectorAll('input, select'), tooltips = [], submitted = false;
		  var remove_tooltips = function() {
		    for (var i = 0; i < tooltips.length; i++) {
		      tooltips[i].tip.parentNode.removeChild(tooltips[i].tip);
		    }
		      tooltips = [];
		  };
		  var remove_tooltip = function(elem) {
		    for (var i = 0; i < tooltips.length; i++) {
		      if (tooltips[i].elem === elem) {
		        tooltips[i].tip.parentNode.removeChild(tooltips[i].tip);
		        tooltips.splice(i, 1);
		        return;
		      }
		    }
		  };
		  var create_tooltip = function(elem, text) {
		    var tooltip = document.createElement('div'), arrow = document.createElement('div'), inner = document.createElement('div'), new_tooltip = {};
		    if (elem.type != 'radio' && elem.type != 'checkbox') {
		      tooltip.className = '_error';
		      arrow.className = '_error-arrow';
		      inner.className = '_error-inner';
		      inner.innerHTML = text;
		      tooltip.appendChild(arrow);
		      tooltip.appendChild(inner);
		      elem.parentNode.appendChild(tooltip);
		    } else {
		      tooltip.className = '_error-inner _no_arrow';
		      tooltip.innerHTML = text;
		      elem.parentNode.insertBefore(tooltip, elem);
		      new_tooltip.no_arrow = true;
		    }
		    new_tooltip.tip = tooltip;
		    new_tooltip.elem = elem;
		    tooltips.push(new_tooltip);
		    return new_tooltip;
		  };
		  var resize_tooltip = function(tooltip) {
		    var rect = tooltip.elem.getBoundingClientRect();
		    var doc = document.documentElement, scrollPosition = rect.top - ((window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0));
		    if (scrollPosition < 40) {
		      tooltip.tip.className = tooltip.tip.className.replace(/ ?(_above|_below) ?/g, '') + ' _below';
		    } else {
		      tooltip.tip.className = tooltip.tip.className.replace(/ ?(_above|_below) ?/g, '') + ' _above';
		    }
		  };
		  var resize_tooltips = function() {
		    if (_removed) return;
		    for (var i = 0; i < tooltips.length; i++) {
		      if (!tooltips[i].no_arrow) resize_tooltip(tooltips[i]);
		    }
		  };
		  var validate_field = function(elem, remove) {
		    var tooltip = null, value = elem.value, no_error = true;
		    remove ? remove_tooltip(elem) : false;
		    if (elem.type != 'checkbox') elem.className = elem.className.replace(/ ?_has_error ?/g, '');
		    if (elem.getAttribute('required') !== null) {
		      if (value === undefined || value === null || value === '') {
		        elem.className = elem.className + ' _has_error';
		        no_error = false;
		        tooltip = create_tooltip(elem, "This field is required.");
		      }
		    }
		    if (no_error && elem.name == 'email') {
		      if (!value.match(/^[\+_a-z0-9-'&=]+(\.[\+_a-z0-9-']+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i)) {
		        elem.className = elem.className + ' _has_error';
		        no_error = false;
		        tooltip = create_tooltip(elem, "Enter a valid email address.");
		      }
		    }
		    tooltip ? resize_tooltip(tooltip) : false;
		    return no_error;
		  };
		  var needs_validate = function(el) {
		    return el.name == 'email' || el.getAttribute('required') !== null || (el.className ? /date_field/.test(el.className) : false);
		  };
		  var validate_form = function(e) {
		    var err = form_to_submit.getElementsByClassName('_form_error')[0], no_error = true;
		    err ? err.parentNode.removeChild(err) : false;
		    if (!submitted) {
		      submitted = true;
		      for (var i = 0, len = allInputs.length; i < len; i++) {
		        var input = allInputs[i];
		        if (needs_validate(input)) {
		          if (input.type == 'text') {
		            addEvent(input, 'input', function() {
		              validate_field(this, true);
		            });
		          }
		        }
		      }
		    }
		    remove_tooltips();
		    for (var i = 0, len = allInputs.length; i < len; i++) {
		      var elem = allInputs[i];
		      if (needs_validate(elem)) {
		        validate_field(elem) ? true : no_error = false;
		      }
		    }
		    if (!no_error && e) {
		      e.preventDefault();
		    }
		    resize_tooltips();
		    return no_error;
		  };
		  addEvent(window, 'resize', resize_tooltips);
		  addEvent(window, 'scroll', resize_tooltips);
		  var form_submit = function(e) {
		    e.preventDefault();
		    if (validate_form()) {
		            var serialized = serialize(document.getElementById('_form_11_'));
		      _load_script('https://lumbermandesigns.activehosted.com/proc.php?' + serialized + '&jsonp=true');
		    }
		    return false;
		  };
		  addEvent(form_to_submit, 'submit', form_submit);
		  _load_script("//d3rxaij56vjege.cloudfront.net/form-serialize/0.3/serialize.min.js");
		})();

	}

	/**
	 * Enable/Disable premium extension via AJAX call.
	 */
	jQuery(document).on('click', '.lc-toggle-extension', function (e) {
		e.preventDefault();
		$extensionId = e.target.getAttribute('data-id');

		var parentEl = jQuery(e.target).closest('.extension');

		if (parentEl[0] !== undefined) {
			parentEl = parentEl[0];
		} else {
			console.error('Can\'t find extension parent for the clicked ellement.')
			return false;
		}

		var extensionStatus = parentEl.getAttribute('data-extension-status');

		parentEl.setAttribute('data-extension-status', 'pending');

		jQuery.ajax({
			type: "POST",
			data: {
				security: dslcajax,
				action: 'dslc-ajax-toggle-extension',
				extension: $extensionId
			},
			url: ajaxurl,
		}).done(function (response) {
			console.log("response:"); console.log(response);
			if (response) {
				// Update DIV attribute with a new status.
				parentEl.setAttribute('data-extension-status', response);
			} else {
				// Get back initial status on error.
				parentEl.setAttribute('data-extension-status', extensionStatus);
			}
		}).fail(function (response) {
			// Get back initial status on error.
			parentEl.setAttribute('data-extension-status', extensionStatus);
		})

	});

});



function dslc_clear_cache(e) {
	e.preventDefault();

	jQuery('.dslc-clear-cache .dashicons').removeClass('dashicons-trash').addClass('dashicons-update dashicon-spin');

	jQuery.ajax({
		type: "POST",
		data: {
			security: dslcajax,
			action: 'dslc_ajax_clear_cache',
		},
		url: ajaxurl,
	}).done(function() {
		jQuery('.dslc-clear-cache').css('color','green');
		jQuery('.dslc-clear-cache').text( 'done' );
		jQuery('.dslc-clear-cache').prepend('<span class="dashicons dashicons-yes"></span> ');
	});
}