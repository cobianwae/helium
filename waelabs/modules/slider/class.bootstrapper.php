<?php
	class WAE_slider_bootstrapper{
		
		function __construct(){
			WAE_slider_bootstrapper::instantiate('admin');
		}

		function action($action){
			add_action( $action, array( $this->front, 'display' ) );
		}

		static function load($class){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/class.'.$class.'.php' );
		}

		static function instantiate($class){
			WAE_slider_bootstrapper::load($class);
			$classname = 'WAE_slider_'.$class;
			return new $classname;
		}
	}
?>