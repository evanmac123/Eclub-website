<?php
/**
 * drag&drop slider editor
 */

wp_localize_script('wpv_admin', 'sliderL10n', array(
	'slides' => __('Slides', 'church-event'),
	'html_slide' => __('New HTML slide', 'church-event'),
	'image_slide' => __('New image slide', 'church-event'),
	'delete_slider' => __('Delete slider', 'church-event'),
	'delete_slider_confirm' => __('Are you sure you want to delete this slider? This will also permanently delete its slides', 'church-event'),
	'delete_slide_confirm' => __('Do you want to delete this slide permanently?', 'church-event'),
	'please_add_slides' => __('Please add some slides', 'church-event'),
) );
?>

<div class="wpv-config-row slider-editor clearfix <?php echo $class ?>">
	<div class="rtitle">
		<?php if(!empty($name)): ?>
			<h4><?php echo $name?></h4>
		<?php endif ?>
	
		<?php wpv_description('slider-editor', $desc) ?>
	</div>
	
	<div class="rcontent">
		<input type="text" class="regular-text new-slider-name" />
		<input type="button" class="button add-new-slider" value="<?php _e('Add slider', 'church-event') ?>" />

		<div class="sliders">
		</div>
	</div>
</div>
