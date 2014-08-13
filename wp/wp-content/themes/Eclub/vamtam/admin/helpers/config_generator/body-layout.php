<?php
/**
 * adds several links that allow the user to easily set several predefined options
 */

$available_layouts = array(
	'full',
	'left-only',
	'right-only',
	'left-right',
);

$selected = wpv_get_option($id, $default);

?>

<div class="wpv-config-row body-layout <?php if(isset($class)) echo $class?>">
	<div class="rtitle">
		<h4><?php echo $name?></h4>

		<?php wpv_description($id, $desc) ?>
	</div>

	<div class="rcontent">
		<?php foreach($available_layouts as $layout): ?>
			<span class="layout-type">
				<label for="<?php echo $id.$layout?>" class="<?php if($selected == $layout) echo 'selected'?>"><img src="<?php echo WPV_ADMIN_ASSETS_URI?>images/body-<?php echo $layout?>.png" alt="" /></label>
				<input type="radio" name="<?php echo $id?>" id="<?php echo $id.$layout?>" value="<?php echo $layout?>" class="<?php wpv_static($value)?>" <?php checked($selected, $layout)?>/>
			</span>
		<?php endforeach ?>
		<?php if(isset($has_default) && $has_default): ?>
			<span class="layout-type default">
				<input type="radio" name="<?php echo $id?>" id="<?php echo $id?>default" value="default" class="<?php wpv_static($value)?>" <?php checked($selected, 'default')?>/>
				<label for="<?php echo $id?>default" class="<?php if($selected == 'default') echo 'selected'?>">Default</label>
			</span>
		<?php endif ?>
	</div>
</div>
