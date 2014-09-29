<?php
	class WAE_vc_fullwidth_section{
		function __construct(){
			add_action('vc_before_init', array($this, 'fullwidth_dialog'));
		}

		function fullwidth_dialog(){
			vc_map(array(
				'name' => __('Fullwidth Section', THEMENAME),
				'base' => 'fullwidth_section',
				'class' => '',
				'is_container' => true,
			   	'content_element' => true,
			   	'js_view' => 'VcColumnView',
				'category' => __('Content', THEMENAME),
				'params' => array(
					array(
						'type' => 'colorpicker',
						'class' => '',
						'heading' => __('Background Color', THEMENAME),
						'param_name' => 'background_color',
						'value' => '',
						'description' => __('Pick the color for you background', THEMENAME)
					),
					array(
						'type' => 'attach_image',
						'class' => '',
						'heading' => __('Background Image', THEMENAME),
						'param_name' => 'background_image',
						'value' => '',
						'description' => __('Upload an image for you background', THEMENAME)
					),
					array(
						'type' => 'textfield',
						'class' => '',
						'heading' => __('Padding Top', THEMENAME),
						'param_name' => 'padding_top',
						'value' => '',
						'description' => __('Padding top for fullwidth area', THEMENAME)
					)
				)
			));
			
		}
	}
	// Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
			if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			    class WPBakeryShortCode_Fullwidth_Section extends WPBakeryShortCodesContainer {
			    }
			}
?>