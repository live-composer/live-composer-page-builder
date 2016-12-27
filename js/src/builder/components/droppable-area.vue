<template>

	<div class="module" style="border:1px solid green; padding:30px;" >
		<draggable style="border:1px solid red; min-height:300px; min-width:300px;"
			:options="{
				group: { name: 'modules' },
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


	 	<!-- </div> -->
	 	</draggable>
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

	components: {
		draggable,
	}
}
</script>

<style>

</style>