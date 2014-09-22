<?php
	class WAE_shortcodes_our_fields{
		function __construct(){
			add_shortcode('wae_our_fields', array($this, 'display'));
		}

		function display(  $attr, $content ){
			extract(shortcode_atts(array( 'align' => 'center', 'is_active' => '0', 'short_desc' => __( 'Short Description', THEMENAME ), 'icon' => 'fa fa-cubes' ),$attr));
			$class = '';
			if($is_active == '1'){
				$class='active';
			}
			return "<div class='our-fields-wrapper $class' style='text-align:$align' ><i class='$icon our-fields'></i><span class='our-fields-title'>$short_desc</span></div>";
		}
	}
?>