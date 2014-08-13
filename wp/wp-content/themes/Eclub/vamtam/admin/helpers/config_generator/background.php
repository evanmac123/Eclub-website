<?php	
	$fields = array(
		'color' => __('Color:', 'church-event'),
		'opacity' => __('Opacity:', 'church-event'),
		'image' => __('Image / pattern:', 'church-event'),
		'repeat' => __('Repeat:', 'church-event'),
		'attachment' => __('Attachment:', 'church-event'),
		'position' => __('Position:', 'church-event'),
		'size' => __('Size:', 'church-event'),
	);

	$sep = isset($sep) ? $sep : '-';

	$current = array();

	if(!isset($only)) {
		if(isset($show)) {
			$only = explode(',', $show);
		} else {
			$only = array();
		}
	} else {
		$only = explode(',', $only);
	}

	$show = array();

	global $post;
	foreach($fields as $field=>$fname) {
		if(isset($GLOBALS['wpv_in_metabox'])) {
			$current[$field] = get_post_meta($post->ID, "$id-$field", true);
		} else {
			$current[$field] = wpv_get_option("$id-$field");
		}
		$show[$field] = (in_array($field, $only) || sizeof($only) == 0);
	}

	$selects = array(
		'repeat' => array(
			'no-repeat' => __('No repeat', 'church-event'),
			'repeat-x' => __('Repeat horizontally', 'church-event'),
			'repeat-y' => __('Repeat vertically', 'church-event'),
			'repeat' => __('Repeat both', 'church-event'),
		),
		'attachment' => array(
			'scroll' => __('scroll', 'church-event'),
			'fixed' => __('fixed', 'church-event'),
		),
		'position' => array(
			'left center' => __('left center', 'church-event'),
			'left top' => __('left top', 'church-event'),
			'left bottom' => __('left bottom', 'church-event'),
			'center center' => __('center center', 'church-event'),
			'center top' => __('center top', 'church-event'),
			'center bottom' => __('center bottom', 'church-event'),
			'right center' => __('right center', 'church-event'),
			'right top' => __('right top', 'church-event'),
			'right bottom' => __('right bottom', 'church-event'),
		),
	);
?>

<div class="wpv-config-row background clearfix <?php echo $class ?>">

	<div class="rtitle">
		<h4><?php echo $name?></h4>

		<?php wpv_description($id, $desc) ?>
	</div>

	<div class="rcontent">
		<div class="bg-inner-row">
			<?php if($show['color']): ?>
				<div class="bg-block color">
					<div class="single-desc"><?php _e('Color:', 'church-event') ?></div>
					<input name="<?php echo $id.$sep ?>color" id="<?php echo $id ?>-color" type="color" data-hex="true" value="<?php echo $current['color'] ?>" class="" />
				</div>
			<?php endif ?>

			<?php if($show['opacity']): ?>
				<div class="bg-block opacity range-input-wrap clearfix">
					<div class="single-desc"><?php _e('Opacity:', 'church-event') ?></div>
					<span>
						<input name="<?php echo $id.$sep?>opacity" id="<?php echo $id?>-opacity" type="range" value="<?php echo $current['opacity']?>" min="0" max="1" step="0.05" class="wpv-range-input" />
					</span>	
				</div>
			<?php endif ?>
		</div>

		<div class="bg-inner-row">
			<?php if($show['image']): ?>
				<div class="bg-block bg-image">
					<div class="single-desc"><?php _e('Image / pattern:', 'church-event') ?></div>
					<?php $_id = $id;	$id .= $sep.'image'; // temporary change the id so that we can reuse the upload field ?>
					<div class="image <?php wpv_static($value) ?>">
						<?php include 'upload-basic.php'; ?>
					</div>
					<?php $id = $_id; unset($_id); ?>
				</div>
			<?php endif ?>

			<?php if($show['size']): ?>
				<div class="bg-block bg-size">
					<div class="single-desc"><?php _e('Cover:', 'church-event') ?></div>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo $id.$sep?>size" value="cover" <?php checked($current['size'], 'cover') ?>/>
						<span><?php _e('On', 'church-event') ?></span>
					</label>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo $id.$sep?>size" value="auto" <?php checked($current['size'], 'auto') ?>/>
						<span><?php _e('Off', 'church-event') ?></span>
					</label>
				</div>
			<?php endif ?>

			<?php foreach($selects as $s=>$options): ?>
				<?php if($show[$s]): ?>
					<div class="bg-block bg-<?php echo $s?>">
						<div class="single-desc"><?php echo $fields[$s] ?></div>
						<select name="<?php echo "$id$sep$s" ?>" class="bg-<?php echo $s ?>">
							<?php foreach($options as $val=>$opt): ?>
								<option value="<?php echo $val?>" <?php selected($val, $current[$s]) ?>><?php echo $opt?></option>
							<?php endforeach ?>
						</select>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</div>