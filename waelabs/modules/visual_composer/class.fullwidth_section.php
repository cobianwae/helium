<?php
	class WAE_vc_fullwidth_section{
		function __construct(){
			add_action('vc_before_init', array($this, 'fullwidth_dialog'));
		}

		function fullwidth_dialog(){
			vc_map(array(
				'name' => __('Fullwidth Section', THEMENAME),
				'base' => 'wae_fullwidth_section',
				'class' => '',
				'category' => __('Content', THEMENAME),
				'params' => array(
					array(
						'type' => 'colorpicker',
						'holder' => 'div',
						'class' => '',
						'heading' => __('Background Color', THEMENAME),
						'param_name' => 'backgroud_color',
						'value' => '',
						'description' => __('Pick the color for you background', THEMENAME)
					),
					array(
						'type' => 'attach_image',
						'holder' => 'div',
						'class' => '',
						'heading' => __('Background Image', THEMENAME),
						'param_name' => 'backgroud_image',
						'value' => '',
						'description' => __('Upload an image for you background', THEMENAME)
					),
					array(
						'type' => 'textfield',
						'holder' => 'div',
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
?>