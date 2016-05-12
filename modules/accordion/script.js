/**
 * Accordion js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		// No conflict
		var $ = jQuery.noConflict();

		DSLC.ModulesManager.AvailModules.DSLC_Accordion.prototype.changeOptionsBeforeRender = function(options)
		{
			if(options.accordion_slides.value == undefined || ( Array.isArray(options.accordion_slides.value) && options.accordion_slides.value.length == 0 ) ){

				options.accordion_slides.value = options.accordion_slides.std;
			}

			options.open_by_default.value = options.open_by_default.value > 0 ? options.open_by_default.value : options.open_by_default.std;

			return options;
		}

		/**
		 * Add accordion item
		 */
		DSLC.ModulesManager.AvailModules.DSLC_Accordion.prototype.addSlide = function()
		{
			var slides = this.getOption( 'accordion_slides' );

			if(Array.isArray(slides) && slides.length == 0 || slides == undefined)
			{
				slides = this.moduleOptions['accordion_slides'].std;
			}

			slides.push(this.moduleOptions['accordion_slides'].std[0]);

			this.setOption( 'accordion_slides', slides )
				.reloadModuleBody()
				.saveEdits();
		}

		/**
		 * Remove accordion item
		 */
		DSLC.ModulesManager.AvailModules.DSLC_Accordion.prototype.removeSlide = function( index )
		{
			var slides = this.getOption( 'accordion_slides' );

			if(slides.length < 2) return false;

			slides.splice( index, 1 );

			this.setOption( 'accordion_slides', slides )
				.reloadModuleBody()
				.saveEdits();
		}

		jQuery(document).on('click', '.dslca-add-accordion-hook', function(e)
		{
			var module = $(this).closest('.dslc-module-front').data('module-instance');
			module.addSlide();

			e.stopPropagation();
			e.preventDefault();
		});

		jQuery(document).on('click', '.dslca-delete-accordion-hook', function(e)
		{
			var module = $(this).closest('.dslc-module-front').data('module-instance');
			module.removeSlide(  $('.dslc-accordion-item').index() );

			e.stopPropagation();
			e.preventDefault();
		});

		jQuery(document).on('click', '.dslca-move-up-accordion-hook, .dslca-move-down-accordion-hook', function(e)
		{
			var dslcAccordion = jQuery(this).closest('.dslc-accordion'),
			dslcAccordionItem = jQuery(this).closest('.dslc-accordion-item'),
			dslcAccordionItemNext = dslcAccordionItem.next('.dslc-accordion-item'),
			dslcAccordionItemPrev = dslcAccordionItem.prev('.dslc-accordion-item');

			if(!jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited')){
				jQuery(this).closest('.dslc-module-front').find('.dslca-module-edit-hook').trigger('click');
			}

			if(jQuery(this).hasClass('dslca-move-down-accordion-hook')){

				dslcAccordionItem.insertAfter(dslcAccordionItemNext);
			}else{

				dslcAccordionItem.insertBefore(dslcAccordionItemPrev);
			}

			e.stopPropagation()

		});

		jQuery(document).on('blur paste keyup', '.dslc-accordion-title[contenteditable], .dslc-accordion-content[contenteditable]', function()
		{

			dslc_accordion_generate_code(jQuery(this).closest('.dslc-accordion'));

		}).on('focus', '.dslc-accordion-title[contenteditable], .dslc-accordion-content[contenteditable]', function()
		{

			if(!jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited')){
				jQuery(this).closest('.dslc-module-front').find('.dslca-module-edit-hook').trigger('click');
			}
		});

		$(document).on('click', '.dslca-wysiwyg-actions-edit-hook', function()
		{

			e.stopPropagation();
			e.preventDefault();
		});
	});

	jQuery(document).ready(function($)
	{
		jQuery(document).on('click', '.dslc-accordion-hook', function()
		{
			var currSlide = $(this).closest('.dslc-accordion-item');
			var otherSlides = $(this).closest('.dslc-accordion').find('.dslc-accordion-item').not(currSlide);

			otherSlides.find('.dslc-accordion-content-wrapper').slideUp();
			currSlide.find('.dslc-accordion-content-wrapper').slideDown();
		});
	});
}());