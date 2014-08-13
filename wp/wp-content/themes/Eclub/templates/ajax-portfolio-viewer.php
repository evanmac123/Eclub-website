<?php
/**
 * Ajax portfolio viewer template
 *
 * @package wpv
 * @subpackage church-event
 */
?>
<div id="portfolio-viewer">
	<div class="slider-wrapper">
		<div id="ajax-portfolio-slider-big"></div>
		<div class="vamtam-slider-loading-mask"></div>
		<div id="thumbs-bar">
			<div class="prev"></div>
			<div class="next"></div>
			<div class="scroller"></div>
		</div>
	</div>
	<div class="portfolio-viewer-wrap">
		<div class="content row"></div>
	</div>

	<style>
		#ajax-portfolio-slider-big {
			<?php WpvTemplates::title_style() ?>
		}
	</style>
</div>