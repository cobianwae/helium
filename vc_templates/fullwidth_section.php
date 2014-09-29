<?php
	extract( shortcode_atts( array(
		'background_image'  => ''
	), $atts ) );
	if ( $background_image != '' ) :
		$background_image = wp_get_attachment_url( $background_image );
		?>
		<div class="parallax-bg" style="background-image:url(<?php echo $background_image ?>)">
			<?php echo do_shortcode($content) ?>
		</div>
		<?php	
	endif;