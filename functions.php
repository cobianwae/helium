<?php 
	/**
	* Fires the theme : constants definition, core classes loading
	*
	* 
	* @package      Fluid
	* @subpackage   classes
	* @since        1.0
	* @author       Waelabs <wae.asu.labs@gmail.com>
	* @copyright    Copyright (c) 2014, Waelabs
	* @link         http://waelabs.com/fluid
	* @license      http://www.gnu.org/licenses/gpl-3.0.html
	*/
	
	require_once( dirname(__FILE__). '/waelabs/functions.php' );
 	class Fluid extends WAE {
		
		function __construct(){
			parent::__construct();
			$this->add_images_size();
		}

		function define_config(){
			$config = array(
				'class-prefix' => 'FL_',
				'admin-class' => 'fluid_admin_config',
				'include-widgets' => array(
					'about',
					'popular_posts',
					'recent_comments',
					'instagram'
				),
				'nav-menus' => array(
					'primary' => __( 'Primary Menu', THEMENAME ),
					'footer' => __( 'Footer Menu', THEMENAME )
				),
				'include-modules' => array(
					'profile_extras',
					'shortcodes',
					'post_format',
					'tinymce_dialog',
					'page_options'			
				),
				'include-parts' => array(
					'header',
					'footer',
					'content',
					'comment',
					'social'
				),
				'global-options' => 'fluid'
			);
			$this->config = array_merge( $this->config, $config );
		}

		function load_parts(){
			
		}

		function add_images_size(){
			add_image_size( 'landscape', 600, 185, array('center', 'center') );
			add_image_size( 'main-thumbnail', 600);
		}

	}

	new Fluid;