<?php $content = trim($content);?>
<div class="team-member<?php echo (!empty($content) ? ' has-content' : '')?>">
	<?php if(!empty($picture)): ?>
	<div class="thumbnail">
		<?php if(!empty($url)):?>
			<a href="<?php echo $url ?>" title="<?php echo $name?>" class="">
		<?php endif ?>
			<?php wpv_lazy_load($picture, $name,class="circle-img")?>
		<?php if(!empty($url)):?>
			</a>
		<?php endif ?>
	</div>
	<?php endif ?>
	<div class="team-member-info">
		<h4>
			<?php if(!empty($url)):?>
				<a href="<?php echo $url ?>" title="<?php echo $name?>">
			<?php endif ?>
				<?php echo $name?>
			<?php if(!empty($url)):?>
				</a>
			<?php endif ?>
		</h4>
		<?php if(!empty($position)): ?>
			<h6 class="team-member-position"><?php echo $position ?></h6>
		<?php endif ?>
		<?php if(!empty($email)):?>
			<div><a href="mailto:<?php echo $email ?>" title="<?php printf(__('email %s', 'church-event'), $name)?>"><?php echo $email?></a></div>
		<?php endif ?>
		<?php if(!empty($phone)):?>
			<div class="team-member-phone"><?php echo $phone?></div>
		<?php endif ?>
		<div class="share-icons clearfix">
			<?php
				$icons = explode(' ', 'googleplus linkedin facebook twitter youtube');
				foreach($icons as $icon): if(!empty($$icon)):  // that's not good enough, should be changed
					$icon_name = apply_filters('wpv_team_member_social_icon', $icon);
			?>
					<a href="<?php echo $$icon?>" title=""><?php echo do_shortcode('[icon name="'.$icon_name.'"]'); ?></a>
			<?php endif; endforeach; ?>
		</div>
	</div>
</div>
