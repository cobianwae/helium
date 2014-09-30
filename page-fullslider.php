<?php
/*
Template Name: Page With Slider
*/
	get_header();
	?>
		<div class="content fullscreen-slider-enabled">
			<?php do_action('wae_slider') ?>
		</div>
	<?php
	get_footer();