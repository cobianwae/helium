<?php
	class WAE_fire_admin_resources{
		function __construct(){
			add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_styles' ) );
			add_action( 'admin_footer', array( $this, 'load_scripts' ) );
		}

		function load_styles(){
			wp_enqueue_style('wp-color-picker');
		}

		function register_scripts(){
			wp_register_script( 'media-uploader',  WAE_BASE_URL.'js/media-uploader.js', array( 'jquery' ), null, $in_footer=true );
			wp_localize_script( 'media-uploader', 'metaData',
	            array(
	            	'image' => array(
	            		'title' => __( 'Choose or Upload an Image', THEMENAME ),
	            		'button' => __( 'Use this image', THEMENAME )
            		),
	            	'audio' => array(
	            		'title' => __( 'Choose or Upload an Audio File', THEMENAME ),
	            		'button' => __( 'Use this Audio File', THEMENAME ),
	            	),
	            	'video' => array(
	            		'title' => __( 'Choose or Upload a Video File', THEMENAME ),
	            		'button' => __( 'Use this Video File', THEMENAME )	
	            	)
	            )
	        );
		}

		function load_scripts(){
			global $admin_need_scripts;
			foreach ( $admin_need_scripts as $key => $script ) {
				wp_enqueue_script( $script );
			}

			if( in_array('wp-color-picker', $admin_need_scripts) ){
				?>
				<script>
					(function($){
						$(document).ready(function(){
							$('.color-picker').wpColorPicker();
						});
					}(jQuery))
				</script>
				<?php
			}
		}
	}
?>