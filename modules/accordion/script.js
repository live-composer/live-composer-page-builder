/**
 * Accordion js extender
 */

'use strict'

;(function(){

	jQuery(document).on('DSLC_extend_modules', function(){

		var Accordion = DSLC.ModulesManager.AvailModules.DSLC_Accordion;
		// No conflict
		var $ = jQuery.noConflict();

		Accordion.prototype.changeOptionsBeforeRender = function(options)
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
		Accordion.prototype.addSlide = function()
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
		Accordion.prototype.removeSlide = function( index )
		{
			var slides = this.getOption( 'accordion_slides' );

			if(slides.length < 2) return false;

			slides.splice( index, 1 );

			this.setOption( 'accordion_slides', slides )
				.reloadModuleBody()
				.saveEdits();
		}

		/**
		 * @inherited
		 */
		Accordion.prototype.setWYSIWIGValue = function( editableField )
		{
			var index = editableField.closest('.dslc-accordion-item').index();
			var content = editableField.html();
			var slides = this.getOption('accordion_slides');

			slides[index].content = content;
			this.setOption( 'accordion_slides', slides )
				.getModuleBody();

			this.saveEdits();

			dslc_generate_code();
		}

		/**
		 * @inherited
		 */
		Accordion.prototype.setContentEditableValue = function( editableField )
		{
			var index = $(editableField).closest('.dslc-accordion-item').index();

			[].forEach.call(editableField.querySelectorAll("p"), function( p )
			{
				if ( p.innerHTML == '<br>' )
				{
					p.innerHTML = '&nbsp;';
				}
			});

			var content = editableField.innerHTML;
			var slides = this.getOption('accordion_slides');

			slides[index].title = content;
			this.setOption( 'accordion_slides', slides )
				.getModuleBody();

			this.saveEdits();
			dslc_generate_code();

			return this;
		}


		jQuery(document).on('click', '.dslca-add-accordion-hook', function(e)
		{
			var module = $(this).closest('.dslc-module-front').data('module-instance');
			module.addSlide();
			dslc_generate_code();

			e.stopPropagation();
			e.preventDefault();
		});

		jQuery(document).on('click', '.dslca-delete-accordion-hook', function(e)
		{
			var module = $(this).closest('.dslc-module-front').data('module-instance');
			module.removeSlide(  $(this).closest('.dslc-accordion-item').index() );
			dslc_generate_code();

			e.stopPropagation();
			e.preventDefault();
		});

		jQuery(document).on('click', '.dslca-move-up-accordion-hook, .dslca-move-down-accordion-hook', function(e)
		{
			function moveArr(arr, old_index, new_index)
			{
			    if (new_index >= arr.length) {
			        var k = new_index - arr.length;
			        while ((k--) + 1) {
			            arr.push(undefined);
			        }
			    }
			    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    			return arr; // for testing purposes
			};

			var dslcAccordion = jQuery(this).closest('.dslc-accordion'),
			dslcAccordionItem = jQuery(this).closest('.dslc-accordion-item'),
			dslcAccordionItemNext = dslcAccordionItem.next('.dslc-accordion-item'),
			dslcAccordionItemPrev = dslcAccordionItem.prev('.dslc-accordion-item'),

			currItemIndex = jQuery(this).closest('.dslc-accordion-item').index(),
			nextItemIndex = dslcAccordionItem.next('.dslc-accordion-item').index(),
			prevItemIndex = dslcAccordionItem.prev('.dslc-accordion-item').index();

			if(!jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited')){
				jQuery(this).closest('.dslc-module-front').find('.dslca-module-edit-hook').trigger('click');
			}

			if(jQuery(this).hasClass('dslca-move-down-accordion-hook')){

				dslcAccordionItem.insertAfter(dslcAccordionItemNext);
			}else{

				dslcAccordionItem.insertBefore(dslcAccordionItemPrev);
			}

			/// Visual edits end, data change starts
			var module = $(this).closest(".dslc-module-front").data('module-instance');
			var slides = module.getOption('accordion_slides');

			if(jQuery(this).hasClass('dslca-move-down-accordion-hook')){

				moveArr(slides, currItemIndex, nextItemIndex);
			}else{

				moveArr(slides, currItemIndex, prevItemIndex);
			}

			module.setOption('accordion_slides', slides)
				.getModuleBody();

			module.saveEdits();
			dslc_generate_code();

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

			return true;
		});
	});
}());