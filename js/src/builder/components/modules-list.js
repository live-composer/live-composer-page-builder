'use strict';
/* globals DSLCModules: true */
/* globals dslcDebug: false */
/* globals Sortable: false */

/**
 * Prepare DSLCModules variable for component.
 * Go through all DSLCModules.icon properties and prepare data for output.
 */
(function() {
	let i,
		 hasOwn = Object.prototype.hasOwnProperty,
		 DLSCModulesWithSections = [],
		 DLSCModulesSections = []; // Temporary object that we use to create objects by category

	for ( i in DSLCModules) {
		if ( hasOwn.call( DSLCModules, i ) ) { // filter out prototypes

			// Do we have this section id in the object already?
			if ( undefined === DLSCModulesSections[ DSLCModules[i].origin.toUpperCase() ] ) {
				DLSCModulesSections[ DSLCModules[i].origin.toUpperCase() ] = DSLCModules[i].origin.toUpperCase();
				DLSCModulesWithSections.push( { 'type': 'heading', 'id': DSLCModules[i].origin.toLowerCase(), 'title': DSLCModules[i].origin.toUpperCase(), 'origin': DSLCModules[i].origin.toLowerCase(), 'show': true } );
			}

			DSLCModules[i].type = 'module';
			DSLCModules[i].show = true;

			DLSCModulesWithSections.push(  DSLCModules[i] );
		}
	}
	// We don't want to create many globals,
	// so replace original object with sorted one.
	DSLCModules = DLSCModulesWithSections;

}());

/**
 * Vue component: Modules list (library of modules to drag in the sidebar).
 *
 * It replace <modules-list></modules-list> tags with rendered output using
 * template code in #modules-list-template (text/x-template) and the code below.
 */
