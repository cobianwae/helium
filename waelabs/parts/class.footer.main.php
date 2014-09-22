<?php
	class WAE_footer_main extends WAE_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'wae_copyright', array( $this, 'display_copyright' ) );
		}

		function display_copyright(){
			$options = $this->options;
			if(!empty($options['wae_copyright'])){
				echo $options['wae_copyright'];
			}else{
				echo date("Y").' &copy; '.get_bloginfo('name'); 
			}
		}
	}
?>