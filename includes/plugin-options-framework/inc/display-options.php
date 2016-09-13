<?php
/**
 * Functions to output controls on the settings panel
 *
 * @package LiveComposer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Output simple text control on the settings panel.
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_plugin_option_display_text( $option ) {

	global $dslc_plugin_options;

	$section_id = $option['section'];
	$option_id = $option['id'];
	$value = $option['value'];

	?>
	<input class="regular-text" id='<?php echo esc_attr( $option_id ); ?>' name='<?php echo esc_attr( $option['name'] ); ?>' type='text' value='<?php echo esc_attr( $value ); ?>' />
	<?php
	if ( isset( $option['descr'] ) ) { ?>

		<p class="description">
			<?php echo esc_html( $option['descr'] ); ?>
		</p>
	<?php }
}

/**
 * Output text area control on the settings panel.
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_plugin_option_display_textarea( $option ) {

	global $dslc_plugin_options;

	$section_id = $option['section_id'];
	$option_id = $option['id'];
	$value = $option['value'];

	// Echo the field.
	?><textarea class="large-text" id='<?php echo esc_attr( $option_id ); ?>' name='<?php echo esc_attr( $option['name'] ); ?>' rows="5" cols="50">
		<?php echo esc_attr( $value ); ?>
	</textarea>

	<?php
	if ( isset( $option['descr'] ) ) { ?>

		<p class="description">
			<?php echo esc_html( $option['descr'] ); ?>
		</p>
	<?php }
}

/**
 * Output select control on the settings panel.
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_plugin_option_display_select( $option ) {

	global $dslc_plugin_options;

	$section_id = $option['section'];
	$option_id = $option['id'];
	$value = $option['value'];

	?>
	<select id='<?php echo esc_attr( $option_id ); ?>' name='<?php echo esc_attr( $option['name'] ); ?>'>

		<?php foreach ( $option['choices'] as $choice ) : ?>

			<option value="<?php echo esc_attr( $choice['value'] ); ?>" <?php if ( $choice['value'] === $value ) echo 'selected="selected"'; ?> >
				<?php echo esc_attr( $choice['label'] ); ?>
			</option>

		<?php endforeach; ?>

	</select>

	<?php
	if ( isset( $option['descr'] ) ) { ?>

		<p class="description">
			<?php echo esc_html( $option['descr'] ); ?>
		</p>
	<?php }
}

/**
 * Output checkbox control on the settings panel.
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_plugin_option_display_checkbox( $option ) {

	global $dslc_plugin_options;

	$section_id = $option['section'];
	$option_id = $option['id'];
	$value = $option['value'];

	$cnt = 0;
	foreach ( $option['choices'] as $choice ) :
		$cnt++;
		?>
		<input type="checkbox" name="<?php echo esc_attr( $option['name'] ); ?>[]" id="<?php echo esc_attr( $option_id . $cnt ); ?>" value="<?php echo esc_attr( $choice['value'] ); ?>" <?php if ( in_array( $choice['value'], $value ) ) echo 'checked="checked"'; ?>>
		<label for="<?php echo esc_attr( $option_id . $cnt ); ?>">
			<?php echo esc_attr( $choice['label'] ); ?>
		</label>
		<br>
		<?php
	endforeach;

	if ( isset( $option['descr'] ) ) { ?>

		<p class="description">
			<?php echo esc_html( $option['descr'] ); ?>
		</p>
	<?php }
}

/**
 * Output radio option control on the settings panel.
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_plugin_option_display_radio( $option ) {

	global $dslc_plugin_options;

	$section_id = $option['section'];
	$option_id = $option['id'];
	$value = $option['value'];

	foreach ( $option['choices'] as $choice ) :
		?>
		<input type="radio" name="<?php echo esc_attr( $option['name'] ); ?>" id="<?php echo esc_attr( $option_id ); ?>" value="<?php echo esc_attr( $choice['value'] ); ?>" <?php if ( $value === $choice['value'] ) echo 'checked="checked"'; ?>>
		<label for="<?php echo esc_attr( $section_id ); ?>[<?php echo esc_attr( $option_id ); ?>]">
			<?php echo esc_attr( $choice['label'] ); ?>
		</label>
		<br>
		<?php
	endforeach;

	if ( isset( $option['descr'] ) ) { ?>

		<p class="description">
			<?php echo esc_html( $option['descr'] ); ?>
		</p>
	<?php }
}

/**
 * Output list control on the settings panel.
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_plugin_option_display_list( $option ) {

	global $dslc_plugin_options;

	$section_id = $option['section'];
	$option_id = $option['id'];
	$value = $option['value'];
	?>

	<div class="dslca-plugin-opts-list-wrap">

		<input type="hidden" class="dslca-plugin-opts-list-code" id='<?php echo esc_attr( $option_id ); ?>' name='<?php echo esc_attr( $option['name'] ); ?>' value='<?php echo esc_attr( $value ); ?>' />

		<?php
		$sidebars_array = array();
		if ( '' !== $value ) {

			$sidebars = $value;
			$sidebars_array = explode( ',', substr( $sidebars, 0, -1 ) );
		}
		?>

		<div class="dslca-plugin-opts-list">
			<?php foreach ( $sidebars_array as $sidebar ) : ?>
				<div class="dslca-plugin-opts-list-item">
					<span class="dslca-plugin-opts-list-title" contenteditable="true">
						<?php echo esc_html( $sidebar ); ?>
					</span>
					<a href="#" class="dslca-plugin-opts-list-delete-hook">
						<?php esc_html_e( 'delete', 'live-composer-page-builder' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div><!-- .dslca-plugin-opts-list -->

		<a href="#" class="dslca-plugin-opts-list-add-hook">
			<?php esc_html_e( 'Add New', 'live-composer-page-builder' ); ?>
		</a>

		<div class="dslca-plugin-opts-list-error">
			<?php esc_html_e( 'Items with duplicated titles found. Titles must be unique.', 'live-composer-page-builder' ); ?>
		</div>

	</div>

	<?php
	if ( isset( $option['descr'] ) ) { ?>

		<p class="description">
			<?php echo esc_html( $option['descr'] ); ?>
		</p>
	<?php }
}

/**
 * Output presets control on the settings panel.
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_plugin_option_display_styling_presets( $option ) {

	global $dslc_plugin_options;

	$section_id = $option['section'];
	$option_id = $option['id'];

	$presets = maybe_unserialize( get_option( 'dslc_presets' ) );

	?>

	<div class="dslca-plugin-opts-list-wrap">

		<?php

		/*
		<input type="hidden" class="dslca-plugin-opts-list-code" id='<?php echo esc_attr( $option_id ); ?>' name='<?php echo esc_attr( $section_id ); ?>[<?php echo esc_attr( $option_id ); ?>]' value='<?php echo esc_attr( $value ); ?>' />
		*/ ?>

		<div class="dslca-plugin-opts-list">
			<?php foreach ( $presets as $preset ) : ?>
				<div class="dslca-plugin-opts-list-item">
					<span class="dslca-plugin-opts-list-title" contenteditable="true">
						<?php echo esc_html( $preset['title'] ); ?>
					</span>
					<a href="#" class="dslca-plugin-opts-list-delete-hook">
						<?php esc_html_e( 'Delete', 'live-composer-page-builder' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div><!-- .dslca-plugin-opts-list -->

	</div>

	<?php
	if ( isset( $option['descr'] ) ) { ?>

		<p class="description">
			<?php echo esc_html( $option['descr'] ); ?>
		</p>
	<?php }
}
