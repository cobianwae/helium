<?php
	class HL_footer_main extends WAE_parts_base {
		function __construct() {
			parent::__construct();
			add_action( 'hl_sidebar', array( $this, 'display_sidebar' ) );
		}


		function display_sidebar() {
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('right-sidebar')) {
				echo '<p>there is not any widgets registered</p>';						
			}
		}
	}
?>