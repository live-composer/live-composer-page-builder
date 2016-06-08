/**
 * Tab js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Tab = DSLC.ModulesManager.AvailModules.DSLC_Tabs;
		// No conflict
		var $ = jQuery.noConflict();

		Tab.prototype.changeOptionsBeforeRender = function(options)
		{
			if(options.tab_slides.value == undefined || ( Array.isArray(options.tab_slides.value) && options.tab_slides.value.length == 0 ) ){

				options.tab_slides.value = options.tab_slides.std;
			}

			return options;
		}

		/**
		 * Add accordion item
		 */
		Tab.prototype.addSlide = function()
		{
			var slides = this.getOption( 'tab_slides' );

			if(Array.isArray(slides) && slides.length == 0 || slides == undefined)
			{
				slides = this.moduleOptions['tab_slides'].std;
			}

			slides.push(this.moduleOptions['tab_slides'].std[0]);

			this.setOption( 'tab_slides', slides )
				.reloadModuleBody()
				.saveEdits();
		}

		/**
		 * Remove accordion item
		 */
		Tab.prototype.removeSlide = function( index )
		{
			var slides = this.getOption( 'tab_slides' );

			if(slides.length < 2) return false;

			slides.splice( index, 1 );

			this.setOption( 'tab_slides', slides )
				.reloadModuleBody()
				.saveEdits();
		}

		/**
		 * @inherited
		 */
		Tab.prototype.setWYSIWIGValue = function( editableField )
		{
			var index = editableField.closest('.dslc-tabs-tab-content').index();
			var content = editableField.html();
			var slides = this.getOption('tab_slides');

			slides[index].content = content;
			this.setOption( 'tab_slides', slides )
				.getModuleBody();

			this.saveEdits();

			dslc_generate_code();
		}

		/**
		 * @inherited
		 */
		Tab.prototype.setContentEditableValue = function( editableField )
		{
			[].forEach.call(editableField.querySelectorAll("p"), function( p )
			{
				if ( p.innerHTML == '<br>' )
				{
					p.innerHTML = '&nbsp;';
				}
			});

			var content = editableField.innerHTML;
			var slides = this.getOption('tab_slides');

			if($(editableField).data('id') == 'tab-title'){

				var index = $(editableField).closest('.dslc-tabs-nav-hook').index();
				slides[index].title = content;
			}else{

				var index = $(editableField).closest('.dslc-tabs-tab-content').index();
				slides[index].content = content;
			}

			this.setOption( 'tab_slides', slides )
				.getModuleBody();

			this.saveEdits();
			dslc_generate_code();

			return this;
		}

		jQuery(document).on('click', '.dslca-add-new-tab-hook', function(e)
		{
			var module = $(this).closest('.dslc-module-front').data('module-instance');

			module.addSlide();
			dslc_generate_code();

			e.stopPropagation();
			e.preventDefault();
		});

		jQuery(document).on('click', '.dslca-delete-tab-hook', function(e)
		{
			var module = $(this).closest('.dslc-module-front').data('module-instance');
			module.removeSlide(  $(this).closest('.dslc-accordion-item').index() );
			dslc_generate_code();

			e.stopPropagation();
			e.preventDefault();
		});

	});
}());