Vue.component('modulesList', {

	template: '#modules-list-template',

	data: function () {
		return {
			modules: DSLCModules,
			modulesSearch : ''
		};
	},

	mounted: function () {
		// Call drag and drop initialization function
		// once the component rendered.
		this.initDragNDrop();
	},

	watch: {
		// whenever question changes, this function will run
		modulesSearch: function () {

			let vm = this;

			/**
			 * Iterate through modules to update module.show property based
			 * on string in the search query. If search query is empty – show all.
			 * We also update tabindex property that linked with div html attribute.
			 */
			(function() {
				let i,
					 hasOwn = Object.prototype.hasOwnProperty,
					 moduleTitle = '',
					 searchQuery = vm.modulesSearch.toLowerCase();

				for ( i in vm.modules) {
					if ( hasOwn.call( vm.modules, i ) ) { // filter out prototypes

						moduleTitle = vm.modules[i].title.toLowerCase();

						/**
						 * Tabindex makes the elements focusable via keyboard TAB.
						 * Non-focusable: tabindex = -1
						 * Focusable: tabindex = 0
						 * Focusable with priority: tabindex = 1..99
						 */
						vm.modules[i].tabindex = -1;

						if ( searchQuery !== '' ) {
							vm.modules[i].show = false;
						} else {
							vm.modules[i].show = true;
						}

						if ( vm.modules[i].type !== 'heading' &&
								moduleTitle.indexOf( searchQuery ) !== -1 ) {

							vm.modules[i].show = true;
							vm.modules[i].tabindex = 0;
						}
					}
				}
			}());
		}
	},

	methods: {
		initDragNDrop: function () {
			/**
			 * To call this method from outside use:
			 * LiveComposerApp.$refs.modulesList.initDragNDrop();
			 */

			if ( dslcDebug ) console.log( 'dslc_drag_and_drop' );

			let modulesArea,
				 moduleID,
				 moduleOutput;

			Sortable.create( this.$el, {
				sort: false, // do not allow sorting inside the list of modules
				group: { name: 'modules', pull: 'clone', put: false },
				animation: 150,
				handle: '.dslca-module',
				draggable: '.dslca-module',
				// ghostClass: 'dslca-module-placeholder',
				chosenClass: 'dslca-module-dragging',
				scroll: true, // or HTMLElement
				scrollSensitivity: 150, // px, how near the mouse must be to an edge to start scrolling.
				scrollSpeed: 15, // px


				setData: function (dataTransfer, dragEl) {
					//dragEl – contains html of the draggable element like:
					//<div class="dslca-module dslca-scroller-item dslca-origin dslca-origin-General" data-id="DSLC_Button" data-origin="General" draggable="false" style="">

					dataTransfer.setData('Text', dragEl.textContent);
					// dataTransfer.setData(LiveComposer.Utils.msieversion() !== false ? 'Text' : 'text/html', dragEl.innerHTML);
				},

				// dragging started
				onStart: function (/**Event*/evt) {
					evt.oldIndex;  // element index within parent

					// jQuery( '.dslc-modules-area' ).sortable( "refreshPositions" );
					jQuery('body').removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
					jQuery('body', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
					jQuery('#dslc-header').addClass('dslca-header-low-z-index');
				},

				// dragging ended
				onEnd: function (/**Event*/evt) {

					if ( dslcDebug ) console.log( 'dslc_drag_and_drop - sortable - onEnd' );

					evt.oldIndex;  // element's old index within parent
					evt.newIndex;  // element's new index within parent

					var itemEl = evt.item;  // dragged HTML
					evt.preventDefault();
					// evt.stopPropagation();
					//return false;

					// Prevent drop into modules listing
					if(jQuery(itemEl).closest('.dslca-section-scroller-content').length > 0) return false;

					jQuery( '.dslca-options-hovered', LiveComposer.Builder.PreviewAreaDocument ).removeClass('dslca-options-hovered');

					// Vars
					modulesArea = jQuery(itemEl.parentNode); //jQuery(this);
					moduleID = itemEl.dataset.id; // get value of data-id attr.

					dslc_generate_code(); // @todo: check if we can delete it?

					if ( moduleID == 'DSLC_M_A' || jQuery('body').hasClass('dslca-module-drop-in-progress') ||
						modulesArea.closest('#dslc-header').length || modulesArea.closest('#dslc-footer').length ) {
						// nothing - don't drop on header/footer areas

					} else {

						// re-init droppable areas.
						init_sortables();

						jQuery('body').addClass('dslca-module-drop-in-progress');

						// Add padding to modules area
						/*
						if ( modulesArea.hasClass('dslc-modules-area-not-empty') )
							modulesArea.animate({ paddingBottom : 50 }, 150);
						*/

						// TODO: Optimize expensive ajax call in this function!
						// Load Output
						dslc_module_output_default( moduleID, function( response ){

							// Append Content
							moduleOutput = response.output;


							// Remove extra padding from area
							// modulesArea.css({ paddingBottom : 0 });

							// Add output
							// TODO: optimize jQuery in the string below

							var dslcJustAdded = LiveComposer.
												Builder.
												Helpers.
												insertModule( moduleOutput, jQuery('.dslca-module', modulesArea) );



							var dslcJustAddedEl = dslcJustAdded[0];

							// 1. Get the new module code.
							var moduleJSONCode = dslcJustAddedEl.getElementsByClassName('dslca-module-code');
							moduleJSONCode = moduleJSONCode[0].value;


							// 2. Find were it placed (parent ID and neighbor ID).
							var pathToModule = [];
							var parentModule = dslcJustAddedEl.closest('.lc-module');
							var parentModuleId = parentModule.getAttribute('data-module-id');

							pathToModule.push(parentModuleId);

							var grandParentModule = parentModule.parentElement.closest('.lc-module');

							while ( grandParentModule !== null ) {
								var grandParentModuleId = grandParentModule.getAttribute('data-module-id');
								if ( grandParentModuleId !== null ) {
									pathToModule.push(grandParentModuleId);
								}
								grandParentModule = grandParentModule.parentElement.closest('.lc-module');
							}

							var prevEl = dslcJustAddedEl.previousElementSibling;
							var prevElId = '';

							var nextEl = dslcJustAddedEl.nextElementSibling;
							var nextElId = '';

							if ( prevEl !== null
									&& prevEl.classList.contains('lc-module')  ) {

								prevElId = prevEl.getAttribute('data-module-id');

							} else if (nextEl !== null
									&& nextEl.classList.contains('lc-module') ) {

								nextElId = nextEl.getAttribute('data-module-id');

							}

							// 3. Insert into the page JSON under the right address.


							var pageCode = liveComposerState.state.pageCode;
							console.log( "pageCode:" ); console.log( JSON.parse(pageCode) );





							setTimeout( function(){
								LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();
								jQuery('body').removeClass('dslca-module-drop-in-progress');
							}, 700 );

							// "Show" no content text
							jQuery('.dslca-no-content-primary', modulesArea ).css({ opacity : 1 });

							// "Show" modules area management
							jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'visible' });

							// Generete
							LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
							LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
							LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();

							// Init resizable.
							LiveComposer.Builder.UI.initResizableModules( dslcJustAdded );

							dslc_generate_code();
							// Show publish
							dslc_show_publish_button();

							LiveComposer.Builder.UI.initInlineEditors();
						});

						// Loading animation

						// Show loader – Not used anymore.
						// jQuery('.dslca-module-loading', modulesArea).show();

						// Change module icon to the spinning loader.
						jQuery(itemEl).find('.dslca-icon').attr('class', '').attr('class', 'dslca-icon dslc-icon-refresh dslc-icon-spin');


						// Hide no content text
						jQuery('.dslca-no-content-primary', modulesArea).css({ opacity : 0 });

						// Hide modules area management
						jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'hidden' });

						// Animate loading
						/*
						var randomLoadingTime = Math.floor(Math.random() * (100 - 50 + 1) + 50) * 100;
						jQuery('.dslca-module-loading-inner', modulesArea).css({ width : 0 }).animate({
							width : '100%'
						}, randomLoadingTime, 'linear' );
						*/
					}

					// LiveComposer.Builder.UI.stopScroller();
					jQuery('body').removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
					jQuery('body', LiveComposer.Builder.PreviewAreaDocument).removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
					jQuery('#dslc-header').removeClass('dslca-header-low-z-index');
				},

				// Element is dropped into the list from another list
				onAdd: function (/**Event*/evt) {
					var itemEl = evt.item;  // dragged HTMLElement
					evt.from;  // previous list
					// + indexes from onEnd
					// evt.preventDefault();
				},

				// Changed sorting within list
				onUpdate: function (/**Event*/evt) {
					var itemEl = evt.item;  // dragged HTMLElement
					// + indexes from onEnd
					dslc_show_publish_button();
					// evt.preventDefault();
				},

				// Called by any change to the list (add / update / remove)
				onSort: function (/**Event*/evt) {
					// same properties as onUpdate
					evt.preventDefault();
					// evt.stopPropagation(); return false;
				},

				// Element is removed from the list into another list
				onRemove: function (/**Event*/evt) {
					  // same properties as onUpdate
				},

				// Attempt to drag a filtered element
				onFilter: function (/**Event*/evt) {
					var itemEl = evt.item;  // HTMLElement receiving the `mousedown|tapstart` event.
				},

				// Event when you move an item in the list or between lists
				onMove: function (/**Event*/evt) {
					// Example: http://jsbin.com/tuyafe/1/edit?js,output
					evt.dragged; // dragged HTMLElement
					evt.draggedRect; // TextRectangle {left, top, right и bottom}
					evt.related; // HTMLElement on which have guided
					evt.relatedRect; // TextRectangle
					// return false; — for cancel
					jQuery( evt.to ).addClass('dslca-options-hovered');
				}
			});
		}
	}
});