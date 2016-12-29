<template>
	<div class="module">
		<draggable
			:list="pageCode"
			:options="{
				group: { name: 'modules' },
				animation: 150,
				handle: '.dslca-module',
				//draggable: '.dslca-module',
				// ghostClass: 'dslca-module-placeholder',
				chosenClass: 'dslca-module-dragging',
				scroll: true,
				scrollSensitivity: 150,
				scrollSpeed: 15
			}"

			@add="onAdd"
			:move="onEnd"
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
	 	</draggable>
 		<pre>
 			{{ pageCode }}
 		</pre>
 	</div>

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

	// data: function () {
	// 	return {
	// 		modules: []
	// 	};
	// },
	// 
	props: ['pageCode'],

	components: {
		draggable,
	},

	methods: {
		onAdd: function () {
			console.log('droppable – ADD');
			console.log(this.$parent.$data.pageCode);

		},

		onEnd: function () {
			console.log('END droppable');
		}
	}
}
</script>

<style>

.module {
	border:1px solid green; padding:30px;
}

.module > div {
	border:1px solid red; min-height:300px; min-width:300px;
}
</style>