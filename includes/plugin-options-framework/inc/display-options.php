<?php

function dslc_plugin_option_display_text( $option ) {

	global $dslc_plugin_options;

	$section_ID = $option['section'];
	$option_ID = $option['id'];
	$value = $option['value'];

	?>
	<input class="regular-text" id='<?php echo $option_ID; ?>' name='<?php echo $option['name']; ?>' type='text' value='<?php echo esc_attr( $value ); ?>' />
	<?php if ( isset( $option['descr'] ) ) : ?>

		<p class="description">
			<?php echo $option['descr']; ?>
		</p>
	<?php

	endif;
}

function dslc_plugin_option_display_textarea( $option ) {
	global $dslc_plugin_options;

	$section_ID = $option['section_id'];
	$option_ID = $option['id'];
	$value = $option['value'];

	// echo the field
	?><textarea class="large-text" id='<?php echo $option_ID; ?>' name='<?php echo $option['name']; ?>' rows="5" cols="50">
		<?php echo esc_attr( $value ); ?>
	</textarea>

	<?php
	if ( isset( $option['descr'] ) ) :	?>

		<p class="description">
			<?php echo $option['descr']; ?>
		</p>
	<?php

	endif;
}

function dslc_plugin_option_display_select( $option ) {

	global $dslc_plugin_options;

	$section_ID = $option['section'];
	$option_ID = $option['id'];
	$value = $option['value'];

	?>
	<select id='<?php echo $option_ID; ?>' name='<?php echo $option['name']; ?>'>

		<?php foreach ( $option['choices'] as $choice ) : ?>
			<?php echo $choice['value']; ?>
			<?php echo $value; ?>
			<option value="<?php echo $choice['value']; ?>" <?php if ( $choice['value'] == $value ) echo 'selected="selected"'; ?> >
				<?php echo $choice['label']; ?>
			</option>

		<?php endforeach; ?>

	</select>

	<?php
	if ( isset( $option['descr'] ) ) :	?>

		<p class="description">
			<?php echo $option['descr']; ?>
		</p>
	<?php

	endif;
}

function dslc_plugin_option_display_checkbox( $option ) {
	global $dslc_plugin_options;

	$section_ID = $option['section'];
	$option_ID = $option['id'];
	$value = $option['value'];

	$cnt = 0;
	foreach ( $option['choices'] as $choice ) :
		$cnt++;
		?>
		<input type="checkbox" name="<?php echo $option['name']; ?>[]" id="<?php echo $option_ID . $cnt; ?>" value="<?php echo $choice['value']; ?>" <?php if ( in_array( $choice['value'], $value ) ) echo 'checked="checked"'; ?>>
		<label for="<?php echo $option_ID . $cnt; ?>">
			<?php echo $choice['label']; ?>
		</label>
		<br>
		<?php
	endforeach;

	if ( isset( $option['descr'] ) ) :	?>

		<p class="description">
			<?php echo $option['descr']; ?>
		</p>
	<?php

	endif;
}

function dslc_plugin_option_display_radio( $option ) {
	global $dslc_plugin_options;

	$section_ID = $option['section'];
	$option_ID = $option['id'];
	$value = $option['value'];

	foreach ( $option['choices'] as $choice ) :
		?>
		<input type="radio" name="<?php echo $option['name']; ?>" id="<?php echo $option_ID; ?>" value="<?php echo $choice['value']; ?>" <?php if ( $choice['value'] == $value ) echo 'checked="checked"'; ?>>
		<label for="<?php echo $section_ID; ?>[<?php echo $option_ID; ?>]">
			<?php echo $choice['label']; ?>
		</label>
		<br>
		<?php
	endforeach;


	if ( isset( $option['descr'] ) ) :	?>

		<p class="description">
			<?php echo $option['descr']; ?>
		</p>
	<?php

	endif;
}

function dslc_plugin_option_display_list( $option ) {
	global $dslc_plugin_options;

	$section_ID = $option['section'];
	$option_ID = $option['id'];
	$value = $option['value'];
	?>

	<div class="dslca-plugin-opts-list-wrap">

		<input type="hidden" class="dslca-plugin-opts-list-code" id='<?php echo $option_ID; ?>' name='<?php echo $option['name']; ?>' value='<?php echo esc_attr( $value ); ?>' />

		<?php
			$sidebars_array = array();
			if ( $value !== '' ) {

				$sidebars = $value;
				$sidebars_array = explode( ',', substr( $sidebars, 0, -1 ) );
			}
		?>

		<div class="dslca-plugin-opts-list">
			<?php foreach ( $sidebars_array as $sidebar ) : ?>
				<div class="dslca-plugin-opts-list-item">
					<span class="dslca-plugin-opts-list-title" contenteditable>
						<?php echo $sidebar; ?>
					</span>
					<a href="#" class="dslca-plugin-opts-list-delete-hook">
						<?php _e( 'delete', 'live-composer-page-builder' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div><!-- .dslca-plugin-opts-list -->

		<a href="#" class="dslca-plugin-opts-list-add-hook">
			<?php _e( 'Add New', 'live-composer-page-builder' ); ?>
		</a>

		<div class="dslca-plugin-opts-list-error">
			<?php _e( 'Items with duplicated titles found. Titles must be unique.', 'live-composer-page-builder' ); ?>
		</div>

	</div>

	<?php
	if ( isset( $option['descr'] ) ) :	?>

		<p class="description">
			<?php echo $option['descr']; ?>
		</p>
	<?php

	endif;

}

function dslc_plugin_option_display_styling_presets( $option ) {
	global $dslc_plugin_options;

	$section_ID = $option['section'];
	$option_ID = $option['id'];

	$presets = maybe_unserialize( get_option( 'dslc_presets' ) );

	?>

	<div class="dslca-plugin-opts-list-wrap">

		<?php /*
		<input type="hidden" class="dslca-plugin-opts-list-code" id='<?php echo $option_ID; ?>' name='<?php echo $section_ID; ?>[<?php echo $option_ID; ?>]' value='<?php echo esc_attr( $value ); ?>' />
		*/ ?>

		<div class="dslca-plugin-opts-list">
			<?php foreach ( $presets as $preset ) : ?>
				<div class="dslca-plugin-opts-list-item">
					<span class="dslca-plugin-opts-list-title" contenteditable>
						<?php echo $preset['title']; ?>
					</span>
					<a href="#" class="dslca-plugin-opts-list-delete-hook">
						<?php _e( 'delete', 'live-composer-page-builder' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div><!-- .dslca-plugin-opts-list -->

	</div>

	<?php
	if ( isset( $option['descr'] ) ) :	?>

		<p class="description">
			<?php echo $option['descr']; ?>
		</p>
	<?php

	endif;
}