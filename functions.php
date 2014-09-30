<?php 
	/**
	* Fires the theme : constants definition, core classes loading
	*
	* 
	* @package      Helium
	* @subpackage   classes
	* @since        1.0
	* @author       Waelabs <wae.asu.labs@gmail.com>
	* @copyright    Copyright (c) 2014, Waelabs
	* @link         http://waelabs.com/helium
	* @license      http://www.gnu.org/licenses/gpl-3.0.html
	*/
	
	require_once( dirname(__FILE__). '/waelabs/functions.php' );
 	class Helium extends WAE {
		
		function __construct(){
			parent::__construct();
			$this->add_images_size();
			add_action( 'vc_before_init', array( $this, 'vc_as_theme' ) );
			// add_action( 'init', array($this, 'vc_row_extend') );
		}

		function define_config(){
			$config = array(
				'class-prefix' => 'HL_',
				'admin-class' => 'helium_admin_config',
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
					'page_options',
					'slider',
					'visual_composer'			
				),
				'include-parts' => array(
					'header',
					'footer',
					'content',
					'comment',
					'social',
					'slider'
				),
				'global-options' => 'helium'
			);
			$this->config = array_merge( $this->config, $config );
		}

		function load_parts(){
			$this->instantiate(array('parts','header','main'));
		}

		function add_images_size(){
			add_image_size( 'landscape', 600, 185, array('center', 'center') );
			add_image_size( 'main-thumbnail', 600);
		}

		function vc_as_theme(){
			vc_set_as_theme();
		}

		// function vc_row_extend(){
		// 	$vc_row = WPBMap::getShortCode('vc_column');
		// 	// var_dump($vc_row);
		// 	// exit;
		// }

	}

	new Helium;