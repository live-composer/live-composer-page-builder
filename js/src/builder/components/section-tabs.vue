<template>
	<div>
		<ul class="dslca-subsection-tabs wp-clearfix">
			<li class="dslca-tab-active" ><a href="#"><span class="dslca-icon dslc-icon-th-large"></span> Modules</a></li>
			<li><a href="#">Sections</a></li>
			<li><a href="#">Pages</a></li>
		</ul>
		<!-- MODULES LISTING -->
		<div class="dslca-section dslca-modules" id="dslca-modules">

			<div class="dslca-section-scroller-fade"></div>

			<div class="dslca-section-scroller">
					<div class="dslca-section-scroller-content">
						<modules-list></modules-list>

					</div><!-- .dslca-section-scroller-content -->
			</div><!-- .dslca-section-scroller-content -->

		</div>
		<!-- /MODULES LISTING -->
	</div>
</template>

<script>
/**
 * Vue Component: SAVE button.
 **/

const modulesList = require('./modules-list.vue');

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

	components : {
		modulesList,
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