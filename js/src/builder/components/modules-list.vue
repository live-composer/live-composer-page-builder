<template>

	<div id="modules-list" class="lc-modules-list">

 		<input
 			type="search"
 			id="modules-search-input"
 			class="lc-panel-search"
 			value=""
 			placeholder="Start typing to search modules..."
 			v-model="modulesSearch"
 		>
 		<div v-for="module in modules"
 			  v-bind:data-origin="module.origin"
 			  v-bind:data-id="module.id"
 			  v-bind:class="'dslca-origin dslca-' + module.type"
 			  v-bind:tabindex="module.tabindex"
 			  v-if="module.show"
 		>
 			<span v-if="module.icon"
 					v-bind:class="'dslca-icon dslc-icon-' + module.icon"></span>
 			<span class="dslca-module-title">{{ module.title }}</span>
 		</div><!-- .dslc-module -->
 	</div>
</template>

<script>

/**
 * Prepare lcDataOnLoad.modulesList variable for component.
 * Go through all lcDataOnLoad.modulesList.icon properties and prepare data for output.
 */
(function() {
	var i,
		 hasOwn = Object.prototype.hasOwnProperty,
		 DLSCModulesWithSections = [],
		 DLSCModulesSections = []; // Temporary object that we use to create objects by category

	for ( i in lcDataOnLoad.modulesList) {
		if ( hasOwn.call( lcDataOnLoad.modulesList, i ) ) { // filter out prototypes

			// Do we have this section id in the object already?
			if ( undefined === DLSCModulesSections[ lcDataOnLoad.modulesList[i].origin ] ) {
				DLSCModulesSections[ lcDataOnLoad.modulesList[i].origin ] = lcDataOnLoad.modulesList[i].origin;
				DLSCModulesWithSections.push( { 'type': 'heading', 'id': lcDataOnLoad.modulesList[i].origin, 'title': lcDataOnLoad.modulesList[i].origin, 'origin': lcDataOnLoad.modulesList[i].origin, 'show': true } );
			}

			lcDataOnLoad.modulesList[i].type = 'module';
			lcDataOnLoad.modulesList[i].show = true;

			DLSCModulesWithSections.push(  lcDataOnLoad.modulesList[i] );
		}
	}
	// We don't want to create many globals,
	// so replace original object with sorted one.
	lcDataOnLoad.modulesList = DLSCModulesWithSections;

}());

/**
 * Render list of modules with Vue.
 * We receive lcDataOnLoad.modulesList global var via WordPress localize.
 */

/**
 * Vue Component: Modules List Panel.
 */
export default {

	/* globals lcDataOnLoad.modulesList: true */
	/* globals dslcDebug: false */
	/* globals Sortable: false */

	/**
	 * Vue component: Modules list (library of modules to drag in the sidebar).
	 *
	 * It replace <modules-list></modules-list> tags with rendered output using
	 * template code in #modules-list-template (text/x-template) and the code below.
	 */


	data: function () {
		return {
			modules: lcDataOnLoad.modulesList,
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

	computed: {
	    pageCode () {
	      return this.$store.state.pageCode
	    }
	},

	methods: {
		initDragNDrop: function () {

			let vm = this;
			/**
			 * To call this method from outside use:
			 * LiveComposerApp.$refs.modulesList.initDragNDrop();
			 */

			// if ( dslcDebug ) console.log( 'dslc_drag_and_drop' );

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
					jQuery('body').removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
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

					jQuery( '.dslca-options-hovered').removeClass('dslca-options-hovered');

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

							console.log( "pathToModule:" ); console.log( pathToModule );
							console.log( "prevEl:" ); console.log( prevEl );
							console.log( "nextEl:" ); console.log( nextEl );

							// 3. Insert into the page JSON under the right address.

							var pageCode = vm.$store.state.pageCode;

							pageCode.push(moduleJSONCode);
							console.log( "pageCode:" ); console.log( pageCode );

							vm.$store.dispatch('updatePageCode', pageCode);
							// vm.$store.commit('updatePageCode', pageCode);
							// console.log( "pageCode:" ); console.log( JSON.parse(pageCode) );





							setTimeout( function(){
								// LiveComposer.Builder.PreviewAreaWindow.dslc_masonry();
								jQuery('body').removeClass('dslca-module-drop-in-progress');
							}, 700 );

							// "Show" no content text
							jQuery('.dslca-no-content-primary', modulesArea ).css({ opacity : 1 });

							// "Show" modules area management
							jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'visible' });

							// Generete
							// LiveComposer.Builder.PreviewAreaWindow.dslc_carousel();
							// LiveComposer.Builder.PreviewAreaWindow.dslc_tabs();
							// LiveComposer.Builder.PreviewAreaWindow.dslc_init_accordion();

							// Init resizable.
							// LiveComposer.Builder.UI.initResizableModules( dslcJustAdded );

							dslc_generate_code();
							// Show publish
							dslc_show_publish_button();

							// LiveComposer.Builder.UI.initInlineEditors();
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
					jQuery('body').removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
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
}
</script>

<style>

/* Heading used to separate modules by type */
.dslca-heading {
	width: 100%;
	margin-top: 35px;
	margin-bottom: 10px;
	text-transform: uppercase;
	font-size: 12px;
	letter-spacing: 2px;
	color: #777;
}

#modules-list > .dslca-heading:first-of-type {
	margin-top: 0;
}

/* Module in the modules library on the sidebar */

.dslca-module {
	color: #000;
	background: #FFFFFF;

	width: 47%;
	min-height: 44px;
	margin: 5px 2% 0 0;
	padding: 8px 12px;

	overflow: hidden;

	display: inline-flex;
	align-items: center;

	box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.15), -1px 1px 0px 0 rgba(255, 255, 255, 0.05) inset;
	border-radius: 2px;
	border: 2px solid transparent;

	transition: transform 0.05s linear 0.01s;

	/**
	 * We need z-index to make sure the module
	 * covers "Drop modules here" line
	 */
	z-index: 1;
	position: relative;
}

.dslca-module:focus {
	border-color: #00a0d2;
}

/* Gradient disolving text that goes over limits of the module block. */
.dslca-module:before {
	content: '';
	position: absolute;
	right: 0;
	width: 20px;
	top: 0;
	bottom: 0;
	background: linear-gradient(to right, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%); ;

}

.dslca-module[data-id="DSLC_M_A"] {

}

.dslca-module:hover {
  box-shadow: -2px 4px 3px 0 rgba(0, 0, 0, 0.1), -1px 1px 1px 0 rgba(0, 0, 0, 0.05);
  transform: translate(1px, -2px);
}

div.dslca-module:hover,
div.dslca-module:hover * {
	cursor: grab;
	cursor: -webkit-grab;
}

div.dslca-module.dslca-module-dragging {
	position: relative;
	opacity: 1;
}

.dslc-module-front.dslca-module-dragging {
	box-shadow: none!important;
}
</style>