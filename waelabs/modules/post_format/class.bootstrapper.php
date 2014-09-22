<?php 
	class WAE_post_format_bootstrapper{
		function __construct(){
			$this->instantiate('admin');
		}
		static function load($class){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/class.'.$class.'.php' );
		}

		static function instantiate($class){
			WAE_post_format_bootstrapper::load($class);
			$classname = 'WAE_post_format_'.$class;
			return new $classname;
		}
	}
?>