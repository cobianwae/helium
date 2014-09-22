<?php
	class WAE_shortcodes_row{
		function __construct(){
			add_shortcode('wae_row', array($this, 'row'));
			add_shortcode('wae_column', array($this, 'column'));
		}

		function column( $attr, $content ){
			$map = array('1' => 12, '1/2' => 6, '1/3'=>4, '1/4'=> 3, '2/5' => 5, '3/5' => 7);
			extract(shortcode_atts(array('type' => '1'),$attr));
			$class = 'large-'.$map[$type].' medium-'.$map[$type]; 
			$content = rtrim($content);
			return "<div class='$class columns' >".do_shortcode($content)."</div>";
		}

		function row( $attr, $content ){
			return '<div class="row">'.do_shortcode($content).'</div>';
		}
	}
?>