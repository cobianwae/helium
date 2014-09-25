<?php
	class WAE_shortcodes_fullwidth_section{
		function __construct(){
			add_shortcode('wae_fullwidth_section', array( $this, 'display' ) );
		}

		function display($atts, $content){
			
		}
	}
?>