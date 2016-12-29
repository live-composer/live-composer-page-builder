<template>
	<div class="dslca-subsection-title" v-if="active">
		<button class="dslca-section-back" tabindex="0">
			<span class="screen-reader-text">Back</span>
		</button>
		<h3>
			<span class="dslca-action">
				Editing
			</span>
			<!-- Currently Editing -->
			<span class="dslca-currently-editing"><strong></strong></span>

		</h3>
	</div>
</template>

<script>
/**
 * Vue Component: SAVE button.
 **/

export default {

	data: function () {
		return {
			actve: false
			// button: {
			// 	text : '',
			// 	state: 'disabled',
			// }
		};
	},

	mounted: function () {
		// this.updateButtonState()
	},

	computed: {
		buttonState() {
			// return this.$store.state.needToSave
		},
	},

	watch: {
	   buttonState: function (state) {
	   	// this.updateButtonState(state)
	   },
	},

	methods: {
		updateButtonState: function (newState) {
		},
	},

}
</script>

<style>
	
</style>