<?php
class WAE_page_options_bootstrapper{
		private $front;

		function __construct(){
			$this->instantiate('admin');
		}

		static function load($class){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/class.'.$class.'.php' );
		}

		static function instantiate($class){
			WAE_page_options_bootstrapper::load($class);
			$classname = 'WAE_page_options_'.$class;
			return new $classname;
		}

	}

?>