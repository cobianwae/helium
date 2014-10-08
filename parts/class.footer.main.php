<?php
	class HL_footer_main extends WAE_parts_base {
		function __construct() {
			parent::__construct();
			add_action( 'hl_sidebar', array( $this, 'display_sidebar' ) );
			add_action( 'hl_main_footer', array( $this, 'display_main_footer') );
			add_action( 'widgets_init', array( $this, 'register_widget_area' ) );
		}

		function register_widget_area(){
			$footer_columns = $this->get_footer_columns();
			for ($i=1; $i <= $footer_columns ; $i++) { 
				register_sidebar(array(
					'name' => 'footer_' . $i,
					'before_widget' => '<div class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>'
					));
			}
		}


		function display_sidebar() {
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('right-sidebar')) {
				echo '<p>there is not any widgets registered</p>';						
			}
		}

		function display_main_footer() {
			$options = $this->options;
			if( !(!empty( $options['enable-main-footer-area'] ) && $options['enable-main-footer-area']) )
				return;
			$footer_columns = $this->get_footer_columns();
			$class_maps = array(
				2 => 'large-6',
				3 => 'large-4',
				4 => 'large-3'
			);

			echo '<div class="row main-footer first-row">
					<div class="footer-inner">';
			for ($i=1; $i <= $footer_columns ; $i++) {
				?><div class="medium-4 footer-<?php echo $i ?> <?php echo $class_maps[$footer_columns] ?> columns"><?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( 'footer_' . $i )) :
					echo '<p>there is not any widgets registered</p>';					
				endif;
				?></div><?php
			}
			echo 	'</div>
				  </div>';

		}

		private function get_footer_columns(){
			$options = $this->options;
			$footer_columns = 3;
			if ( !empty( $options['footer_columns'] ) ) $footer_columns = $options['footer_columns'];
			return $footer_columns;
		}
	}
?>