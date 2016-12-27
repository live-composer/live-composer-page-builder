<template>

	<draggable id="modules-list" class="lc-modules-list"
		:list="modules"
		:options="{
			sort: false, // do not allow sorting inside the list of modules
			group: { name: 'modules', pull: 'clone', put: false },
			animation: 150,
			handle: '.dslca-module',
			draggable: '.dslca-module',
			// ghostClass: 'dslca-module-placeholder',
			chosenClass: 'dslca-module-dragging',
			scroll: true, // or HTMLElement
			scrollSensitivity: 150, // px, how near the mouse must be to an edge to start scrolling.
			scrollSpeed: 15
		}"
	>
 	<!-- <div id="modules-list" class="lc-modules-list"> -->

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
 	<!-- </div> -->
 	</draggable>
</template>

<script>

import draggable from 'vuedraggable'

/**
 * Render list of modules with Vue.
 * We receive DSLCModules global var via WordPress localize.
 */

/**
 * Vue Component: Modules List Panel.
 */
export default {

	template: '#modules-list-template',

	data: function () {
		return {
			modules: DSLCModules,
			modulesSearch : ''
		};
	},

	components: {
		draggable,
	},

	watch: {
		// whenever question changes, this function will run
		modulesSearch: function (searchQuery) {

			var vm = this;

			/**
			 * Iterate through modules to update module.show property based
			 * on string in the search query. If search query is empty – show all.
			 * We also update tabindex property that linked with div html attribute.
			 */
			(function() {
				var i,
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