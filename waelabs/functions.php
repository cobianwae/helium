<?php 
	/**
	* Fires the theme : constants definition, core classes loading
	*
	* 
	* @package      COBIANWAE
	* @subpackage   classes
	* @since        1.0
	* @author       Cobian Wae <cobian.wae@gmail.com>
	* @copyright    Copyright (c) 2014, Cobianwae
	* @link         http://cobianwae.com/cobianwae
	* @license      http://www.gnu.org/licenses/gpl-3.0.html
	*/

	abstract class WAE {
		protected $config;

		function __construct(){
			$this->define_globals();
			$this->define_constants();
			$this->initiate_config();
			$this->define_config();
			$this->required_support();
			$this->initiate_options();
			$this->register_menus();
			$this->include_modules();
			$this->load_modules();
			add_action( 'widgets_init', array( $this, 'include_widgets' ) );
			add_action( 'widgets_init', array( $this, 'load_widgets' ) );
			$this->include_parts();
			$this->load_parts();
			add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
			add_action( 'widgets_init', array( $this, 'register_footer_widget_areas' ) );
			$this->fire_resources();
			add_filter('the_content', array( $this, 'shortcode_empty_paragraph_fix' ) );
		}

	    protected  function load_modules(){

	    }
	    protected  function load_widgets(){

	    }
	    
	    protected abstract function load_parts();
	    protected abstract function define_config();

	    private function initiate_config(){
	    	$this->config = array(
				'global-options' => null,
				'class-prefix' => 'Wae_',
				'content-width' => 960,
				'nav-menus' => array( 
					'primary' => __( 'Primary Menu', THEMENAME )
				),
				'sidebar-widget-areas' => array(
					array(
						'name' => __( 'Right Sidebar', THEMENAME),
						'id' => 'right-sidebar'
					)		
				),
				'footer-widget-areas' => array(),
				'admin-class' => 'wae_admin_config',
				'include-modules' => array(),
				'include-widgets' => array(),
				'include-parts' => array(),
			);
	    }

	    private function register_menus(){
	    	register_nav_menus( $this->config['nav-menus'] );
	    }

		protected function instantiate( $namespace, $in_waelabs = false ){
			$file_path = WAE_BASE;
			$namespace_length = count( $namespace );
			foreach ($namespace as $key => $suffix) {
				if ( $key == 0 ){
					$file_path .= $suffix.'/class.';
				}else if ( $namespace_length-1 != $key ){
					$file_path .= $suffix.'.';
				}else{
					$file_path .= $suffix.'.php';
				}
			}
			require_once( $file_path );
			$classname = $this->config['class-prefix'];
			if ( $in_waelabs ){
				$classname = 'WAE_';
			}
			for($i = 1; $i < $namespace_length; $i++){
				$classname .= $namespace[$i].'_';
			}
			$classname = rtrim( $classname, "_" );
            return  new $classname;
		}

		protected function load_module( $module_name ){
	    	$file_path = WAE_BASE;
			$file_path .= 'modules/'. $module_name .'/class.bootstrapper.php';
			require_once( $file_path );
			$classname = $this->config['class-prefix']. $module_name .'_bootstrapper';
            return new $classname;
	    }

	    protected function load_widget( $name ){
	    	$file_path = WAE_BASE.'/widgets/';
	    	require_once( $file_path.'class.'. $name . '.widget.php' );
			register_widget( $this->config['class-prefix'] . $name . '_widget' );
	    }

	    private function include_modules(){
	    	$module_names = $this->config['include-modules'];
	    	$file_path = WAE_BASE . 'waelabs/';
	    	foreach ($module_names as $key => $module_name) {
	    		require_once( $file_path ."modules/$module_name/class.bootstrapper.php" );
	    		$classname = 'WAE_' . $module_name . '_bootstrapper';
	    		new $classname;
	    	}
	    }

	    private function include_parts(){
	    	$base_namespace = array( 'waelabs/parts', 'parts', 'base' );
	    	$this->instantiate( $base_namespace, TRUE );
	    	$part_names = $this->config['include-parts'];
	    	foreach ($part_names as $key => $name) {
	    		$namespace = array( 'waelabs/parts', $name, 'main' );
	    		$this->instantiate( $namespace, TRUE );
	    	}
	    }

	    function include_widgets( ){
    		$file_path = WAE_BASE . 'waelabs';
	    	foreach ($this->config['include-widgets'] as $key => $widget) {
	    		require_once( $file_path .'/widgets/class.'. $widget . '.widget.php' );
				register_widget( 'WAE_' . $widget . '_widget' );
	    	}
	    }

	    private function define_globals(){
			global $need_scripts;
			global $admin_need_scripts;
			$need_scripts = array();
			$admin_need_scripts = array(); 
		}

		private	function define_constants(){
		    //get WP_Theme object
		    $wae_theme                     = wp_get_theme();
		    $wae_base_data['prefix']       = $wae_base_data['title'] = $wae_theme -> name;
		    $wae_base_data['version']      = $wae_theme -> version;
		    $wae_base_data['authoruri']    = $wae_theme -> {'Author URI'};
			 

			/* THEME_VER is the Version */
			if( ! defined( 'THEME_VER' ) )      { define( 'THEME_VER' , $wae_base_data['version'] ); }

			/* WAE_BASE is the root server path of the parent theme */
			if( ! defined( 'WAE_BASE' ) )            { define( 'WAE_BASE' , get_template_directory().'/' ); }

			/* WAE_BASE_CHILD is the root server path of the child theme */
			if( ! defined( 'WAE_BASE_CHILD' ) )      { define( 'WAE_BASE_CHILD' , get_stylesheet_directory().'/' ); }

			/* WAE_BASE_URL http url of the loaded parent theme*/
			if( ! defined( 'WAE_BASE_URL' ) )        { define( 'WAE_BASE_URL' , get_template_directory_uri() . '/' ); }

			/* THEMENAME contains the Name of the currently loaded theme */
			if( ! defined( 'THEMENAME' ) )          { define( 'THEMENAME' , $wae_base_data['title'] ); }

			/* WAE_WEBSITE is the home website of wae theme  */
			if( ! defined( 'WAE_WEBSITE' ) )         { define( 'WAE_WEBSITE' , $wae_base_data['authoruri'] ); }
		}

		function register_sidebar(){
			foreach ($this->config['sidebar-widget-areas'] as $key => $widget_area) {
				register_sidebar( array(
					'name' => $widget_area['name'],
					'id' => $widget_area['id'],
					'before_widget' => '<div class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h2>',
					'after_title' => '</h2>'
				) );
			}
		}

		function register_footer_widget_areas(){
			foreach ($this->config['footer-widget-areas'] as $key => $widget_area) {
				register_sidebar( array(
					'name' => $widget_area['name'],
					'id' => $widget_area['id'],
					'before_widget' => '<div class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h2>',
					'after_title' => '</h2>'
				) );
			}
		}

		function fire_resources(){
			$this->instantiate( array( 'waelabs/bootstrapper', 'fire', 'resources' ), true );
			$this->instantiate( array( 'waelabs/bootstrapper', 'fire', 'admin', 'resources' ), true );
		}

		 function initiate_options(){
		 	require_once(WAE_BASE. 'waelabs/options.php');
	    	if ( !class_exists( $this->config['admin-class'] ) && file_exists( WAE_BASE . 'admin/admin-init.php' ) ) {
	    	    require_once( WAE_BASE. 'admin/admin-init.php' );
	    	}
	    	global $wae;
	    	$wae = get_option($this->config['global-options']);
	    }

	    function required_support(){
			if(function_exists('add_theme_support')) {
				add_theme_support( 'automatic-feed-links' );
		  	} 
		  	global $content_width;
		  	if ( ! isset( $content_width ) ) $content_width = $this->config['content-width'];	
		}

		//helpers
	    static function resolve_scripts( $scripts ){
			global $need_scripts;
			foreach ($scripts as $key => $script) {
				if(!in_array($script,  $need_scripts)){
					array_push($need_scripts, $script);
				}
			}
		}

		static function admin_resolve_scripts( $scripts ){
			global $admin_need_scripts;
			foreach ( $scripts as $key => $script ) {
				if(!in_array($script,  $admin_need_scripts)){
					array_push($admin_need_scripts, $script);
				}
			}
		}

		function shortcode_empty_paragraph_fix($content){   
		    $array = array (
		        '<p>[' => '[', 
		        ']</p>' => ']', 
		        ']<br />' => ']'
		    );

		    $content = strtr($content, $array);
		    return $content;
		}
	}