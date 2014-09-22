<?php
	class WAE_profile_extras_bootstrapper{
		function __construct(){
			$this->instantiate('admin');
		}
		static function load($class){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/class.'.$class.'.php' );
		}

		static function instantiate($class){
			WAE_profile_extras_bootstrapper::load($class);
			$classname = 'WAE_profile_extras_'.$class;
			return new $classname;
		}
	}
?>