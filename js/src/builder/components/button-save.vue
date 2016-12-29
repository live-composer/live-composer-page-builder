<template>
	<div class="lc-button-save">
		<span class="spinner" v-if="spinner.state"></span>
		<a href="#"
			v-bind:class="'button button-primary ' + button.state"
			v-on:click="save"
		>
			{{button.text}}
		</a>
	</div>
</template>

<script>
/**
 * Vue Component: SAVE button.
 **/
export default {

	data: function () {
		return {
			button: {
				text : '',
				state: 'disabled',
			},

			spinner: {
				state: false
			}
		};
	},

	mounted: function () {
		this.updateButtonState()
	},

	computed: {
		buttonState() {
			return this.$store.state.needToSave
		},

		savingInProgress() {
			return this.$store.state.savingInProgress
		},
	},

	watch: {
	   buttonState: function (state) {
	   	this.updateButtonState(state)
	   },

	   savingInProgress(status) {
			this.updateSpinnerState(status)
			console.log('COMPONENT detected change of saving status: ' + status)
		},
	},

	methods: {
		updateButtonState: function (newState) {
			if ( newState ) {
				this.button.state = 'enabled'
				this.button.text = 'Save'
			} else {
				this.button.state = 'disabled'
				this.button.text = 'Saved'
			}
		},

		updateSpinnerState: function (status) {
			if ( status ) {
				this.spinner.state = true
				// this.spinner.text = 'Save'
			} else {
				this.spinner.state = false
				// this.spinner.text = 'Saved'
			}
		},

		save: function () {
			console.log('save clicked');
			if ( this.buttonState ) {
				this.$store.dispatch('savePage')
			}
			// this.$store.commit('savePage')
		}
	},

}
</script>

<style>

	/* Save button */

	.lc-button-save {
		float: right;
		padding-top: 9px;
		height: 45px;
	}

	/* Spinner */

	.lc-button-save .spinner {
		margin-top: 4px;
		margin-right: 8px;
		float: left;
		visibility: visible;
	}



</style>